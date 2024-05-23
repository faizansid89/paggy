<?php

namespace App\Http\Controllers;

use App\Models\Services;
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
        $service = Services::where('id', $id)->first();
        
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

            Services::where('id',$id)->update($request->except(['thumbnail_file', '_token', '_method']));
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
        $section->route = $section->slug.'.store';
       
        return view($section->folder.'.form_one',compact('section', 'service'));
    }

    public function form_two(Request $request)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Clinical Supervision';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';
       
        return view($section->folder.'.form_two',compact('section', 'service'));
    }

    public function form_four(Request $request)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Expert Testimony';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';
       
        return view($section->folder.'.form_four',compact('section', 'service'));
    }

    public function form_three(Request $request)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Consultation';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';
       
        return view($section->folder.'.form_three',compact('section', 'service'));
    }
}
