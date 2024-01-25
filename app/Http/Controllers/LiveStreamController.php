<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Models\Evaluation;
use App\Models\Livestream;
use App\Models\Payment;
use App\Models\Webinar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;


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

        if(\Auth::user()->role_id == 0){
            $livestream=Livestream::get();
        }else{
            $livestream=Livestream::where('status', 1)->get();
        }

        
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
            $webinar=Payment::with('livestream','user', 'user.role')->where('stream_id','>','0')->get();

        }else{
            $record = Evaluation::with('user', 'user.role')->where('user_id',\Auth::user()->id)->where('webinar_id','>','0')->where('webinar_type', 'livestream')->get();
            $webinar=Payment::with('livestream','user', 'user.role')->where('user_id',\Auth::user()->id)->where('stream_id','>','0')->get();
        }

        // dd($record->toArray(), $webinar->toArray());
        $section=$this->section;
        $section->heading="Live Stream Evaluation";
        $section->title="Live Stream Evaluation";

        return view($section->folder.'.evaluation',compact('section','record','webinar'));

    }

    public function evaluation_form(Request $request)
    {
        checkPermission('create-webinar');
        $section=$this->section;
        $web = [];

        if(\Auth::user()->role_id == 0){
            $webinar=Payment::with('livestream','user', 'user.role')->where('stream_id','>','0')->get();

        }else{
            $webinar=Payment::with('livestream','user', 'user.role')->where('user_id',\Auth::user()->id)->where('stream_id','>','0')->get();
        }

        $section->route=$section->slug.".evaluation_create";
        $section->method="post";
        return view($section->folder.'.evaluation_form',compact('web','section', 'webinar'));
    }

    public function evaluation_create(Request $request){
        $section=$this->section;
        Evaluation::create($request->all());
        $request->session()->flash('alert-success', 'Record has been added successfully.');
        return redirect()->route('livestream.evolution');

    }

    public function evolution_show($id){
        checkPermission('evaluation-webinar');

        $record = Evaluation::with('user')->where('id',$id)->first();

        $section=$this->section;
        $section->heading="View Evaluation LiveStream";
        
        return view($section->folder.'.evaluation_view',compact('section','record'));
    }

    public function buy(Request $request){

        // dd($request->toArray());
        checkPermission('buy-livestream');

        $this->generatePayment($request);

        $section=$this->section;

        \session()->flash('alert-success', 'Stream Appointment has been booked successfully.');
        return redirect()->back();
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


    public function generatePayment($request){

        $card['card_number'] = $request->card_number;
        $card['card_name'] = $request->card_name;
        $card['card_month'] = $request->card_month;
        $card['card_year'] = $request->card_year;
        $card['card_cvv'] = $request->card_cvv;

    //    dd('Stripe Payment Integration work TODO - Webinar', serialize($card), $request->toArray());
        
        if($request->niche == 'livestream'){
            $data = Livestream::where('id', $request->id)->first();
            if(\Auth::user()->role_id == 2){
                $amount = $data->pro_price;
            }elseif(\Auth::user()->role_id == 3){
                $amount = $data->g_pub_price;
            }
            else {
                $amount = $data->g_pub_price;
            }
            $description = 'Purchase Live Stream From '. env('APP_NAME') .' | Name: ' . $data->related . ' | dated : ' . Carbon::parse(Carbon::now())->format('d M Y');
        }
        else {
            $data = Webinar::where('chapter_name', $request->id)->where('chapter_type', $request->type)->first();
            if(\Auth::user()->role_id == 2){
                $amount = $data->pro_price;
            }elseif(\Auth::user()->role_id == 3){
                $amount = $data->g_pub_price;
            }
            else {
                $amount = $data->g_pub_price;
            }
            $description = 'Purchase Webinar From '. env('APP_NAME') .' | Webinar Name: ' . $data->related . ' | dated : ' . Carbon::parse(Carbon::now())->format('d M Y');
        }

        /**************** Stripe Work Start ****************/
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = Customer::create(array(
            "address" => [
                "line1" => auth()->user()->address,
                "postal_code" => auth()->user()->postal_code,
                "city" => auth()->user()->city,
                "state" => auth()->user()->state,
                "country" => auth()->user()->country,
            ],
            "email" => auth()->user()->email,
            "name" => auth()->user()->name,
            "source" => $request->stripeToken
        ));


        $stripePayment = Charge::create ([
            "amount" => $amount * 100,
            "currency" => "usd",
            "customer" => $customer->id,
            "description" => $description,
        ]);
        /**************** Stripe Work End ****************/
//        dd($stripePayment);

        $payment = new Payment();
        if($request->niche == 'webinar'){
            $payment->webinar_id = $request->id;
            \session()->flash('alert-success', 'Webinar Purchased successfully.');
        }
        else {
            $payment->stream_id = $request->id;
            \session()->flash('alert-success', 'Stream Purchased successfully.');
        }
        $payment->amount = $request->amount;
        $payment->payment_detail = serialize($card);
        $payment->user_id = \Auth::user()->id;
        $payment->txn_id = $stripePayment->id;
        $payment->user_type = \Auth::user()->role_id;
        $payment->save();

        return true;
    }
}
