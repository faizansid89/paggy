<?php

namespace App\Http\Controllers;

use App\Models\ServicesAssessments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Validator;


class ServicesAssessmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'Services Assessments';
        $this->section->heading = 'Services Assessments';
        $this->section->slug = 'services_assessments';
        $this->section->folder = 'services_assessments';
    }
    public function index(Request $request, $id)
    {
        // checkPermission('read-user');
        $section = $this->section;
        $services = ServicesAssessments::where('service_id', $id)->get();
        return view($section->folder.'.index', compact('services', 'section', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Add Service Assessments';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';
        
        return view($section->folder.'.form',compact('section', 'service', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
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

            ServicesAssessments::create($request->all());
            $request->session()->flash('alert-success', 'Record has been added successfully.');
            return redirect()->route($section->slug.'.index', $id);
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
    public function edit(ServicesAssessments $servicesAssessments, $id, $servicesAssessmentId)
    {
        // checkPermission('update-user');
        $service = ServicesAssessments::where('service_id', $id)->where('id', $servicesAssessmentId)->first();
        
        $section = $this->section;
        $section->title = 'Edit  Service Assessments';
        $section->method = 'PUT';
        $section->route = [$section->slug.'.update', 'id' => $id, 'services_assessment' => $service->id];
        
        // dd($id, $service->toArray(), $servicesAssessmentId, $section);
        return view($section->folder.'.form',compact('section', 'service', 'id', 'servicesAssessmentId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $servicesAssessmentId)
    {
        // checkPermission('update-user');
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
            ServicesAssessments::where('service_id',$id)->where('id', $servicesAssessmentId)->update($request->except(['_token', '_method']));
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
}
