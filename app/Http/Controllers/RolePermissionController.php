<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RolePermission;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;


class RolePermissionController extends Controller
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
        $this->section->heading = 'Role Permission';
        $this->section->slug = 'rolepermission';
        $this->section->folder = 'rolepermission';
    }
    public function index()
    {
        checkPermission('read-role');
	    $section = $this->section;
        $role = RolePermission::get();
        //dd($role);
        return view($section->folder.'.index', compact('role', 'section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        checkPermission('create-role');
        $role = [];
        $section = $this->section;
        $section->title = 'Add New Role';
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->checkPermission('add-modules');
       // dd($request->all());
        $section = $this->section;
        
        //define custom validation messages for validator
        $validationMessages = [
            'name.unique' => 'Role name already exist. Please enter a unique role name',
        ];
        // validate user input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string'
        ], $validationMessages);

        //validation fails
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        } else {

            $request->request->add([
                'name'=>$request->name,
                'user_id'=>auth()->user()->id
            ]);
            $role = Role::create($request->all());

            if($request->has('permissions')){
                foreach ($request->permissions as $permission){
                    $item = RolePermission::create([
                    'role_id' => $role->id,
                    'permission_id' => $permission,
                    'user_id' => $request->user_id,
                    'status' => $request->status,
                    ]);
                }
            }
            $request->session()->flash('flash_message', 'Record has been added successfully.');
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
}
