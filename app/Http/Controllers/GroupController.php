<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Lista de Grupos';
        $data['array'] = Group::orderBy('name','ASC')->get();
        return view('dashboard.groups.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Crear Grupo';
        $data['array'] = null;
        $data['action'] =  route('group.store');
        $data['view'] = false;
        $data['method'] = 'POST';
        return view('dashboard.groups.form')->with('data',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGroupRequest $request)
    {
        DB::beginTransaction();
        try{
            $group = new Group($request->only('name','branch','fee'));
            $group->save();
            DB::commit();
            return response(['message' => 'Se ha creado el grupo corrrectamente','function'=>'reset_form']);
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
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $data['title'] = 'Ver información del Grupo';
        $data['array'] = $group;
        $data['action'] =  null;
        $data['view'] = true;
        $data['method'] = null;
        return view('dashboard.groups.form')->with('data',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $data['title'] = 'Editar Grupo';
        $data['array'] = $group;
        $data['action'] =  route('group.update',$group->id);
        $data['view'] = false;
        $data['method'] = 'PUT';
        return view('dashboard.groups.form')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        DB::beginTransaction();
        try{
            $group->name = $request->name;
            $group->branch = $request->branch;
            $group->fee = $request->fee;
            $group->save();
            DB::commit();
            return response(['message' => 'Se ha editado el grupo corrrectamente']);
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
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        DB::beginTransaction();
        try{
            $group->delete();
            DB::commit();
            return response(['message' => 'Se ha editado el grupo corrrectamente','function' => 'reload']);
        }catch(QueryException $e){
            DB::rollBack();
            return response(['message'=> 'QueryException :'.$e->getMessage(),'type' => 'error']);
        }catch(Exception $e){
            DB::rollBack();
            return response(['message'=> 'Exception :'.$e->getMessage(),'type' => 'error']);
        }
    }
}
