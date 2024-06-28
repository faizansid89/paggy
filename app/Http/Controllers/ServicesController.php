<?php

namespace App\Http\Controllers;

use App\Models\ClinicalSupervisionForm;
use App\Models\ConsultationForm;
use App\Models\ExpertTestimonyForm;
use App\Models\Services;
use App\Models\ServiceTiming;
use App\Models\TherapyForm;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Validator;


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

        $request->session()->flash('alert-success', 'Record has been added successfully.');
        return redirect()->route($section->slug.'.index');
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

        $request->session()->flash('alert-success', 'Record has been added successfully.');
        return redirect()->route($section->slug.'.index');
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

        $request->session()->flash('alert-success', 'Record has been added successfully.');
        return redirect()->route($section->slug.'.index');
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

        // dd('expert_testimony', $request->toArray());
        ExpertTestimonyForm::create($request->all());

        $request->session()->flash('alert-success', 'Record has been added successfully.');
        return redirect()->route($section->slug.'.index');
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
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio'.$key.'" value="'.$timing.'">
                            <label class="form-check-label" for="inlineRadio'.$key.'">'.$timing.'</label>
                        </div>
                    </div>
                </div>';
            }
        }
        return $html;
    }
}
