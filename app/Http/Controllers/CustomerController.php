<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'Customer';
        $this->section->heading = 'Customer';
        $this->section->slug = 'customer';
        $this->section->folder = 'customer';
    }
    public function index()
    {
        checkPermission('read-customer');
        $section = $this->section;
        $customer = Customer::get();
        return view($section->folder.'.index', compact('customer', 'section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer = [];
        $section = $this->section;
        $section->title = 'Add Customer';
        $section->method = 'POST';
        $section->route = $section->slug.'.store';
        return view($section->folder.'.form',compact('section', 'customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $section = $this->section;

        //define custom validation messages for validator
        $validationMessages = [
        ];
        // validate user input
        $validator =  Validator::make($request->all(), [
            'status' => 'required|boolean',
        ], $validationMessages);

        //validation fails
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        } else {
            //$request->request->add(['created_by'=>auth()->user()->id]);
        //dd($request->all());

            Customer::create($request->all());
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
    public function edit(Customer $customer)
    {
        $customer = $customer;
        $section = $this->section;
        $section->title = 'Edit Customer';
        $section->method = 'PUT';
        $section->route = [$section->slug.'.update', $customer];
        return view($section->folder.'.form',compact('section', 'customer'));
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
        $section = $this->section;

                //define custom validation messages for validator
                $validationMessages = [
                ];
                // validate user input
                $validator = Validator::make($request->all(), [
                    'email' => 'required|string|unique:customers,email,'. $id . ',id',
                    'status' => 'required|boolean'
                ], $validationMessages);

                //validation fails
                if ($validator->fails()) {
                    return redirect()->back()->withInput($request->input())->withErrors($validator);
                } else {
                    $data=[
                        'name'=>$request->name,
                        'phone'=>$request->phone,
                        'country'=>$request->country,
                        'city'=>$request->city,
                        'email'=>$request->email,
                        'address'=>$request->address,
                        'status'=>$request->status
                    ];
                    Customer::where('id',$id)->update($data);
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
