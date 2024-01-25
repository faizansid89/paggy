<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Models\Evaluation;
use App\Models\Livestream;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LiveStreamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'LiveStream';
        $this->section->heading = 'LiveStream';
        $this->section->slug = 'livestream';
        $this->section->folder = 'livestream';
    }
    public function index()
    {
        checkPermission('index-livestream');
        $section = $this->section;
        $livestream=Livestream::get();
        return view($section->folder.'.index',compact('section','livestream'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        checkPermission('create-livestream');
        $section=$this->section;
        $livestream=[];
        $section->route=$section->slug.".store";
        $section->method="post";
        return view($section->folder.'.form',compact('livestream','section'));

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    public function store(Request $request)
    {

        $section=$this->section;
        Livestream::create($request->all());
        $request->session()->flash('alert-success', 'Record has been added successfully.');
        return redirect()->route($section->slug.'.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
    public function edit(Livestream $livestream)
    {
        $section = $this->section;
        $section->title = 'Edit Live Streaming';
        $section->method = 'PUT';
        $section->route = [$section->slug.'.update', $livestream];
        return view($section->folder.'.form',compact('section', 'livestream'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Livestream $livestream)
    {
        $section = $this->section;

        $validationMessages = [
            'link.unique' => 'Link already exist. Please enter a unique Link',
        ];
        // validate user input
        $validator =  Validator::make($request->all(), [
            'link' => 'required|string|unique:livestreams,link,'. $livestream->id . ',id',
            'status' => 'required|boolean',
        ], $validationMessages);
    
        //validation fails
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        } else {
            $livestream->update($request->all());
            $request->session()->flash('alert-success', 'Record has been updated successfully.');
            return redirect()->route($section->slug . '.index');
        }
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

    public function booked(){
        checkPermission('booked-livestream');
        if(\Auth::user()->role_id == 0){
            $record = Payment::with('livestream','user','role')->where('stream_id','>','0')->get();
        }else{
            $record = Payment::with('livestream')->where('user_id',\Auth::user()->id)->where('stream_id','>','0')->get();
        }

        $section=$this->section;
        $section->heading="Booked Streams";
        return view($section->folder.'.booked',compact('section','record'));
    }

    public function evolution(){
        checkPermission('evaluation-webinar');

        if(\Auth::user()->role_id == 0){
            $record = Evaluation::with('user', 'user.role')->where('webinar_id','>','0')->where('webinar_type', 'livestream')->get();
            $webinar=Payment::with('webinar','user', 'user.role')->where('webinar_id','>','0')->get();

        }else{
            $record = Evaluation::with('user', 'user.role')->where('user_id',\Auth::user()->id)->where('webinar_id','>','0')->where('webinar_type', 'livestream')->get();
            $webinar=Payment::with('webinar','user', 'user.role')->where('user_id',\Auth::user()->id)->where('webinar_id','>','0')->get();
        }

        // dd($record->toArray(), $webinar->toArray());
        $section=$this->section;
        $section->heading="Live Stream Evaluation";
        return view($section->folder.'.evaluation',compact('section','record','webinar'));

    }

    public function evaluation_create(Request $request){
        $section=$this->section;
        Evaluation::create($request->all());
        $request->session()->flash('alert-success', 'Record has been added successfully.');
        return redirect()->route('livestream.evolution');

    }

    public function evolution_show($id){
        checkPermission('evaluation-webinar');

        if(\Auth::user()->role_id == 0){
            $record = Evaluation::with('user')->where('webinar_id','>','0')->where('id',$id)->first();
            $webinar=Payment::with('webinar','user')->where('webinar_id','>','0')->get();

        }else{
            $record = Evaluation::where('user_id',\Auth::user()->id)->where('webinar_id','>','0')->where('id',$id)->first();
            $webinar=Payment::with('webinar')->where('user_id',Auth::user()->id)->where('webinar_id','>','0')->get();
        }

    dd($record->toArray());
        $section=$this->section;
        $section->heading="Evaluation Webinar";
        return view($section->folder.'.evaluation',compact('section','record','webinar'));

    }

    public function buy($id){
        checkPermission('buy-livestream');

        $live=Livestream::where('id',$id)->first();
        if(\Auth::user()->role_id == 2){
            $amount = $live->pro_price;
        }elseif(\Auth::user()->role_id == 3){
            $amount = $live->g_pub_price;
        }

        //yahan payment lagy giu

        $payment=[
            'stream_id'=>$id,
            'amount'=>$amount,
            'user_id'=>\Auth::user()->id,
            'txn_id'=>1111,
            'user_type'=>\Auth::user()->role_id,
        ];

        $section=$this->section;
        Payment::create($payment);
        \session()->flash('alert-success', 'Stream Appointment has been booked successfully.');
        return redirect()->route($section->slug.'.index');
    }


    public function general(){
        checkPermission('booked-livestream');
        if(\Auth::user()->role_id == 0){
            $record = Payment::with('livestream','user','role')->where('user_type',3)->where('stream_id','>','0')->get();
        }
        //dd($record);
        $section=$this->section;
        $section->heading="Booked Streams";
        return view($section->folder.'.booked',compact('section','record'));
    }

    public function professional(){
        checkPermission('booked-livestream');
        if(\Auth::user()->role_id == 0){
            $record = Payment::with('livestream','user','role')->where('user_type',2)->where('stream_id','>','0')->get();
        }

        $section=$this->section;
        $section->heading="Booked Streams";
        return view($section->folder.'.booked',compact('section','record'));
    }


}
