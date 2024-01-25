<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Permission;



class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'Role';
        $this->section->heading = 'Role';
        $this->section->slug = 'role';
        $this->section->folder = 'role';
    }
    public function index()
    {
        $section = $this->section;
        $role = Role::get();
        return view($section->folder.'.index', compact('role', 'section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $role = [];
        $section = $this->section;
        $section->title = 'Add role';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';
        $permissions = Permission::get();
        $rolePermissions = [];
        return view($section->folder.'.form',compact('section', 'role','permissions','rolePermissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $section = $this->section;

        //define custom validation messages for validator
        $validationMessages = [
            'name.unique' => 'Role name already exist. Please enter a unique role name',
        ];
        // validate user input
        $validator =  Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name',
            'status' => 'required|boolean',
        ], $validationMessages);

        //validation fails
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        } else {
            //$request->request->add(['created_by'=>auth()->user()->id]);
            $role=[
                'name'=>$request->name,
                'status'=>$request->status,
            ];
            $role=Role::create($role);
            //dd($role);
            foreach ($request->permissions as $permission){
                // echo $permission;
                $data=[
                    'name'=>$request->name,
                    'status'=>$request->status,
                    'user_id'=>Auth()->user()->id,
                    'role_id'=>$role->id,
                    'permission_id'=>$permission
                ];
                RolePermission::create($data);
            }


            //Role::create($request->all());
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
    public function edit(Role $role)
    {
        $role = $role;
        $section = $this->section;
        $section->title = 'Edit Role';
        $section->method = 'PUT';
        $section->route = [$section->slug.'.update', $role];
        $permissions = Permission::get();
        $rolePermissions = RolePermission::where('role_id',$role->id)->pluck('permission_id')->toArray();
        //dd($rolePermissions);
        return view($section->folder.'.form',compact('section', 'role','permissions','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,$id)
    {
       // dd($request->all());
        $section = $this->section;

        //define custom validation messages for validator
        $validationMessages = [
//            'name.unique' => 'role name already exist. Please enter a unique branch name',
        ];
        // validate user input
        $validator = Validator::make($request->all(), [
//            'name' => 'required|string|unique:roles,name,'. $id . ',id',
            'status' => 'required|boolean'
        ], $validationMessages);

        //validation fails
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        } else {
            RolePermission::where('role_id', $id)->delete();
            foreach ($request->permissions as $permission){
                $data=[
                    'role_id'=>$id,
                    'permission_id'=>$permission,
                    'user_id'=>Auth()->user()->id,
                ];
                RolePermission::create($data);
            }


            //Role::where('id',$id)->update($data);
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
}
