<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateAllUserRequest;
use App\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Lista de Usuarios';
        $data['array'] = Auth::user()->role == 'superadmin' ? User::where('id','<>',Auth::user()->id)->where('role','<>','sponsored')->orderBy('full_name','ASC')->get() : Auth::user()->sponsored;
        return view('dashboard.users.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Crear Usuario';
        $data['array'] = null;
        $data['action'] =  route('user.store');
        $data['view'] = false;
        $data['method'] = 'POST';
        $data['groups'] = Group::orderBy('name','ASC')->get();
        return view('dashboard.users.form')->with('data',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        DB::beginTransaction();
        try{
            $user = new User($request->only('full_name','dni','phone','user','bank_account_number','role','group_id','sponsor_id'));
            $user->password= bcrypt($request->password);

            if(env('APP_DEBUG')){
                $user->created_at = session('day');
            }
            if(Auth::user()->role == 'admin'){
                $user->admin_id = Auth::user()->id;
            }
            if(Auth::user()->role == 'sponsored'){
                $user->admin_id = Auth::user()->admin_id;
            }
            $user->save();
            DB::commit();
            return response(['message' => 'Se ha creado el usuario corrrectamente','redirect'=>route('user.index')]);
        }catch(QueryException $e){
            DB::rollBack();
            return response(['message'=> 'QueryException :'.$e->getMessage(),'type' => 'error']);
        }catch(Exception $e){
            DB::rollBack();
            return response(['message'=> 'Exception :'.$e->getMessage(),'type' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $data['title'] = 'Ver Información del Usuario';
        $data['array'] = $user;
        $data['action'] =  null;
        $data['view'] = true;
        $data['method'] = null;
        $data['groups'] = Group::orderBy('name','ASC')->get();
        return view('dashboard.users.form')->with('data',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data['title'] = 'Editar Información del Usuario';
        $data['array'] = $user;
        $data['action'] =  route('user.update',$user->id);
        $data['view'] = false;
        $data['method'] = 'PUT';
        $data['groups'] = Group::orderBy('name','ASC')->get();
        return view('dashboard.users.form')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAllUserRequest $request, User $user)
    {
        DB::beginTransaction();
        try{

            $user->fill($request->only('full_name','dni','phone','user','bank_account_number','role','group_id','sponsor_id','state'));
            $user->password= bcrypt($request->password);
            if($request->state !== 'disabled'){
                $user->access = true;
            }

            if(strrpos($request->state,'not') !== false){
                $user->access = false;
            }
            $user->save();
            DB::commit();
            return response(['message' => 'Se ha actualizado la información del usuario corrrectamente']);
        }catch(QueryException $e){
            DB::rollBack();
            return response(['message'=> 'QueryException :'.$e->getMessage(),'type' => 'error']);
        }catch(Exception $e){
            DB::rollBack();
            return response(['message'=> 'Exception :'.$e->getMessage(),'type' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try{
            $user->delete();
            DB::commit();
            return response(['message' => 'Se ha eliminado al usuario corrrectamente','function'=> 'reload']);
        }catch(QueryException $e){
            DB::rollBack();
            return response(['message'=> 'QueryException :'.$e->getMessage(),'type' => 'error']);
        }catch(Exception $e){
            DB::rollBack();
            return response(['message'=> 'Exception :'.$e->getMessage(),'type' => 'error']);
        }
    }

}
