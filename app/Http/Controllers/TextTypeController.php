<?php

namespace App\Http\Controllers;

use App\Models\TextType;
use Illuminate\Http\Request;

class TextTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'System Setting';
        $this->section->heading = '';
        $this->section->slug = 'text';
        $this->section->folder = 'system_setting';
    }
    public function index()
    {
        $section = $this->section;
       // $setting=[];
        $text=TextType::get();
        //$section->method = 'POST';
        $section->heading="Text Type";
       // $section->route = $section->slug.'.store';
        return view($section->folder.'.text_type.index', compact( 'section','text'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $section = $this->section;
        $text=[];
        $section->method = 'POST';
        $section->heading="Text Type";
        $section->route = $section->slug.'.store';
        return view($section->folder.'.text_type.form', compact( 'section','text'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        TextType::create($request->all());
        \session()->flash('message','Record Inserted');
        return redirect()->route('text.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function get_text($id){
        $text=TextType::where('type',$id)->first();
        return response()->json($text);
    }


    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
