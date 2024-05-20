<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Area;
use App\Models\Branch;
use App\Models\Brands;
use App\Models\City;
use App\Models\Inventory;
use App\Models\MissSale;
use App\Models\OfferProduct;
use App\Models\OpeningBalance;
use App\Models\Permission;
use App\Models\Products;
use App\Models\ProductUnit;
use App\Models\ProductUnitStatus;
use App\Models\PurchaseDetails;
use App\Models\Purchases;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\SaleReturn;
use App\Models\SubCategories;
use App\Models\Supplier;
use Carbon\Carbon;
use Carbon\Traits\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use DateTime;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class ProductController extends Controller
{
    public function store($id, $pro)
    {
        //dd($id,$pro);
        $category = Inventory::with('branch', 'product', 'category')->where('branch_id', $id)->where('product_id', $pro)->get();
        return response()->json($category);
    }

    public function single_product($id)
    {
        //dd($id,$pro);
        $category = Products::with('inventery', 'categories', 'brands', 'productUnitState1')->where('id', $id)->first();
        $data['data'] = $category;
        $data['status'] = 200;
        $data['msg'] = 'Success';
        $data['success'] = true;
        return response()->json($data);
    }

    public function product_unit_status($id)
    {
        //dd($id,$pro);
        $category = ProductUnitStatus::where('id', $id)->first();
        $data['data'] = $category;
        $data['status'] = 200;
        $data['msg'] = 'Success';
        $data['success'] = true;
        return response()->json($data);
    }

    public function shop_branch($id)
    {
        //return $id;
        $category = Inventory::with('product', 'category')->where('branch_id', $id)->get();
        if (count($category) > 0) {
            $data['data'] = $category;
            $data['status'] = 200;
            $data['msg'] = 'Success';
            $data['success'] = true;

            return response()->json($data);
        } else {
            $data['status'] = 200;
            $data['msg'] = 'Not Found';
            $data['success'] = false;

            return response()->json($data);
        }
    }

    public function nearby_store($id)
    {

        $branches = Branch::get();


//        $userLatitude = 24.867960773639574;
//        $userLongitude= 67.08407190015625;  //cavish
        $area = Area::where('id', $id)->first();

        $userLatitude = $area->lot;
        $userLongitude = $area->lon;

        $bra = [];
        foreach ($branches as $key => $branche) {

            $brancheLatitude = $branche->latitude;
            $brancheLongitude = $branche->longitude;

            $distance = $this->haversine($userLatitude, $userLongitude, $brancheLatitude, $brancheLongitude);

//           print_r("Distance : " . $distance);
//           die;
            if ($distance < 10) {
                $bra[$key]['branch_id'] = $branche->id;
                $bra[$key]['branch_name'] = $branche->name;
                $bra[$key]['phone'] = $branche->phone;
                $data['msg'] = 'Success';
            } else {
                $data['msg'] = 'Not Found';
            }
        }

        $data['data'] = $bra;
        $data['status'] = 200;
        $data['success'] = true;

        return response()->json($data);


    }

    public function category_product($category)
    {


        $category = Products::with('productUnitState')->where('category_id', $category)->get();
        $data['data'] = $category;
        $data['status'] = 200;
        $data['msg'] = 'Success';
        $data['success'] = true;

        return response()->json($data);

    }
//    public function category_product($branch,$category){
//
//        $category=Inventory::with('product','category')->where('branch_id',$branch)->where('category_id',$category)->get();
//        $data['data'] =$category;
//        $data['status'] =200;
//        $data['msg'] ='Success';
//        $data['success'] =true;
//
//        return  response()->json($data);
//
//    }
    public function branch_product_pagi($branch)
    {

        $category = Inventory::with('product', 'category')->where('branch_id', $branch)->paginate(10);
        $data['data'] = $category;
        $data['status'] = 200;
        $data['msg'] = 'Success';
        $data['success'] = true;

        return response()->json($data);

    }

    public function brands()
    {
        $brands = Brands::get();
        $data['data'] = $brands;
        $data['status'] = 200;
        $data['msg'] = 'Success';
        $data['success'] = true;

        return response()->json($data);
    }

    public function top_selling($id)
    {
        $product = OfferProduct::with('product')->where('type', $id)->get();
        $data['data'] = $product;
        $data['status'] = 200;
        $data['msg'] = 'Success';
        $data['success'] = true;

        return response()->json($data);
    }
    public function top_selling_by_branch($id,$branch_id)
    {
        $product = OfferProduct::with('product')
            ->where('type', $id)
            ->where('branch_id', $branch_id)
            ->get();
        $data['data'] = $product;
        $data['status'] = 200;
        $data['msg'] = 'Success';
        $data['success'] = true;

        return response()->json($data);
    }

    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Radius of the earth in km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c; // Distance in km

        //1 km is equal to 0.62137119 so the conversion factor is
        $cf = 0.62137119;

        $result = $distance * $cf;
        return $result;
    }

    public function all_product()
    {

        $product = Products::with('categories', 'brands', 'productUnitState')->get();
        return response()->json($product);
    }
    public function all_product_by_branch($branch_id)
    {

        $product = Products::with('categories', 'brands', 'productUnitState')->where('branch_id',$branch_id)->get();
        return response()->json($product);
    }

