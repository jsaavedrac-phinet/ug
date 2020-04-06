<?php

namespace App\Http\Controllers;

use App\ColorSetting;
use App\Helpers\Dates;
use App\Http\Requests\DayRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
class DashboardController extends Controller
{
    public function __construct()
    {
        if(session('day') == null){
            session(['day' => date(now())]);
        }
    }

    public function home(){
        return view('dashboard.home');
    }

    public function profile(){
        return  view('dashboard.profile');
    }

    public function update_profile(UpdateUserRequest $request)
    {
            DB::beginTransaction();
            try {
                Auth::user()->full_name = $request->full_name;
                Auth::user()->bank_account_number = $request->bank_account_number;

                $login = false;
                if ($request->password != "") {
                    Auth::user()->password = bcrypt($request->password);
                    Auth::user()->save();
                    Auth::logout();
                    $login = true;
                }else{
                    Auth::user()->save();
                }

                DB::commit();
                if($login){
                    return response()->json(["message"=>"Se ha realizado el cambio de clave con éxito","type" => "success","redirect"=>route('login')]);
                }
                return response()->json(["message"=>"Se ha realizado el cambio con éxito","type" => "success"]);
            }catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                return response()->json(["message"=>"Ocurrió un error en el procedimiento<br><h5>Error: ".$e->getMessage()."</h5>","type" => "error"]);
            }
            catch(\Exception $e){
                return response()->json(["message"=>"Ha ocurrido un error : ".$e->getMessage(),"type" => "error"]);
            }

    }
    public function repayment(){
        return view('dashboard.repayment');
    }

    public function payment(User $user){
       $user->state = $user->state == 'registered' ? 'payed' : 'registered';
       $user->save();
        return response(['message' => 'Estado actualizado con éxito','function' =>'reload']);
    }

    public function changeDay(){
        $data['title'] = 'Establece el dia';
        $data['action'] = route('updateDay');
        return view('dashboard.day')->with('data',$data);
    }

    public function updateDay(DayRequest $request){
        session(['day'=> $request->day]);
        return response(['message' => 'Se cambio el dia a: '.session('day'),'function' => 'reload']);
    }

    public function collect(){
        $data['title'] = 'Lista de Usuarios por Cobrar';
        if(Auth::user()->role == 'sponsored'){
            if(Auth::user()->isFirstCollectionDay()){
                $data['array'] = Auth::user()->getDebtors(3,true);
            }
        }
        if(Auth::user()->role == 'admin'){
            $data['array'] =$this->paginate(Auth::user()->getDebtors(2,false),70);
            $data['array']->withPath('collect');
        }
        return view('dashboard.collection')->with('data',$data);
    }

    public function monitor(){
        $data['title'] = 'Lista de usuarios que estan cobrando, ayúdalos!';
        if(Auth::user()->role == 'sponsored'){
            if(Auth::user()->isSecondCollectionDay()){
                $data['array'] = Auth::user()->getDebtors(3,true);
            }
            if(Auth::user()->isThirdCollectionDay()){
                $data['array'] = Auth::user()->getDebtors(3,true);
            }
        }
        return view('dashboard.monitor')->with('data',$data);
    }


    public function paginate($items, $perPage = 5, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function branch(User $user){
        $data['title'] = 'Mi rama';
        $data['array'] =$user->getDebtors(9,false);
        if($user->role == 'superadmin'){
            $data['array'] = User::orderBy('id','DESC')->where('role','<>','superadmin')->paginate(70);
        }

        if($user->role == 'admin'){
            $data['array'] = User::orderBy('id','DESC')->where('admin_id','=',$user->id)->paginate(70);
        }


        if($user->role == 'sponsored'){
            $data['array'] = $user->getDebtorsTree($user);
            return view('dashboard.branchTree')->with('data',$data);
        }
        return view('dashboard.branch')->with('data',$data);
    }


    public function calendar(){
        $data['title'] = 'Mi calendario';
        return view('dashboard.calendar')->with('data',$data);
    }

    public function return(){
        $data['title'] = 'Lista de Usuarios por Cobrar';
        $data['array'] = [];
        if(Auth::user()->isSecondReturnDay()){
            $data['array'] = array_filter(Auth::user()->getDebtors(3,true),function($element){ return ($element->state == 'payed' || $element->state == 'return-1')  ? true : false;});
        }
        if(Auth::user()->isThirdReturnDay()){
            $data['array'] = array_filter(Auth::user()->getDebtors(3,true),function($element){ return ($element->state == 'return-1' ||$element->state == 'return-2')  ? true : false;});
        }

        if(Auth::user()->role == 'admin'){
            $data['array'] = Auth::user()->pioneersToReturn();
        }


        return view('dashboard.return')->with('data',$data);
    }

    public function update_return(User $user){
        if($user->isFirstReturnDay()){
            $user->state = ($user->state == 'return-1') ? 'payed' : 'return-1';
        }
        if($user->isSecondReturnDay()){
            $user->state = ($user->state == 'return-2') ? 'return-1' : 'return-2';
        }
        if($user->isThirdReturnDay()){
            $user->state = ($user->state == 'return-3') ? 'return-2' : 'return-3';
        }




        $user->save();
        return response(['message' => 'Estado actualizado con éxito','function' =>'reload']);

    }

}
