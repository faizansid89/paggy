<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Area;
use App\Models\Branch;
use App\Models\Brands;
use App\Models\Categories;
use App\Models\City;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\MissSale;
use App\Models\OpeningBalance;
use App\Models\Permission;
use App\Models\Products;
use App\Models\ProductUnit;
use App\Models\ProductUnitStatus;
use App\Models\PurchaseDetails;
use App\Models\Purchases;
use App\Models\ReceiveItem;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SaleReturn;
use App\Models\SubCategories;
use App\Models\Supplier;
use App\Models\SyncLog;
use App\Models\SyncSystem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SyncController extends Controller
{
    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'Sync';
        $this->section->heading = 'Sync';
        $this->section->slug = 'sync';
        $this->section->folder = 'sync';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        checkPermission('read-sync-system');
        $section = $this->section;
        $branches = Branch::all();
        return view($section->folder . '.index', compact('section','branches'));
    }

    // Received Items through POST API
    public function receiveItems(Request $request)
    {
        $receiveItemBatchCode = [
            'branch_auto_id' => $request->branch_auto_id,
            'product_id' => $request->product_id,
            'is_batch_code' => $request->is_batch_code,
            'sku' => $request->sku,
            'batch_code' => $request->batch_code,
            'purchase_id' => $request->purchase_id,
            'purchase_detail_id' => $request->purchase_detail_id,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'created_by' => $request->created_by,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ];

        $data = ReceiveItem::create($receiveItemBatchCode);
        if (!$data)
        {
            $response['status'] = 500;
            $response['msg'] = 'Data not Save';
        }
        else {
            $response['status'] = 200;
            $response['msg'] = 'Successfully Save';
            $response['data'] = $data;
        }

        return response()->json($response);
    }


    // Received Items through POST API
    public function purchases(Request $request)
    {
//        $receiveItemBatchCode = [
//            'id' => $request->id,
//            'branch_id' => $request->branch_id,
//            'note' => $request->note,
//            'status' => $request->status,
//            'updated_at' => $request->updated_at,
//        ];

        $purchases = Purchases::where('id', $request->id)->where('branch_id', $request->branch_id)->first();
        $purchases->note = $request->note;
        $purchases->status = $request->status;
        $purchases->updated_at = $request->updated_at;
        $purchases->save();

        $response['status'] = 200;
        $response['msg'] = 'Successfully Save';
        $response['data'] = $purchases;

        return response()->json($response);
    }

    // Received Items through POST API
    public function inventory(Request $request)
    {
        $data = $request->toArray();

        foreach($data as $record) {

            $inventory = Inventory::where('branch_id', $record['branch_id'])->where('product_id', $record['product_id'])->first();

            if(isset($inventory)){
                $inventory->branch_auto_id = $record['branch_auto_id'];
                $inventory->branch_id = $record['branch_id'];
                $inventory->product_id = $record['product_id'];
                $inventory->category_id = $record['category_id'];
                $inventory->product_name = $record['product_name'];
                $inventory->sku = $record['sku'];
                $inventory->quantity = $record['quantity'];
                $inventory->created_by = $record['created_by'];
                $inventory->updated_at = $record['updated_at'];
                $inventory->save();
            }
            else {
                $inventory = new Inventory();
                $inventory->branch_auto_id = $record['branch_auto_id'];
                $inventory->branch_id = $record['branch_id'];
                $inventory->product_id = $record['product_id'];
                $inventory->category_id = $record['category_id'];
                $inventory->product_name = $record['product_name'];
                $inventory->sku = $record['sku'];
                $inventory->quantity = $record['quantity'];
                $inventory->created_by = $record['created_by'];
                $inventory->updated_at = $record['updated_at'];
                $inventory->save();
            }

        }

        $response['status'] = 200;
        $response['msg'] = 'Successfully Save';
        $response['data'] = $inventory;

        return response()->json($response);
    }

    public function sales(Request $request)
    {
        $data = $request->toArray();

        foreach($data as $record) {
            $created_at = Carbon::parse($record['created_at']);
            // Add 5 hours to the created_at value
            $created_at->addHours(5);

            $sales = [
                'sale_auto_id'  => $record['sale_auto_id'],
                'branch_id'  => $record['branch_id'],
                'invoice_number'  => $record['invoice_number'],
                'customer_id'  => $record['customer_id'],
                'customer_name'  => $record['customer_name'],
                'status'  => $record['status'],
                'discount'  => $record['discount'],
                'total'  => $record['total'],
                'created_by'  => $record['created_by'],
                'created_by_name'  => $record['created_by_name'],
                //'created_at'  => $record['created_at'],
                'created_at' => $created_at->toDateTimeString(),
                'updated_at'  => $record['updated_at'],
                'is_return'  => $record['is_return'],
            ];
            $sale =  Sale::where('sale_auto_id', $record['sale_auto_id'])->first();

            if($sale != null){
                $data = $sale->update($sales);
            }
            else {
                $data = Sale::create($sales);
            }

        }

        $response['status'] = 200;
        $response['msg'] = 'Successfully Save';
        $response['data'] = $data;

        return response()->json($response);

//        $sales = [
//           'sale_auto_id'  => $request->sale_auto_id,
//           'branch_id'  => $request->branch_id,
//           'invoice_number'  => $request->invoice_number,
//           'customer_id'  => $request->customer_id,
//           'customer_name'  => $request->customer_name,
//           'status'  => $request->status,
//           'discount'  => $request->discount,
//           'total'  => $request->total,
//           'created_by'  => $request->created_by,
//           'created_by_name'  => $request->created_by_name,
//           'created_at'  => $request->created_at,
//           'updated_at'  => $request->updated_at,
//           'is_return'  => $request->is_return,
//        ];
//
//        $sale =  Sale::where('sale_auto_id', $request->sale_auto_id)->first();
//
//        if($sale != null){
//            $data = $sale->update($sales);
//        }
//        else {
//            $data = Sale::create($sales);
//        }
//
////        $data = Sale::upsert($sales, 'sale_auto_id');
//        if (!$data)
//        {
//            $response['status'] = 500;
//            $response['msg'] = 'Data not Save';
//        }
//        else {
//            $response['status'] = 200;
//            $response['msg'] = 'Successfully Save';
//            $response['data'] = $data;
//        }
//        return response()->json($response);
    }

    public function return_sales(Request $request)
    {

        $created_at = Carbon::parse($request->created_at);
        // Add 5 hours to the created_at value
        $created_at->addHours(5);

        $return_sales = [
//            'sale_auto_id' => $request->id,
            'branch_id' => $request->branch_id,
            'sales_id' => $request->sales_id,
            'sales_item_id' => $request->sales_item_id,
            'invoice_number' => $request->invoice_number,
            'product_id' => $request->product_id,
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'reason' => $request->reason,
            'return_date' => $request->return_date,
            'created_at' => $created_at->toDateTimeString(),
            'updated_at' => $request->updated_at,
        ];

        $data = SaleReturn::create($return_sales);
        if (!$data)
        {
            $response['status'] = 500;
            $response['msg'] = 'Data not Save';
        }
        else {
            $response['status'] = 200;
            $response['msg'] = 'Successfully Save';
            $response['data'] = $data;
        }
        return response()->json($response);
    }

    public function miss_sale(Request $request)
    {
        $miss_sale = [
            'branch_id' => $request->branch_id,
            'product_info' => $request->product_info,
            'person_info' => $request->person_info,
            'created_by' => $request->created_by,
            'created_by_name' => $request->created_by_name,
        ];

        $data = MissSale::create($miss_sale);

        if (!$data)
        {
            $response['status'] = 500;
            $response['msg'] = 'Data not Save';
        }
        else {
            $response['status'] = 200;
            $response['msg'] = 'Successfully Save';
            $response['data'] = $data;
        }
        return response()->json($response);
    }
    public function opening_balance(Request $request)
    {
        $return_sales = [
            'branch_id' => $request->branch_id,
            'user_id' => $request->user_id,
            'opening_balance' => $request->opening_balance,
            'date_time' => $request->date_time,
            'created_by' => $request->created_by,
            'created_by_name' => $request->created_by_name,
        ];

        $data = OpeningBalance::create($return_sales);
        if (!$data)
        {
            $response['status'] = 500;
            $response['msg'] = 'Data not Save';
        }
        else {
            $response['status'] = 200;
            $response['msg'] = 'Successfully Save';
            $response['data'] = $data;
        }
        return response()->json($response);
    }

    public function sync_logs(Request $request)
    {
        $return_sales = [
            'id' => $request->id,
            'branch_id' => $request->branch_id,
            'name' => $request->name,
            'status' => $request->status,
            'start_by' => $request->start_by,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ];

        $data = SyncLog::create($return_sales);
        if (!$data)
        {
            $response['status'] = 500;
            $response['msg'] = 'Data not Save';
        }
        else {
            $response['status'] = 200;
            $response['msg'] = 'Successfully Save';
            $response['data'] = $data;
        }
        return response()->json($response);
    }

    public function saleItems(Request $request)
    {
        $data = $request->toArray();

        foreach($data as $record) {

            $created_at = Carbon::parse($record['created_at']);
            // Add 5 hours to the created_at value
            $created_at->addHours(5);

            $saleitem = [
                "saleitem_auto_id" => $record['saleitem_auto_id'],
                "sales_id" => $record['sales_id'],
                "sku" => $record['sku'],
                "batch_code" => $record['batch_code'],
                "product_id" => $record['product_id'],
                "product_name" => $record['product_name'],
                "quantity" => $record['quantity'],
                "price" => $record['price'],
                "tax" => $record['tax'],
                "discount" => $record['discount'],
                "unit_id" => $record['unit_id'],
                "unit_name" => $record['unit_name'],
                "sub_total" => $record['sub_total'],
                "created_by" => $record['created_by'],
                "created_by_name" => $record['created_by_name'],
                "created_at" => $created_at->toDateTimeString(),
                "updated_at" => $record['updated_at'],
                "is_return" => $record['is_return']
            ];

            $saleItems =  SaleItem::where('saleitem_auto_id', $record['saleitem_auto_id'])->first();

            if($saleItems != null){
                $data = $saleItems->update($saleitem);
            }
            else {
                $data = SaleItem::create($saleitem);
            }

        }


        $response['status'] = 200;
        $response['msg'] = 'Successfully Save';
        $response['data'] = $data;

        return response()->json($response);
    }

    public function customer(Request $request)
    {
        $data = $request->toArray();

        foreach($data as $record) {
            $customer  = Customer::where('id', $record['id'])->first();

            if(isset($customer)){
                $customer->name = $record['name'];
                $customer->email = $record['email'];
                $customer->phone = $record['phone'];
                $customer->country = $record['country'];
                $customer->city = $record['city'];
                $customer->address = $record['address'];
                $customer->is_marketing = $record['is_marketing'];
                $customer->status = $record['status'];
                $customer->created_at = $record['created_at'];
                $customer->updated_at = $record['updated_at'];
                $customer->save();
            }
            else {
                $customer = new Customer();
                $customer->name = $record['name'];
                $customer->email = $record['email'];
                $customer->phone = $record['phone'];
                $customer->country = $record['country'];
                $customer->city = $record['city'];
                $customer->address = $record['address'];
                $customer->is_marketing = $record['is_marketing'];
                $customer->status = $record['status'];
                $customer->created_at = $record['created_at'];
                $customer->updated_at = $record['updated_at'];
                $customer->save();
            }
        }

        $response['status'] = 200;
        $response['msg'] = 'Successfully Save';
        $response['data'] = $customer;

        return response()->json($response);
    }

    public function user(Request $request)
    {

        $user  = User::where('email', $request->email)->first();

        if(isset($user)){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->phone = $request->phone;
            $user->role_id = $request->role_id;
            $user->branch_id = $request->branch_id;
            $user->status = $request->status;
            $user->created_at = $request->created_at;
            $user->updated_at = $request->updated_at;
            $user->save();
        }
        else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->phone = $request->phone;
            $user->role_id = $request->role_id;
            $user->branch_id = $request->branch_id;
            $user->status = $request->status;
            $user->save();
        }

        if (!$user)
        {
            $response['status'] = 500;
            $response['msg'] = 'User not Save';
        }
        else {
            $response['status'] = 200;
            $response['msg'] = 'Successfully Save';
            $response['data'] = $user;
        }
        return response()->json($response);
    }


    public function sendAllData(Request $request, $id)
    {
        $branch = Branch::where('id', $id)->first();
        if(!isset($branch)){
            $response['status'] = 500;
            $response['msg'] = 'Branch Not Available';
            return response()->json($response);
        }

        // $products = Products::with('units', 'categories', 'brands')->get();
        $branches = Branch::all();
        $supplier = Supplier::all();
        $products = Products::all();
        $categories = Categories::all();
        $subCategories = SubCategories::all();
        $brands = Brands::all();
        $unit = ProductUnit::all();
        $product_unit_status = ProductUnitStatus::all();
        $purchase = Purchases::where("branch_id", $branch->id)->where("is_approved",1)->get();
        $purchaseDetail = PurchaseDetails::all();
        $role = Role::all();
        $permission = Permission::all();
        $rolePermission = RolePermission::all();
        $advertisement = Advertisement::all();
        $customers = Customer::all();
        $opening_balances = OpeningBalance::all();
        $cities = City::all();
        $areas = Area::with('city')->get();

        return response()->json([
            'branches' => $branches,
            'supplier' => $supplier,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'brands' => $brands,
            'products' => $products,
            'unit' => $unit,
            'product_unit_status' => $product_unit_status,
            'purchase' => $purchase,
            'purchaseDetail' => $purchaseDetail,
            'roles' => $role,
            'permissions' => $permission,
            'role_permission' => $rolePermission,
            'advertisement' => $advertisement,
            'customers' => $customers,
            'opening_balances' => $opening_balances,
            'cities' => $cities,
            'areas' => $areas,
        ]);
    }

    public function sendCustomer(Request $request)
    {
        $customers = Customer::all();

        return response()->json([
            'customers' => $customers
        ]);
    }

}