//    function fetchDataFromRemoteServer($url)
//    {
//        $response = Http::get($url);
//
//        if ($response->successful()) {
//            return $response->json();
//        } else {
//            return null;
//        }
//    }

    public function fetchSalesWithItems($branch_url)
    {
        try {
//            DB::beginTransaction();

            $curl = curl_init();
            $url = $branch_url . 'api/sales-with-line-items';

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $data = curl_exec($curl);
            curl_close($curl);
            $sales = json_decode($data, true);




            $salesData = $sales['sales'];


            // Process and save the sales data and their items to the database
            foreach ($salesData as $saleData) {

                // Save the sale record
                $sale = new Sale();
                $sale->sale_auto_id = $saleData['id'];
                $sale->branch_id = $saleData['branch_id'];
                $sale->invoice_number = $saleData['invoice_number'];
                $sale->customer_id = $saleData['customer_id'];
                $sale->customer_name = $saleData['customer_name'];
                $sale->status = $saleData['status'];
                $sale->discount = $saleData['discount'];
                $sale->total = $saleData['total'];
                $sale->created_by = $saleData['created_by'];
                $sale->created_by_name = $saleData['created_by_name'];
                $sale->updated_at = $saleData['updated_at'];
                $sale->is_return = $saleData['is_return'];
                $sale->save();

                // Save the sale items associated with this sale
                foreach ($saleData['sales_items'] as $itemData) {
                    // Using the relationship to save the sale item
                    $saleItem = new SaleItem();
                    $saleItem->saleitem_auto_id = $itemData['id'];
                    $saleItem->sales_id = $itemData['sales_id'];
                    $saleItem->sku = $itemData['sku'];
                    $saleItem->batch_code = $itemData['batch_code'];
                    $saleItem->product_id = $itemData['product_id'];
                    $saleItem->product_name = getProductName($itemData['product_id']);
                    $saleItem->quantity = $itemData['quantity'];
                    $saleItem->price = $itemData['price'];
                    $saleItem->tax = $itemData['tax'];
                    $saleItem->tax_rate = $itemData['tax_rate'];
                    $saleItem->discount = $itemData['discount'];
                    $saleItem->unit_id = $itemData['unit_id'];
                    $saleItem->unit_name = $itemData['unit_name'];
                    $saleItem->sub_total = $itemData['sub_total'];
                    $saleItem->created_by = $itemData['created_by'];
                    $saleItem->created_by_name = $itemData['created_by_name'];
                    $saleItem->created_at = $itemData['created_at'];
                    $saleItem->updated_at = $itemData['updated_at'];
                    $saleItem->is_return = $itemData['is_return'];
                    $sale->sales_items()->save($saleItem);
                }

                Http::post(env('FETCH_BRANCH_API_URL_NEW') . 'sales', [
                    "sales_id" => $saleData['id']
                ]);

            }

//            DB::commit();
            return response()->json(['message' => "Sales data saved successfully."]);
        } catch (\Exception $e) {
//            DB::rollback();
            return response()->json(['message' => $e->getMessage()]);
        }

    }

    public function fetchInventory($branch_url)
    {
        try {
            DB::beginTransaction();

            $curl = curl_init();
            $url = $branch_url . 'api/send-inventory';


            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $data = curl_exec($curl);
            curl_close($curl);
            $inventory = json_decode($data, true);
            $inventoryData = $inventory['inventory'];


            // Process and save the sales data and their items to the database
            foreach ($inventoryData as $record) {

                // Save the sale record
                $inventory = new Inventory();
                $inventory->branch_auto_id = $record['id'];
                $inventory->branch_id = $record['branch_id'];
                $inventory->product_id = $record['product_id'];
                $inventory->category_id = $record['category_id'];
                $inventory->product_name = $record['product_name'];
                $inventory->sku = $record['sku'];
                $inventory->quantity = $record['quantity'];
                $inventory->created_by = $record['created_by'];
                $inventory->updated_at = $record['updated_at'];
                $inventory->save();

//                Http::post(env('FETCH_BRANCH_API_URL_NEW') . 'update-is-sync', [
//                    "type" => 'inventory',
//                    "id" => $record['id']
//                ]);


            }

            DB::commit();
            return response()->json(['message' => "Inventory data saved successfully."]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function fetchMissSale($branch_url)
    {
        try {
            DB::beginTransaction();
            $curl = curl_init();
            $url = $branch_url . 'api/send-miss-sale';

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $data = curl_exec($curl);
            curl_close($curl);
            $inventory = json_decode($data, true);
            $inventoryData = $inventory['missSale'];

            // Process and save the sales data and their items to the database
            foreach ($inventoryData as $record) {

                // Save the sale record
                $miss_sale = new MissSale();

                $miss_sale->branch_id = $record['branch_id'];
                $miss_sale->product_info = $record['product_info'];
                $miss_sale->person_info = $record['person_info'];
                $miss_sale->created_by = $record['created_by'];
                $miss_sale->created_by_name = $record['created_by_name'];
                $miss_sale->save();

                Http::post(env('FETCH_BRANCH_API_URL_NEW') . 'update-is-sync', [
                    "type" => 'miss_sale',
                    "id" => $record['id']
                ]);


            }

            DB::commit();
            return response()->json(['message' => "MissSale data saved successfully."]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function fetchOpeningBalance($branch_url)
    {
        try {
            DB::beginTransaction();

            $curl = curl_init();
            $url = $branch_url . 'api/send-opening-balance';

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $data = curl_exec($curl);
            curl_close($curl);
            $balance = json_decode($data, true);
            $openingBalance = $balance['openBalance'];

            // Process and save the sales data and their items to the database
            foreach ($openingBalance as $record) {

                // Save the sale record
                $obalance = new OpeningBalance();
                $obalance->branch_id = $record['branch_id'];
                $obalance->user_id = $record['user_id'];
                $obalance->opening_balance = $record['opening_balance'];
                $obalance->date_time = $record['date_time'];
                $obalance->created_by = $record['created_by'];
                $obalance->created_by_name = $record['created_by_name'];
                $obalance->save();

                Http::post(env('FETCH_BRANCH_API_URL_NEW') . 'update-is-sync', [
                    "type" => 'opening_balance',
                    "id" => $record['id']
                ]);

            }

            DB::commit();
            return response()->json(['message' => "OpeningBalance data saved successfully. " ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function fetchCustomers($branch_url)
    {
        try {
            DB::beginTransaction();

            $curl = curl_init();
            $url = $branch_url . 'api/send-customers';

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $data = curl_exec($curl);
            curl_close($curl);
            $customers = json_decode($data, true);



            $customersData = $customers['customers'];



            // Process and save the sales data and their items to the database
            $customers = [];
            foreach ($customersData as $value) {

                // Convert the datetime to the correct format
                $dateTime = new DateTime($value['created_at']);
                $formattedCreatedAt = $dateTime->format('Y-m-d H:i:s');

                $dateTimeUp = new DateTime($value['updated_at']);
                $formattedUpAt = $dateTimeUp->format('Y-m-d H:i:s');

                $customers[] = [
                        'id' => $value['id'],
                        'name' => $value['name'],
                        'email' => $value['email'],
                        'phone' => $value['phone'],
                        'country' => $value['country'],
                        'city' => $value['city'],
                        'address' => $value['address'],
                        'is_marketing' => $value['is_marketing'],
                        'status' => $value['status'],
                        'created_at' => $formattedCreatedAt,
                        'updated_at' => $formattedUpAt,
                ];

                // Http::post(env('FETCH_BRANCH_API_URL_NEW') . 'update-is-sync', [
                //     "type" => 'customer',
                //     "id" => $record['id']
                // ]);

            }

            Customer::upsert($customers, 'phone');

            DB::commit();
            return response()->json(['message' => "Customer data saved successfully. " ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function fetchReturnSales($branch_url)
    {
        try {
            DB::beginTransaction();

            $curl = curl_init();
            $url = $branch_url . 'api/send-return-sales';

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $data = curl_exec($curl);
            curl_close($curl);
            $return_sales = json_decode($data, true);
            $returnSalesData = $return_sales['return_sales'];

            // Process and save the sales data and their items to the database
            foreach ($returnSalesData as $record) {

                $created_at = Carbon::parse($record['created_at']);
                // Add 5 hours to the created_at value
                $created_at->addHours(5);

                // Save the sale record
                $return = new SaleReturn();
                $return->branch_id = $record['branch_id'];
                $return->sales_id = $record['sales_id'];
                $return->sales_item_id = $record['sales_item_id'];
                $return->invoice_number = $record['invoice_number'];
                $return->product_id = $record['product_id'];
                $return->product_name = $record['product_name'];
                $return->quantity = $record['quantity'];
                $return->price = $record['price'];
                $return->reason = $record['reason'];
                $return->return_date = $record['return_date'];
                $return->created_at = $created_at->toDateTimeString();
                $return->updated_at = $record['updated_at'];
                $return->save();

                Http::post(env('FETCH_BRANCH_API_URL_NEW') . 'update-is-sync', [
                    "type" => 'return_sale',
                    "id" => $record['id']
                ]);

            }

            DB::commit();
            return response()->json(['message' => "SaleReturn data saved successfully. " ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function sendBranchesData()
    {
        try {
            // Fetch branches data from the database
            $branches = Branch::all(); // Or use any other query to get the required data

            // Assuming you want to return the data as JSON
            return response()->json([
                'success' => true,
                'branches' => $branches,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching branches data.',
            ], 500);
        }
    }

    public function sendSupplierData()
    {
        try {
            // Fetch supplier data from the database
            $suppliers = Supplier::all(); // Or use any other query to get the required data

            // Assuming you want to return the data as JSON
            return response()->json([
                'success' => true,
                'suppliers' => $suppliers,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching supplier data.',
            ], 500);
        }
    }

    public function sendProductData()
    {
        $products = Products::all();
        return response()->json(['products' => $products]);
    }

    public function sendCategoriesData()
    {
        try {
            // Fetch categories data from the database
            $categories = Category::all();

            return response()->json([
                'success' => true,
                'categories' => $categories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching categories data.',
            ], 500);
        }
    }

    public function sendSubCategoriesData()
    {
        try {
            // Fetch sub-categories data from the database
            $subCategories = SubCategories::all();

            return response()->json([
                'success' => true,
                'subCategories' => $subCategories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching sub-categories data.',
            ], 500);
        }
    }

    public function sendBrandsData()
    {
        try {
            // Fetch brands data from the database
            $brands = Brands::all();

            return response()->json([
                'success' => true,
                'brands' => $brands,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching brands data.',
            ], 500);
        }
    }

    public function sendUnitData()
    {
        try {
            // Fetch unit data from the database
            $productUnit = ProductUnit::all();

            return response()->json([
                'success' => true,
                'productUnit' => $productUnit,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching unit data.',
            ], 500);
        }
    }

    public function sendProductUnitStatusData()
    {
        try {
            // Fetch product unit status data from the database
            $productUnitStatuses = ProductUnitStatus::all();

            return response()->json([
                'success' => true,
                'productUnitStatuses' => $productUnitStatuses,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching product unit status data.',
            ], 500);
        }
    }

    public function sendPurchaseData()
    {
        try {
            // Fetch purchase data from the database
            $purchases = Purchases::all();

            return response()->json([
                'success' => true,
                'purchases' => $purchases,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching purchase data.',
            ], 500);
        }
    }

    public function sendPurchaseDetailData()
    {
        try {
            // Fetch purchase detail data from the database
            $purchaseDetails = PurchaseDetails::all();

            return response()->json([
                'success' => true,
                'purchaseDetails' => $purchaseDetails,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching purchase detail data.',
            ], 500);
        }
    }

    public function sendRoleData()
    {
        try {
            // Fetch role data from the database
            $roles = Role::all();

            return response()->json([
                'success' => true,
                'roles' => $roles,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching role data.',
            ], 500);
        }
    }

    public function sendPermissionData()
    {
        try {
            // Fetch permission data from the database
            $permissions = Permission::all();

            return response()->json([
                'success' => true,
                'permissions' => $permissions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching permission data.',
            ], 500);
        }
    }

    public function sendRolePermissionData()
    {
        try {
            // Fetch role permission data from the database
            $rolePermissions = RolePermission::all();

            return response()->json([
                'success' => true,
                'rolePermissions' => $rolePermissions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching role permission data.',
            ], 500);
        }
    }

    public function sendAdvertisementData()
    {
        try {
            // Fetch advertisement data from the database
            $advertisements = Advertisement::all();

            return response()->json([
                'success' => true,
                'advertisements' => $advertisements,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching advertisement data.',
            ], 500);
        }
    }

    public function sendCitiesData()
    {
        try {
            // Fetch cities data from the database
            $cities = City::all();

            return response()->json([
                'success' => true,
                'cities' => $cities,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching cities data.',
            ], 500);
        }
    }

    public function sendAreasData()
    {
        try {
            // Fetch areas data from the database
            $areas = Area::all();

            return response()->json([
                'success' => true,
                'areas' => $areas,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching areas data.',
            ], 500);
        }
    }
}