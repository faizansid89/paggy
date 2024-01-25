<<<<<<< HEAD
=======
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Area;
use App\Models\Branch;
use App\Models\City;
use App\Models\Customer;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BranchesController extends BaseController
{
    public function branches()
    {
        $branches = Branch::get();
        $data['data'] = $branches;
        $data['status'] = 200;
        $data['msg'] = 'Success';
        return response()->json($data);
    }

    public function brand_product($id)
    {
        $branches = Products::where('brand_id',$id)->get();
        $data['data'] = $branches;
        $data['status'] = 200;
        $data['msg'] = 'Success';
        return response()->json($data);
    }

    public function areas($id)
    {
        $area = Area::where('city_id', $id)->where('is_delivery',1)->get();
        $data['data'] = $area;
        $data['status'] = 200;
        $data['msg'] = 'Success';
        return response()->json($data);
    }

    public function city()
    {
        $city = City::where('status', 1)->get();
        $data['data'] = $city;
        $data['status'] = 200;
        $data['msg'] = 'Success';
        return response()->json($data);
    }

    public function address(Request $request)
    {
        $apiToken = $request->header('Token');
        // Split the token to retrieve the customer ID
        $parts = explode('-', $apiToken);
        $customerId = $parts[0];
        $address = Address::where('customer_id', $customerId)->get();

        if($address->count()){
            $data['data'] = $address;
            $data['status'] = true;
            $data['msg'] = 'Customer addresses.';
        } else {
            $data['data'] = $address;
            $data['status'] = false;
            $data['msg'] = 'Addresses not found.';
        }

        return response()->json($data);
    }

    public function add_address(Request $request)
    {
        $apiToken = $request->token;
        // Split the token to retrieve the customer ID
        $parts = explode('-', $apiToken);
        $customerId = $parts[0];

        // Retrieve the customer based on the ID
        $customer = Customer::find($customerId);

        $validator = Validator::make($request->all(), [
            'area_id' => 'required',
            'street' => 'required',
            'location_name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $area = Area::where('id', $request->area_id)->first();

        $data = [
            'customer_id' => $customer->id,
            'city_id' => $area->city_id,
            'area_id' => $area->id,
            'street' => $request->street,
            'location_name' => $request->location_name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];

        $address = Address::create($data);
        $success['name'] = $address;

        return $this->sendResponse($success, 'Address added successfully.');


    }

    public function edit_address($id)
    {
        $address = Address::where('id', $id)->first();
        $data['data'] = $address;
        $data['status'] = 200;
        $data['msg'] = 'Success';
        $data['Success'] = true;

        return response()->json($data);
    }


    public function delete_address($id)
    {
        $address = Address::where('id', $id)->delete();
        $data['data'] = $address;
        $data['status'] = 200;
        $data['msg'] = 'Success';
        $data['Success'] = true;

        return response()->json($data);
    }


    public function update_address(Request $request, $address_id)
    {
        //dd( $request->all());
        $apiToken = $request->header('Token');
        // Split the token to retrieve the customer ID
        $parts = explode('-', $apiToken);
        $customerId = $parts[0];

        // Retrieve the customer based on the ID
        $customer = Customer::find($customerId);
        //dd($customer);

        // check if address exists
        $address = Address::find($address_id);
        if ($address==null || $address->customer_id != $customer->id) {
            $success['success'] = false;
            return $this->sendError($success, ['error' => 'Customer does not have this address.']);
        }

        $area = Area::where('id', $request->area_id)->first();
        if ($area==null) {
            $success['success'] = false;
            return $this->sendError($success, ['error' => 'Area does not exists.']);
        }

        $data = [
            'customer_id' => $customer->id,
            'city_id' => $area->city_id,
            'area_id' => $area->id,
            'street' => $request->street,
            'location_name' => $request->location_name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];
        $address->update($data);
        $success['success'] = true;
        $success['data'] = $address;
        $success['msg'] = 'Success';

        return $this->sendResponse($success, 'Address updated successfully.');

    }


}
>>>>>>> cadbf20e819f42c88b6ae80ab2013f9840a44660
