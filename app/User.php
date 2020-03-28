<?php

namespace App;

use App\Helpers\Dates;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'dni', 'phone','bank_account_number','state','access','user','password','role','sponsor_id','group_id','admin_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sponsored(){
        return $this->hasMany('App\User','sponsor_id');
    }

    public function admin(){
        return  $this->belongsTo('App\User','admin_id');
    }

    public function firstRegisterDay(){
        if( ($this->registerDay() == 'Lunes' ||$this->registerDay() == 'Viernes' ) && $this->access  ){
            return date('Y-m-d',strtotime('+3 days',strtotime($this->created_at)));
        }
        if($this->registerDay() == 'Martes' && $this->access){
            return date('Y-m-d',strtotime('+2 days',strtotime($this->created_at)));
        }
        if($this->registerDay() == 'Jueves' && $this->access){
            return date('Y-m-d',strtotime('+4 days',strtotime($this->created_at)));
        }
    }

    public function lastRegisterDay(){
        return date('Y-m-d',strtotime('+1 Day',strtotime($this->firstRegisterDay())));
    }

    public function limitToPay(){
        return $this->registerDay() == 'Jueves' || $this->registerDay() == 'Lunes' ? date('Y-m-d',strtotime('+1 day',strtotime($this->created_at))) : date('Y-m-d',strtotime($this->created_at));
    }

    public function firstCollect(){
        return $this->registerDay() == 'Jueves' || $this->registerDay() == 'Viernes' ? date('Y-m-d',strtotime('second Monday',strtotime($this->created_at))) : date('Y-m-d',strtotime('second Thursday',strtotime($this->created_at))) ;
    }

    public function limitFirstCollect(){
        return date('Y-m-d',strtotime('+1 day',strtotime($this->firstCollect())));
    }

    public function isFirstCollectionDay(){
        return Dates::between($this->firstCollect(),$this->limitFirstCollect(),session('day'));
    }

    public function secondCollect(){
        return ($this->registerDay() == 'Jueves' || $this->registerDay() == 'Viernes') ? date('Y-m-d',strtotime('third Thursday',strtotime($this->created_at))) : date('Y-m-d',strtotime('third Monday',strtotime($this->created_at)) )  ;
    }

    public function limitSecondCollect(){
        return date('Y-m-d',strtotime('+1 day',strtotime($this->secondCollect())));
    }

    public function isSecondCollectionDay(){
        return Dates::between($this->secondCollect(),$this->limitSecondCollect(),session('day'));
    }

    public function thirdCollect(){
        return ($this->registerDay() == 'Jueves' || $this->registerDay() == 'Viernes') ? date('Y-m-d',strtotime('fifth Monday',strtotime($this->created_at))) : date('Y-m-d',strtotime('fifth Thursday',strtotime($this->created_at)) )  ;
    }

    public function limitThirdCollect(){
        return date('Y-m-d',strtotime('+1 day',strtotime($this->thirdCollect())));
    }

    public function isThirdCollectionDay(){
        return Dates::between($this->thirdCollect(),$this->limitThirdCollect(),session('day'));
    }

    public function isSponsoredCollectionDay(){
        return ($this->role == 'sponsored') && ($this->isFirstCollectionDay());
    }

    public function isAdminCollectionDay(){
        return ($this->role == 'admin') && count($this->getDebtors(2,false)) > 0;
    }

    public function isCollectionDay(){
        return $this->role != 'superadmin' && ( $this->isSponsoredCollectionDay() ||$this->isAdminCollectionDay() );
    }

    public function isMonitorDay(){
        return ($this->role == 'sponsored') && ($this->isSecondCollectionDay() || $this->isThirdCollectionDay());
    }


    public function firstReturn(){
        return date('Y-m-d',strtotime('+1 day',strtotime($this->limitFirstCollect())));
    }

    public function isFirstReturnDay(){
        return Dates::between($this->firstReturn(),$this->firstReturn().'23:00:00',session('day'));
    }

    public function secondReturn(){
        return date('Y-m-d',strtotime('+1 day',strtotime($this->limitSecondCollect())));
    }

    public function isSecondReturnDay(){
        return Dates::between($this->secondReturn(),$this->secondReturn().'23:00:00',session('day'));
    }

    public function thirdReturn(){
        return date('Y-m-d',strtotime('+1 day',strtotime($this->limitThirdCollect())));
    }

    public function isThirdDay(){
        return Dates::between($this->thirdReturn(),$this->thirdReturn().'23:00:00',session('day'));
    }

    public function isReturnDay(){
        return ($this->role == 'sponsored') && ($this->isFirstReturnDay() || $this->isSecondReturnDay() ||  $this->isThirdDay() );
    }


    public function getDebtors($aux = 2,$delete_prev = true,$debtors = null,$index = 0){
        $debtors = $debtors ? $debtors : array();

        if(count($debtors) == 0 && count($this->sponsored) > 0 && $index == 0){
            foreach ($this->sponsored as $key => $value) {
                $object = ['level' => $index, 'sponsored' => $value];
                array_push($debtors,$object);
            }
        }

        if(count($debtors) > 0 && $index != 0){
            if($delete_prev){
                $debtors = array_filter($debtors,function($element) use ($index){
                    return $element['level'] == $index - 1;
                });
            }
            $aux_array = array_filter($debtors,function($element) use ($index){
                return $element['level'] == $index - 1;
            });
            foreach ($aux_array as $value) {
                foreach ($value['sponsored']->sponsored as $key => $sponsored) {
                    $object = ['level' => $index, 'sponsored' => $sponsored];
                    array_push($debtors,$object);
                }
            }
        }
        if($aux == 1){
            if($delete_prev){
                $debtors = array_filter($debtors,function($element) use ($index){
                    return $element['level'] == $index;
                });
            }
            return array_map(function($element){ return $element['sponsored'];},array_unique($debtors,SORT_REGULAR)) ;
        }
        $aux--;
        $index++;
        return $this->getDebtors($aux,$delete_prev, $debtors,$index);
    }

    public function sponsor(){
        return $this->belongsTo('App\User','sponsor_id');
    }

    public function group(){
        return $this->belongsTo('App\Group');
    }

    public function whoToPay(){
        $sponsor = $this;
        for ($i=0; $i <3 ; $i++) {
            if( $sponsor->sponsor && $sponsor->role != 'admin'){
                $sponsor =$sponsor->sponsor;
            }
        }
        return $sponsor;
    }

    public function whoToPayFirstReturn(){
        $sponsor = $this;
        for ($i=0; $i <3 ; $i++) {
            if( $sponsor->sponsor && $sponsor->role != 'admin'){
                $sponsor =$sponsor->sponsor;
            }
        }
        return $sponsor;
    }

    public function getRole(){
        switch ($this->role) {
            case 'superadmin':
                return 'SUPER ADMINISTRADOR';
                break;
            case 'admin':
                return 'ADMINISTRADOR';
            break;
            case 'sponsored':
                return 'PATROCINADOR';
        }
    }
    public function getState(){
        switch ($this->state) {
            case 'registered':
                return 'REGISTRADO';
                break;
            case 'payed':
                return 'HA PAGADO';
            break;
            case 'disabled':
                return 'DESHABILITADO';
            break;
            case 'finished':
                return 'FINALIZADO';
            break;

        }
    }

    public function payment(){
            return $this->state == 'payed';
    }

    public function whichDayisToday(){
        if($this->registerDay() == 'Lunes' || $this->registerDay() == 'Jueves'){
            return Dates::diff(session('day'),$this->created_at);
        }

        return (Dates::diff(session('day'),$this->created_at) + 1);
    }
    public function isMyRegisterDay(){
        if($this->registerDay() == 'Lunes' && $this->access && ($this->whichDayisToday() == 3 || $this->whichDayisToday() == 4) ){
            return true;
        }
        if($this->registerDay() == 'Martes' && $this->access && ($this->whichDayisToday() == 2 || $this->whichDayisToday() == 3  )){
            return true;
        }
        if($this->registerDay() == 'Jueves' && $this->access && ($this->whichDayisToday() == 4|| $this->whichDayisToday() == 5  )){
            return true;
        }
        if($this->registerDay() == 'Viernes' && $this->access && ($this->whichDayisToday() == 3 || $this->whichDayisToday() == 4 )){
            return true;
        }


        return false;
    }


    public function isMyPaymentDay(){
         return ($this->whichDayisToday() <= 1 && Dates::mustPay());
    }

    public function registerDay(){
        return  Dates::getNameDay($this->created_at);
    }


    public function canAdd(){
        return ($this->role =='superadmin' || ($this->role == 'admin' && Dates::canRegister()) || ($this->role == 'sponsored' && Dates::canRegister() && $this->sponsored->count() < $this->group->branch && $this->isMyRegisterDay()));
    }
}
