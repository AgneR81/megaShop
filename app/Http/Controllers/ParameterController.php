<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Responsetinka begio
     */
    public function index()
    {
        $parameters = Parameter::all();
        return view('parameter.index', ['parameters' => $parameters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parameter.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parameter = new Parameter;
        $parameter->title = $request->title;
        $parameter->data_type = $request->data_type;
        $parameter->save();
        return redirect()->route('parameter.index')->with('success_message', 'Sekmingai įrašytas.');
  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function show(Parameter $parameter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function edit(Parameter $parameter)
    {
      
        return view('parameter.edit', ['parameter' => $parameter]);
  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parameter $parameter)
    {
        $parameter->title = $request->title;
        $parameter->data_type = $request->data_type;
        $parameter->save();
        return redirect()->route('parameter.index')->with('success_message', 'Sėkmingai pakeistas.');
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parameter $parameter)
    {
        if($parameter->categories->count()){
            return redirect()->route('parameter.index')->with('info_message', 'Trinti negalima, nes parametras irasytas i kategorija.');

        }
        $parameter->delete();
        return redirect()->route('parameter.index')->with('success_message', 'Sekmingai ištrintas.');

    }
}