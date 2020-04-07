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
        'full_name', 'dni', 'phone','bank_account_number','state','access','user','password','role','sponsor_id','group_id','admin_id','id'
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
        return $this->hasMany('App\User','sponsor_id')->orderBy('id','ASC');
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

    public function isThirdReturnDay(){
        return Dates::between($this->thirdReturn(),$this->thirdReturn().'23:00:00',session('day'));
    }

    public function isReturnDay(){
        return ($this->role == 'sponsored' && ($this->isFirstReturnDay() || $this->isSecondReturnDay() ||  $this->isThirdReturnDay() ) ) || ($this->role == 'admin' && $this->existsPioneersToReturn());
    }

    public function pioneersToReturn(){
        $day = Dates::getNameDay(session('day'));
        $pioneers = [];
        if($day == 'Miercoles' || $day == 'Sabado'){

            $pioneers = User::where([
                ['id','<>',$this->id],
                ['sponsor_id',$this->id],
                ['role','sponsored']
                ])
                ->where(function($query){
                    $query
                    ->where('created_at','=',date('Y-m-d',strtotime('13 days ago',strtotime(session('day')))))
                    ->orWhere('created_at','=',date('Y-m-d',strtotime('12 days ago',strtotime(session('day')))))
                    ->orwhere('created_at','=',date('Y-m-d',strtotime('23 days ago',strtotime(session('day')))))
                    ->orWhere('created_at','=',date('Y-m-d',strtotime('22 days ago',strtotime(session('day')))))
                    ->orWhere('created_at','=',date('Y-m-d',strtotime('34 days ago',strtotime(session('day')))))
                    ->orWhere('created_at','=',date('Y-m-d',strtotime('33 days ago',strtotime(session('day')))));
                })
            ->orderBy('id','DESC')->get();

        }
        return $pioneers;
    }

    public function existsPioneersToReturn(){
        return (count($this->pioneersToReturn()) > 0);
    }


    public function getDebtors($aux = 2,$delete_prev = true,$debtors = null,$index = 0){
        $debtors = $debtors ? $debtors : array();

        if(count($debtors) == 0 && count($this->sponsored) > 0 && $index == 0){
            foreach ($this->sponsored as $key => $value) {
                $object = ['level' => $index, 'sponsored' => $value,'key' => $key ];
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
            $ref = 0;
            foreach ($aux_array as $value) {
                foreach ($value['sponsored']->sponsored as $key => $sponsored) {
                    $object = ['level' => $index, 'sponsored' => $sponsored,'key' => $ref++];
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

    public function fee(){
        $fee = 0;

        if($this->isFirstReturnDay()){
            return array_reduce($this->getDebtors(3,true),function($carry, $item){
                if($item->state == 'payed' ||$item->state == 'registered'){
                    return $carry += $item->group->fee;
                }
            })*0.50;
        }
        if($this->isSecondReturnDay()){
            return array_reduce($this->getDebtors(3,true),function($carry, $item){
                if($item->state == 'payed' ||$item->state == 'return-1'){
                    return $carry += $item->group->fee;
                }
            })*0.50;
        }
        if($this->isThirdReturnDay()){
            return array_reduce($this->getDebtors(3,true),function($carry, $item){
                if($item->state == 'return-1' || $item->state == 'return-2'){
                    return $carry += $item->group->fee;
                }
            })*0.10;
        }

        return $fee;
    }

    public function realFee(){
        $fee = 0;

        if($this->isFirstReturnDay()){
            return array_reduce($this->getDebtors(3,true),function($carry, $item){
                if($item->state == 'payed'){
                    return $carry += $item->group->fee;
                }
                return $carry;
            })*0.50;
        }
        if($this->isSecondReturnDay()){
            return array_reduce($this->getDebtors(3,true),function($carry, $item){
                if($item->state == 'return-1'){
                    return $carry += $item->group->fee;
                }
                return $carry;
            })*0.50;
        }
        if($this->isThirdReturnDay()){
            return array_reduce($this->getDebtors(3,true),function($carry, $item){
                if($item->state == 'return-2'){
                    return $carry += $item->group->fee;
                }
                return $carry;
            })*0.10;
        }

        return $fee;
    }

    public function return(){
        return (($this->isFirstReturnDay() && $this->state == 'return-1' ) || ($this->isSecondReturnDay() && $this->state == 'return-2') || ($this->isThirdReturnDay() && $this->state == 'return-3'));
    }


    public function getDebtorsChildren($items,$limit){
        $childrens = '';
        if ($limit < 10 && $items != null) {
            $childrens .= '<ul>';
            foreach ($items as $value) {
                $childrens.='<li><span id="'.$value->id.'" class="'.$value->state.'"><h3>'.$value->full_name.'</h3><div class="actions"><a class="btn btn-edit" href="'.route('branch', $value->id).'" target="_blank"><i class="fas fa-sitemap"></i></a><a class="btn btn-view" href="'.route('user.show', $value->id).'"target="_blank"><i class="fas fa-eye"></i></a></div></span>';

                $childrens .= count($value->sponsored) >0 ? $this->getDebtorsChildren($value->sponsored,++$limit)  : '</li>';
            }
            $childrens .='</ul>';
        }
        return $childrens;
    }

    public function getDebtorsTree($parent, $limit = 0){
        return '<ul class="tree"><span class="master" id="'. $parent->id.'">'.$parent->full_name.'</span>'.$this->getDebtorsChildren($parent->sponsored,$limit).'</ul>';
    }

    public function disabledBranch($parent = null){
        $parent = $parent == null ? $this : $parent;
        if(count($parent->sponsored) > 0){
            foreach ($parent->sponsored as $child) {
                $child->access = false;
                $child->save();
                $child->disabledBranch($child);
            }
        }
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
                return 'PAGÓ';
            break;
            case 'return-1':
                return 'RETORNO 1';
            break;
            case 'return-2':
                return 'RETORNO 2';
            break;
            case 'return-3':
                return 'RETORNO 3';
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
