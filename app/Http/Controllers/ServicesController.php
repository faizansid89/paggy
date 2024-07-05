<?php

namespace App\Http\Controllers;

use App\Models\Appoinment;
use App\Models\ClinicalSupervisionForm;
use App\Models\ConsultationForm;
use App\Models\ExpertTestimonyForm;
use App\Models\Payment;
use App\Models\Services;
use App\Models\ServiceTiming;
use App\Models\TherapyForm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Validator;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;


class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'Services';
        $this->section->heading = 'Services';
        $this->section->slug = 'services';
        $this->section->folder = 'services';
    }
    public function index()
    {
        // checkPermission('read-user');
        $section = $this->section;
        $services = Services::get();
        return view($section->folder.'.index', compact('services', 'section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Add Service';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';
       
        return view($section->folder.'.form',compact('section', 'service'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // checkPermission('create-user');
        $section = $this->section;

        //define custom validation messages for validator
        $validationMessages = [
        ];
        // validate user input
        $validator =  Validator::make($request->all(), [
            'title' => 'required|string'
        ], $validationMessages);

        //validation fails
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        } else {
            if($request->file('thumbnail_file')){
                $image = $request->file('thumbnail_file');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('attachments'),$imageName);
                $imageNameAfterUpload = '/attachments/'.$imageName;
                $request->request->add(['thumbnail' => asset($imageNameAfterUpload)]);
                $request->request->remove('thumbnail_file');
            }

            Services::create($request->except(['thumbnail_file']));
            $request->session()->flash('alert-success', 'Record has been added successfully.');
            return redirect()->route($section->slug.'.index');
        }
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
    public function edit(Services $services, $id)
    {
        // checkPermission('update-user');
        $service = Services::with('serviceTiming')->where('id', $id)->first();
        
        $section = $this->section;
        $section->title = 'Edit Service';
        $section->method = 'PUT';
        $section->route = [$section->slug.'.update', $service];
        
        return view($section->folder.'.form',compact('section', 'service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    { 
        checkPermission('update-user');
        $section = $this->section;

        //define custom validation messages for validator
        $validationMessages = [
        ];
        // validate user input
        $validator = Validator::make($request->all(), [
        ], $validationMessages);

        //validation fails
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        } else {
            if($request->file('thumbnail_file')){
                $image = $request->file('thumbnail_file');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('attachments'),$imageName);
                $imageNameAfterUpload = '/attachments/'.$imageName;
                $request->request->add(['thumbnail' => asset($imageNameAfterUpload)]);
                $request->request->remove('thumbnail_file');
            }

            Services::where('id',$id)->update($request->except(['thumbnail_file', '_token', '_method', 'service']));

            // dd($request->toArray(), 'asdsa', $id);

            ServiceTiming::where('service_id', $id)->delete();

            // dd($request->service);

            foreach($request->service as $service){
                $serviceTiming = new ServiceTiming();
                $serviceTiming->service_id = $id;
                $serviceTiming->service_type = $service['type'];
                $serviceTiming->service_time = $service['time_start'] .' - '. $service['time_end'];
                $serviceTiming->service_day = $service['day'];
                $serviceTiming->service_price = $service['price'];
                $serviceTiming->save();
            }            
           
            $request->session()->flash('alert-success', 'Record has been updated successfully.');
            return redirect()->back();
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


    public function form_one(Request $request)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Therapy';
        $section->method = 'POST';
        $section->route = $section->slug.'.therapySubmit';
       
        return view($section->folder.'.form_one',compact('section', 'service'));
    }

    public function therapySubmit(Request $request)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Therapy';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';

        $request->request->add(['user_id' => auth()->user()->id]);

        // dd('therapySubmit', $request->toArray());
        TherapyForm::create($request->all());

        // $request->session()->flash('alert-success', 'Record has been added successfully.');
        // return redirect()->route($section->slug.'.index');
        $request->request->add(['service_id' => 1]);

        $carbonDate = Carbon::parse($request->appoinment_date);
        $dayOfWeek = $carbonDate->format('l');
        
        $serviceTiming = ServiceTiming::where('service_id', $request->service_id)->where('service_type', $request->appoinment_type)->where('service_day', $dayOfWeek)->first();
        if(isset($serviceTiming)){
            $appointment = new Appoinment();
            $appointment->service_id = $serviceTiming->service_id;
            $appointment->user_id =  auth()->user()->id;
            $appointment->service_type =  $serviceTiming->service_type;
            $appointment->service_time =  $serviceTiming->service_time;
            $appointment->service_date = $request->appoinment_date;
            $appointment->service_day =  $serviceTiming->service_day;
            $appointment->service_price =  $serviceTiming->service_price;
            $appointment->save();
        }        
        $request->session()->flash('alert-success', 'Record has been added successfully.');
        return redirect()->route($section->slug.'.servicePaymentID', ['id' => encrypt($appointment->id)]);
    }

    public function form_two(Request $request)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Clinical Supervision';
        $section->method = 'POST';
        $section->route = $section->slug.'.clinicalSupervisionSubmit';
       
        return view($section->folder.'.form_two',compact('section', 'service'));
    }

    public function clinicalSupervisionSubmit(Request $request)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Clinical Supervision';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';

        $request->request->add(['user_id' => auth()->user()->id]);

        // dd('Clinical Supervision', $request->toArray());
        ClinicalSupervisionForm::create($request->all());

        // $request->session()->flash('alert-success', 'Record has been added successfully.');
        // return redirect()->route($section->slug.'.index');
        $request->request->add(['service_id' => 2]);

        $carbonDate = Carbon::parse($request->appoinment_date);
        $dayOfWeek = $carbonDate->format('l');
        
        $serviceTiming = ServiceTiming::where('service_id', $request->service_id)->where('service_type', $request->appoinment_type)->where('service_day', $dayOfWeek)->first();
        if(isset($serviceTiming)){
            $appointment = new Appoinment();
            $appointment->service_id = $serviceTiming->service_id;
            $appointment->user_id =  auth()->user()->id;
            $appointment->service_type =  $serviceTiming->service_type;
            $appointment->service_time =  $serviceTiming->service_time;
            $appointment->service_date = $request->appoinment_date;
            $appointment->service_day =  $serviceTiming->service_day;
            $appointment->service_price =  $serviceTiming->service_price;
            $appointment->save();
        }        
        $request->session()->flash('alert-success', 'Record has been added successfully.');
        return redirect()->route($section->slug.'.servicePaymentID', ['id' => encrypt($appointment->id)]);
    }

    public function form_three(Request $request)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Consultation';
        $section->method = 'POST';
        $section->route = $section->slug.'.consultationSubmit';
       
        return view($section->folder.'.form_three',compact('section', 'service'));
    }

    public function consultationSubmit(Request $request)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Consultation';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';

        $request->request->add(['user_id' => auth()->user()->id]);

        // dd('Clinical Supervision', $request->toArray());
        ConsultationForm::create($request->all());

        // $request->session()->flash('alert-success', 'Record has been added successfully.');
        // return redirect()->route($section->slug.'.index');
        $request->request->add(['service_id' => 3]);

        $carbonDate = Carbon::parse($request->appoinment_date);
        $dayOfWeek = $carbonDate->format('l');
        
        $serviceTiming = ServiceTiming::where('service_id', $request->service_id)->where('service_type', $request->appoinment_type)->where('service_day', $dayOfWeek)->first();
        if(isset($serviceTiming)){
            $appointment = new Appoinment();
            $appointment->service_id = $serviceTiming->service_id;
            $appointment->user_id =  auth()->user()->id;
            $appointment->service_type =  $serviceTiming->service_type;
            $appointment->service_time =  $serviceTiming->service_time;
            $appointment->service_date = $request->appoinment_date;
            $appointment->service_day =  $serviceTiming->service_day;
            $appointment->service_price =  $serviceTiming->service_price;
            $appointment->save();
        }        
        $request->session()->flash('alert-success', 'Record has been added successfully.');
        return redirect()->route($section->slug.'.servicePaymentID', ['id' => encrypt($appointment->id)]);
    }

    public function form_four(Request $request)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Expert Testimony';
        $section->method = 'POST';
        $section->route = $section->slug.'.expertTestimonySubmit';
       
        return view($section->folder.'.form_four',compact('section', 'service'));
    }

    public function expertTestimonySubmit(Request $request)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Consultation';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';

        $request->request->add(['user_id' => auth()->user()->id]);

        ExpertTestimonyForm::create($request->all());

        $request->request->add(['service_id' => 4]);

        $carbonDate = Carbon::parse($request->appoinment_date);
        $dayOfWeek = $carbonDate->format('l');
        
        $serviceTiming = ServiceTiming::where('service_id', $request->service_id)->where('service_type', $request->appoinment_type)->where('service_day', $dayOfWeek)->first();
        if(isset($serviceTiming)){
            $appointment = new Appoinment();
            $appointment->service_id = $serviceTiming->service_id;
            $appointment->user_id =  auth()->user()->id;
            $appointment->service_type =  $serviceTiming->service_type;
            $appointment->service_time =  $serviceTiming->service_time;
            $appointment->service_date = $request->appoinment_date;
            $appointment->service_day =  $serviceTiming->service_day;
            $appointment->service_price =  $serviceTiming->service_price;
            $appointment->save();
        }        
        $request->session()->flash('alert-success', 'Record has been added successfully.');
        return redirect()->route($section->slug.'.servicePaymentID', ['id' => encrypt($appointment->id)]);
    }

    public function servicePayment(Request $request, $id)
    {
        $appoinment = Appoinment::where('id', decrypt($id))->first();
        $service = Services::where('id', $appoinment->service_id)->first();
        
        // checkPermission('create-user');
        $section = $this->section;
        $section->title = $service->title . " Payment";
        $section->method = 'POST';
        $section->route = $section->slug.'.servicePayment';
       
        // dd($appoinment->service_id, $service->toArray());
        return view($section->folder.'.service_payment',compact('section', 'service', 'appoinment'));
    }


    public function servicePaymentPost(Request $request)
    {
        $section = $this->section;
        $section->title = 'Payment Recevied Status';
       
        $card['card_number'] = $request->card_number;
        $card['card_name'] = $request->card_name;
        $card['card_month'] = $request->card_month;
        $card['card_year'] = $request->card_year;
        $card['card_cvv'] = $request->card_cvv;


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

        $description = 'Appoinment ID: '. $request->appoinment_id . ' Purchase Service ID: '.$request->id .' for Amount: '. $request->amount;
         
        $stripePayment = Charge::create ([
            "amount" => $request->amount * 100,
            "currency" => "usd",
            "customer" => $customer->id,
            "description" => $description,
        ]);
        /**************** Stripe Work End ****************/
        
        $payment = new Payment();
        $payment->service_id = $request->id;
        $payment->amount = $request->amount;
        $payment->payment_detail = serialize($card);
        $payment->user_id = \Auth::user()->id;
        $payment->txn_id = $stripePayment->id;
        $payment->user_type = \Auth::user()->role_id;
        $payment->save();

        \session()->flash('alert-success', 'Service Purchased successfully.');
        
        $appoinment = Appoinment::where('id', $request->appoinment_id)->first();
        $appoinment->payment_id = $payment->id;
        $appoinment->save();

        // return true;

        // dd($appoinment->service_id, $service->toArray());
        return view($section->folder.'.service_payment_received',compact('section', 'appoinment', 'stripePayment'));
    }


    public function getServiceDays(Request $request)
    {
        // $serviceTiming = ServiceTiming::where('service_id', $request->service_id)->where('service_type', $request->service_type)->get();
        $serviceDays = ServiceTiming::where('service_id', $request->service_id)
        ->where('service_type', $request->service_type)
        ->distinct()
        ->pluck('service_day');
        return $serviceDays->toArray();
    }

    public function getServiceDayTimings(Request $request)
    {
        // dd($request->toArray());
        $serviceTiming = ServiceTiming::where('service_id', $request->service_id)->where('service_day', $request->service_day)->where('service_type', $request->service_type)->pluck('service_time');
        // dd($serviceTiming->toArray());
        
        $html = '';
        if($serviceTiming){
            foreach($serviceTiming as $key => $timing){
                $html .= '<div class="col-md-3 mb-3">
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="appoinment_time" id="inlineRadio'.$key.'" value="'.$timing.'">
                            <label class="form-check-label" for="inlineRadio'.$key.'">'.$timing.'</label>
                        </div>
                    </div>
                </div>';
            }
        }
        return $html;
    }
}
