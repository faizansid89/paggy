<?php

namespace App\Http\Controllers;

use App\Models\Certificates;
use App\Models\Evaluation;
use App\Models\Livestream;
use App\Models\Payment;
use App\Models\Webinar;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'Certificate';
        $this->section->heading = 'Certificate';
        $this->section->slug = 'certificate';
        $this->section->folder = 'certificate';
    }
    public function index()
    {
        dd('Certificate Work TODO');
        // checkPermission('index-webinar');
        $section = $this->section;
        $certificates = Certificates::get();

        return view($section->folder.'.index',compact('section','web'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // checkPermission('create-webinar');
        $section=$this->section;
        $this->section->title = 'Create New Certificate';
        $certificates=[];
        $section->route= "webinar.certificate.store";
        $section->method="post";
        return view($section->folder.'.form',compact('certificates','section'));
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

        if ($request->hasFile('pdf')) {
            $image = $request->file('pdf');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('files'), $imageName);

            // Save the image file path or perform any other operations
        }
        $request->request->add([ 'file' => $imageName]);

        Webinar::create($request->all());
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


    public function buy($id){
        checkPermission('buy-webinar');
        $live=Webinar::where('id',$id)->first();
    //    dd($live->toArray());
        if(\Auth::user()->role_id == 2){
            $amount = $live->pro_price;
        }elseif(\Auth::user()->role_id == 3){
            $amount = $live->g_pub_price;
        }
        else {
            $amount = $live->g_pub_price;
        }

        //yahan payment lagy giu

        $payment=[
            'webinar_id'=>$id,
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



    public function booked(){
        checkPermission('booked-webinar');
        if(\Auth::user()->role_id == 0){
            $record = Payment::with('webinar','user','role')->where('webinar_id','>','0')->get();
        }else{
            $record = Payment::with('webinar')->where('user_id',\Auth::user()->id)->where('webinar_id','>','0')->get();
        }
        // dd($record);
        $section=$this->section;
        $section->heading="Booked Webinar";
        return view($section->folder.'.booked',compact('section','record'));
    }


    public function evolution(){
        checkPermission('evaluation-webinar');

        if(\Auth::user()->role_id == 0){
            $record = Evaluation::with('user', 'user.role')->where('webinar_id','>','0')->get();
            $webinar=Payment::with('webinar','user', 'user.role')->where('webinar_id','>','0')->get();

        }else{
            $record = Evaluation::with(['user' => function($q) {
                $q->where('role_id', '=', auth()->user()->role_id);
            }, 'user', 'user.role'])->where('user_id',\Auth::user()->id)->where('webinar_id','>','0')->get();
            $webinar=Payment::with('webinar','user', 'user.role')->where('user_id',\Auth::user()->id)->where('webinar_id','>','0')->get();
        }

        // dd($record->toArray(), $webinar->toArray());
        $section=$this->section;
        $section->heading="Evaluation Webinar";
        return view($section->folder.'.evaluation',compact('section','record','webinar'));

    }

    public function evaluation_create(Request $request){
        $section=$this->section;
        Evaluation::create($request->all());
        $request->session()->flash('alert-success', 'Record has been added successfully.');
        return redirect()->route('webinar.evolution');

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





    public function general(){
        checkPermission('booked-webinar');
        if(\Auth::user()->role_id == 0){
            $record = Payment::with('webinar','user','role')->where('user_type',3)->where('webinar_id','>','0')->get();
        }
        //dd($record);
        $section=$this->section;
        $section->heading="Booked Webinar";
        return view($section->folder.'.booked',compact('section','record'));
    }

    public function professional(){
        checkPermission('booked-webinar');
        if(\Auth::user()->role_id == 0){
            $record = Payment::with('webinar','user','role')->where('user_type',2)->where('webinar_id','>','0')->get();
        }

        $section=$this->section;
        $section->heading="Booked Webinar";
        return view($section->folder.'.booked',compact('section','record'));
    }


    public function general_wE(){
        checkPermission('booked-webinar');
        
        
        if(\Auth::user()->role_id == 0){
            $record = Evaluation::with(['user' => function($q) {
                $q->where('role_id', '=', 3);
            }, 'user.role'])->where('webinar_id','>','0')->get();
            // $webinar=Payment::with('webinar','user', 'user.role')->where('user_type', 2)->where('webinar_id','>','0')->get();
            // dd($record->toArray(), auth()->user()->id);
        }else{
            $record = Evaluation::with(['user' => function($q) {
                $q->where('role_id', '=', 3);
            }, 'user', 'user.role'])->where('user_id',\Auth::user()->id)->where('webinar_id','>','0')->get();
            // $webinar=Payment::with('webinar','user', 'user.role')->where('user_type', 2)->where('user_id',\Auth::user()->id)->where('webinar_id','>','0')->get();
        }
        //dd($record);
        $section=$this->section;
        $section->heading="General Public Webinar Evaluation";
        return view($section->folder.'.evaluation',compact('section','record'));
    }

    public function professional_wE(){
        checkPermission('booked-webinar');
        
        
        if(\Auth::user()->role_id == 0){
            $record = Evaluation::with('user')->where('webinar_id','>','0')->get();
            $webinar=Payment::with('webinar','user', 'user.role')->where('user_type', 3)->where('webinar_id','>','0')->get();

        }else{
            $record = Evaluation::where('user_id',\Auth::user()->id)->where('webinar_id','>','0')->get();
            $webinar=Payment::with('webinar','user', 'user.role')->where('user_type', 3)->where('user_id',\Auth::user()->id)->where('webinar_id','>','0')->get();
        }

        $section=$this->section;
        $section->heading="General Profession Education Evaluation";
        return view($section->folder.'.evaluation',compact('section','record', 'webinar'));
    }

    public function assessment(Request $request){
        $section = $this->section;
        dd('Assessment Work TODO');

        Evaluation::create($request->all());
        $request->session()->flash('alert-success', 'Record has been added successfully.');
        return redirect()->route('webinar.evolution');

    }


    public function certificate(){
        // checkPermission('evaluation-webinar');

        if(\Auth::user()->role_id == 0){
            $record = Evaluation::with('user', 'user.role')->where('webinar_id','>','0')->get();
            $webinar=Payment::with('webinar','user', 'user.role')->where('webinar_id','>','0')->get();

        }else{
            $record = Evaluation::with(['user' => function($q) {
                $q->where('role_id', '=', auth()->user()->role_id);
            }, 'user', 'user.role'])->where('user_id',\Auth::user()->id)->where('webinar_id','>','0')->get();
            $webinar=Payment::with('webinar','user', 'user.role')->where('user_id',\Auth::user()->id)->where('webinar_id','>','0')->get();
        }

        // dd($record->toArray(), $webinar->toArray());
        $section=$this->section;
        $section->heading="Evaluation Webinar";
        return view($section->folder.'.evaluation',compact('section','record','webinar'));

    }

}
