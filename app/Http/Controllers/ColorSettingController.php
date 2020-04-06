<?php

namespace App\Http\Controllers;

use App\ColorSetting;
use App\Http\Requests\UpdateColorRequest;
use Illuminate\Http\Request;

class ColorSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Lista de Estados de patrocinadores';
        $data['array'] = ColorSetting::orderBy('id','ASC')->get();
        return view('dashboard.colors.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ColorSetting  $colorSetting
     * @return \Illuminate\Http\Response
     */
    public function show(ColorSetting $colorSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ColorSetting  $colorSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(ColorSetting $colorSetting)
    {
        $data['title'] = 'Editar color '.$colorSetting->name;
        $data['array'] = $colorSetting;
        $data['action'] = route('colorSetting.update',$colorSetting->id);
        $data['method'] = 'PUT';
        $data['view'] = false;

        return view('dashboard.colors.form')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ColorSetting  $colorSetting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateColorRequest $request, ColorSetting $colorSetting)
    {
        $colorSetting->color = $request->color;
        $colorSetting->background = $request->background;
        $colorSetting->save();
        return response()->json(['message' => 'Se actualizaron los colores del estado: '.$colorSetting->name,'redirect' => route('colorSetting.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ColorSetting  $colorSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(ColorSetting $colorSetting)
    {
        //
    }
}
