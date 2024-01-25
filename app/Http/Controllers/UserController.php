<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'User';
        $this->section->heading = 'User';
        $this->section->slug = 'user';
        $this->section->folder = 'user';
    }
    public function index()
    {
        checkPermission('read-user');
        $section = $this->section;
        $user = User::with('role')->get();
        return view($section->folder.'.index', compact('user', 'section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        checkPermission('create-user');
        $user = [];
        $section = $this->section;
        $section->title = 'Add User';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';
        $role=Role::where('status',1)->pluck('name','id');
        return view($section->folder.'.form',compact('section', 'user','role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        checkPermission('create-user');
        $section = $this->section;

        //define custom validation messages for validator
        $validationMessages = [
        ];
        // validate user input
        $validator =  Validator::make($request->all(), [
            'email' => 'required|string|unique:users,email',
            'status' => 'required|boolean',
        ], $validationMessages);

        //validation fails
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        } else {
            //make::hash($request->password);
            $request->request->add(['password'=>bcrypt($request->password)]);

            User::create($request->all());
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
    public function edit(User $user)
    {
        checkPermission('update-user');
        $user = $user;
        $section = $this->section;
        $section->title = 'Edit User';
        $section->method = 'PUT';
        $section->route = [$section->slug.'.update', $user];
        $role=Role::where('status',1)->pluck('name','id');
        return view($section->folder.'.form',compact('section', 'user','role'));
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
            if($request->name){
                $data['name']=$request->name;
            }
            if($request->phone){
                $data['phone']=$request->phone;
            }
            if($request->role_id){
                $data['role_id']=$request->role_id;
            }
            if($request->address){
                $data['address']=$request->address;
            }
            if($request->postal_code){
                $data['postal_code']=$request->postal_code;
            }
            if($request->city){
                $data['city']=$request->city;
            }
            if($request->state){
                $data['state']=$request->state;
            }
            if($request->country){
                $data['country']=$request->country;
            }

            if($request->file('profile')){

                $image = $request->file('profile');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('attachments'),$imageName);
                $imageNameAfterUpload = '/attachments/'.$imageName;
                $data['profile_picture']=$imageNameAfterUpload;
            }
           // dd($id);
//            if($request->password){
//                $data['password']= bcrypt($request->password);
//            }
            if ($request->password !== null && $request->password !== '') {
                $data['password'] = bcrypt($request->password);
            }
            if($request->status){
                $data['status']=$request->status;
            }


            User::where('id',$id)->update($data);
            $request->session()->flash('alert-success', 'Record has been updated successfully.');
            return redirect()->back();
            return redirect()->route($section->slug . '.profile');
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

    public function profile(Request $request){
        $id=Auth()->user()->id;

        $user = User::where('id',$id)->first();

//        dd($request->toArray(), $user->toArray());
        $section = $this->section;
        $section->title = 'Edit User';
        $section->method = 'PUT';
        $section->route = [$section->slug.'.update', $user->id];
       // $section->routeimg = [$section->slug.'.update', $user->id];
        //$role=Role::where('status',1)->pluck('name','id');
        //$branch=Branch::where('status',1)->pluck('name','id');
        return view($section->folder.'.profile',compact('section', 'user'));
    }
}
