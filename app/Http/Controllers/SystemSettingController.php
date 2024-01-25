<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{


    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'System Setting';
        $this->section->heading = 'System Setting';
        $this->section->slug = 'system';
        $this->section->folder = 'system_setting';
    }


    public function index()
    {
        checkPermission('read-branch');
        $section = $this->section;
        $setting=[];
        $settings=SystemSetting::get();
        $section->method = 'POST';
        $section->route = $section->slug.'.store';
        return view($section->folder.'.index', compact( 'section','settings','setting'));
    }

    public function settings()
    {
        checkPermission('read-branch');
        $section = $this->section;
        $setting=SystemSetting::get();
        return view($section->folder.'.system', compact( 'section','setting'));
    }

    public function store(Request $request){

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $uploadPath = public_path('web_uploads');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);

            $data=[
                'file'=> asset('web_uploads/'.$filename) ,
                'type'=>$request->type,
                'status'=>$request->status,
                'link'=>$request->link
            ];
            SystemSetting::create($data);
            return redirect()->back();
        }

    }
    public function delete($id){
        SystemSetting::where('id',$id)->delete();
        return redirect()->back();
    }




}
