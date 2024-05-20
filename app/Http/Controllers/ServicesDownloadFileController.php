<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Models\ServicesDownloadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Validator;


class ServicesDownloadFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'Services Download File';
        $this->section->heading = 'Services Download File';
        $this->section->slug = 'services_download_file';
        $this->section->folder = 'services_download_file';
    }
    public function index(Request $request, $id)
    {
        // checkPermission('read-user');
        $section = $this->section;
        $services = ServicesDownloadFile::where('service_id', $id)->get();
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
        $section->title = 'Add Services Download File';
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

            if($request->file('link')){
                $image = $request->file('link');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('attachments'),$imageName);
                $imageNameAfterUpload = '/attachments/'.$imageName;
                $request->request->add(['file_path' => asset($imageNameAfterUpload)]);
                $request->request->remove('link');
            }

            ServicesDownloadFile::create($request->except(['link']));
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
    // public function edit(ServicesDownloadFile $servicesDownloadFile, $id)
    public function edit($id, $servicesFileId)
    {
        // checkPermission('update-user');
        $service = ServicesDownloadFile::where('service_id', $id)->where('id', $servicesFileId)->first();
        
        $section = $this->section;
        $section->title = 'Edit Service';
        $section->method = 'PUT';
        $section->route = [$section->slug.'.update', 'id' => $id, 'services_download_file' => $servicesFileId];
        
        return view($section->folder.'.form',compact('section', 'service', 'id', 'servicesFileId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $servicesFileId)
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

            if($request->file('link')){
                $image = $request->file('link');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('attachments'),$imageName);
                $imageNameAfterUpload = '/attachments/'.$imageName;
                $request->request->add(['file_path' => asset($imageNameAfterUpload)]);
                $request->request->remove('link');
            }
            ServicesDownloadFile::where('service_id',$id)->where('id', $servicesFileId)->update($request->except(['link', '_token', '_method', 'service_id']));
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
        $section->title = 'Add Form One';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';
       
        return view($section->folder.'.form_one',compact('section', 'service'));
    }

    public function form_two(Request $request)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Add Form Two';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';
       
        return view($section->folder.'.form_two',compact('section', 'service'));
    }

    public function form_four(Request $request)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Add Form Four';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';
       
        return view($section->folder.'.form_four',compact('section', 'service'));
    }

    public function form_three(Request $request)
    {
        // checkPermission('create-user');
        $service = [];
        $section = $this->section;
        $section->title = 'Add Form Three';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';
       
        return view($section->folder.'.form_three',compact('section', 'service'));
    }
}
