<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Http\Requests\Api\SaveInventory;
use App\Http\Requests\Api\SaveInventoryRequest;
use App\Models\Branch;
use App\Models\Brands;
use App\Models\Categories;
use App\Models\Inventory;
use App\Models\Products;
use App\Models\ProductUnit;
use App\Models\ProductUnitStatus;
use App\Models\PurchaseDetails;
use App\Models\Purchases;
use App\Models\ReceiveItem;
use App\Models\SaleItem;
use App\Models\SubCategories;
use App\Models\Supplier;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'Products';
        $this->section->heading = 'Products';
        $this->section->slug = 'products';
        $this->section->folder = 'products';
    }

    public function index()
    {
        checkPermission('read-product');
        $section = $this->section;
        $products = Products::with(['categories', 'brands', 'units', 'users', 'subCategory', 'productUnitState'])->get();
//        dd($products->toArray());
        $section->method = 'POST';
        $section->route = 'uploadproduct';
        return view($section->folder . '.index', compact('products', 'section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        checkPermission('create-product');
        $products = [];
        $section = $this->section;
        $section->title = 'Add Products';
        $section->method = 'POST';
        $section->route = $section->slug . '.store';

        $categories = Categories::pluck('name', 'id')->toArray();
        $brands = Brands::pluck('name', 'id')->toArray();
        $units = ProductUnit::pluck('name', 'id')->toArray();
        $subCategories = SubCategories::pluck('name', 'id')->toArray();
        return view($section->folder . '.form', compact('section', 'products', 'categories', 'subCategories', 'brands', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $section = $this->section;

        //define custom validation messages for validator
        $validationMessages = [
            'name.unique' => 'Product name already exist. Please enter a unique product name',
        ];
        // validate user input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:products,name',
            'status' => 'required|boolean',
        ], $validationMessages);

        //validation fails
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        } else {
            $request->request->add(['created_by' => auth()->user()->id]);
            $productUnits = $request->unit;
            $request->request->remove('unit');
            $product = Products::create($request->all());
            if(isset($productUnits)) {
                foreach ($productUnits as $productUnit) {
                    $productUnitStatus = new ProductUnitStatus();
                    $productUnitStatus->product_id = $product->id;
                    $productUnitStatus->unit_id = $productUnit['unit_id'];
                    $productUnitStatus->quantity = $productUnit['quantity'];
                    $productUnitStatus->cost_price = $productUnit['cost_price'];
                    $productUnitStatus->sale_price = $productUnit['sale_price'];
                    $productUnitStatus->created_by = auth()->user()->id;
                    $productUnitStatus->save();
                }
            }

            $request->session()->flash('alert-success', 'Record has been added successfully.');
            return redirect()->route($section->slug . '.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Categories $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Products $product)
    {
        $section = $this->section;
        $section->title = 'Products';

        $product = Products::with(['categories', 'brands', 'units', 'users', 'subCategory'])->where('id', $product->id)->first();
        $productUnitStatus = ProductUnitStatus::with('units')->where('product_id', $product->id)->get();
        //dd($productUnitStatus->toArray());
        $inventery =Inventory:: with('branch')->where('product_id',$product->id)->get();
       // dd($inventery);

        $receviedItems = ReceiveItem::where('product_id', $product->id)->pluck('purchase_id', 'batch_code');

        return view($section->folder . '.show', compact('product', 'productUnitStatus', 'section','inventery', 'receviedItems'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Categories $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $product)
    {
        $products = $product;
        $section = $this->section;
        $section->title = 'Edit Product';
        $section->method = 'PUT';
        $section->route = [$section->slug . '.update', $product];

        $categories = Categories::pluck('name', 'id')->toArray();
        $brands = Brands::pluck('name', 'id')->toArray();
        $units = ProductUnit::pluck('name', 'id')->toArray();
        $subCategories = SubCategories::pluck('name', 'id')->toArray();
        $productUnitStatus = ProductUnitStatus::where('product_id', $product->id)->get();
        return view($section->folder . '.form', compact('section', 'products', 'categories', 'subCategories', 'brands', 'units', 'productUnitStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Categories $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $product)
    {
        checkPermission('update-product');
//        dd($request->toArray(), $category->toArray());
        $section = $this->section;

        //define custom validation messages for validator
        $validationMessages = [
//            'name.unique' => 'Product name already exist. Please enter a unique product name',
        ];
        // validate user input
        $validator = Validator::make($request->all(), [
//            'name' => 'required|string|unique:products,name,' . $product->id . ',id',
            'status' => 'required|boolean'
        ], $validationMessages);

        //validation fails
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        } else {

            // Add Image Function Start
            $gallery = "";
            $old_gallery_ids = "";

            if ($request->has('images_old')) {
                $old_gallery_ids = implode(",", $request->images_old);
            }

            if ($request->has('images')) {
                $gallery = $request->images;
            }

            if ($old_gallery_ids && empty($gallery)) {
                $merge_gallery = $old_gallery_ids;
            } elseif ($gallery && empty($old_gallery_ids)) {
                $merge_gallery = $gallery;
            } else {
                $merge_gallery = $old_gallery_ids . ',' . $gallery;
            }

            if ($merge_gallery == ",") {
                $merge_gallery = null;
            }

            $request->request->remove('images_old');
            $request->request->add(['images' => $merge_gallery]);
            // Add Image Function End


            ProductUnitStatus::where('product_id', $product->id)->delete();

            $productUnits = $request->unit;
            $request->request->remove('unit');
            if(isset($productUnits)) {
                foreach ($productUnits as $productUnit) {
                    $productUnitStatus = new ProductUnitStatus();
                    $productUnitStatus->product_id = $product->id;
                    $productUnitStatus->unit_id = $productUnit['unit_id'];
                    $productUnitStatus->quantity = $productUnit['quantity'];
                    $productUnitStatus->cost_price = $productUnit['cost_price'];
                    $productUnitStatus->sale_price = $productUnit['sale_price'];
                    $productUnitStatus->created_by = auth()->user()->id;
                    $productUnitStatus->save();
                }
            }

            $product->update($request->all());
            $request->session()->flash('alert-success', 'Record has been updated successfully.');
            return redirect()->route($section->slug . '.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Categories $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        //
    }

    public function generateRandomNumber(Request $request)
    {
        if ($request->ajax()) {

            $units = ProductUnit::get();
            $options = '';
            foreach ($units as $unit) {
                $options .= '<option value="' . $unit->id . '">' . $unit->name . '</option>';
            }

            $count = Carbon::now()->timestamp + rand(100, 999);

            $html = '<div class="row" id="unitRow"><div class="col-lg-3 col-sm-6 col-12"><div class="form-group"><label>Unit</label>';
            $html .= '<select class="form-control form-select select2" required="required" name="unit[' . $count . '][unit_id]"><option selected="selected" value="">Select Unit</option>' . $options . '</select>';
            $html .= '</div></div><div class="col-lg-3 col-sm-6 col-12"><div class="form-group"><label>Qty</label>';
            $html .= '<input class="form-control" placeholder="Enter Unit Qty" required="required" name="unit[' . $count . '][quantity]" type="text">';
            $html .= '</div></div><div class="col-lg-3 col-sm-6 col-12"><div class="form-group"><label>Cost Price</label>';
            $html .= '<input class="form-control" placeholder="Enter Cost Price" required="required" name="unit[' . $count . '][cost_price]" type="text">';
            $html .= '</div></div><div class="col-lg-3 col-sm-6 col-12"><div class="form-group"><label>Sale Price</label><div class="row"><div class="col-lg-10 col-sm-10 col-10">';
            $html .= '<input class="form-control" placeholder="Enter Sale Price" required="required" name="unit[' . $count . '][sale_price]" type="text">';
            $html .= '</div><div class="col-lg-2 col-sm-2 col-2 ps-0"><div class="add-icon"><a href="javascript:void(0);" class="btnRemoveUnit">';
            $html .= '<img src="' . asset('assets/img/icons/delete1.svg') . '" alt="img"></a></div></div></div></div></div></div>';
            return $html;
        }
    }


    public function searchProduct(Request $request)
    {
        if ($request->ajax()) {
            $data = Products::with('productUnitState')->orderBy('id', 'DESC')->where('name', 'like', '%' . $request->search_product_name . '%')->orWhere('sku', 'like', '%' . $request->search_product_name . '%')->get();
            $output = '';
            if (count($data) > 0) {
                $output = '<table class="table"><tbody>';
                foreach ($data as $row) {
//                    dd($row->productUnitState->cost_price);
                    if ($row->images != null) {
                        $image = explode(',', $row->images);
                        $image = $image[0];
                    } else {
                        $image = 'https://via.placeholder.com/50';
                    }

                    $statusRecord = ($row->status == 0) ? '<span class="badges bg-lightred">Block</span>' : '<span class="badges bg-lightgreen">Active</span>';

                    $output .= '<tr><td class="productimgname"><a class="product-img getProductBySearch"  data-toggle="modal" data-target="#myModal"  data-product-id="' . $row->id . '" data-product-image="' . $image . '" data-product-name="' . $row->name . '" data-product-price="' . $row->productUnitState->cost_price . '">' . $row->name . ' - <span class="badges bg-dark">' .$row->sku.'</span> - '. $statusRecord .'</a></td></tr>';
                }
                $output .= ' </tbody></table>';
            } else {
                $output .= '<tr><td class="productimgname">No Result Found</td></tr>';
            }
            return $output;
        }
    }

    public function searchProductByID(Request $request)
    {
        if ($request->ajax()) {
            $data = Products::where('id', $request->search_product_id)->first();
            $output = '';
            if (count($data) > 0) {
                $output = '<table class="table"><tbody>';
                foreach ($data as $row) {
                    if ($row->images != null) {
                        $image = explode(',', $row->images);
                        $image = $image[0];
                    } else {
                        $image = 'https://via.placeholder.com/50';
                    }
                    $output .= '<tr><td class="productimgname"><a class="product-img getProductBySearch" data-product-id="' . $row->id . '"><img src="' . $image . '" alt="product">' . $row->name . '</a></td></tr>';
                }
                $output .= ' </tbody></table>';
            } else {
                $output .= '<tr><td class="productimgname">No Result Found</td></tr>';
            }
            return $output;
        }
    }

    public function getProductUnits(Request $request)
    {
        if($request->ajax()) {
            $productUnits = ProductUnitStatus::with('units')->where('product_id', $request->search_product_id)->get();

            $options = '';

            foreach ($productUnits as $productUnit){
                $options .= '<option value="'.$productUnit->cost_price.'" data-id="'.$productUnit->unit_id.'">'.$productUnit->units->name.'</option>';
            }

            $html = '<select class="form-control form-select select2" required="required" name="unit" id="selectProductType"><option selected="selected" value="">Select Unit</option>'.$options.'</select>';

            return $html;
        }
    }


    //---------------- Admin Api---------------\\


    //---------------- Get_Details for branch Api---------------\\

    public function get_details()
    {
        // $products = Products::with('units', 'categories', 'brands')->get();
        $branches = Branch::all();
        $supplier = Supplier::all();
        $products = Products::all();
        $categories = Categories::all();
        $subCategories = SubCategories::all();
        $brands = Brands::all();
        $unit = ProductUnit::all();
        $product_unit_status = ProductUnitStatus::all();
        $purchase = Purchases::all();
        $purchaseDetail = PurchaseDetails::all();

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
        ]);
    }


    public function uploadproduct(Request $request)
    {

        $file = $request->file('file');
        if ($file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $this->checkUploadedFileProperties($extension, $fileSize);
            $filepath = $file->move(public_path('uploads'), $filename);
            $file = fopen($filepath, "r");
            $importData_arr = array();
            $i = 0;
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);
                if ($i == 0) {
                    $i++;
                    continue;
                }
                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }
            fclose($file);
            $j = 0;
            foreach ($importData_arr as $importData) {

                //$brand = Products::where('name', $importData[3])->first();
               // dd($importData);
//                if (empty($brand)) {
//                    $productid = Products::create([
//                        'name' => $importData[3],
//                        'sku' => $importData[1],
//                        'category_id' => $importData[6],
//                        'sub_category_id' => $importData[7],
//                        'brand_id' => $importData[8],
//                        'unit_id' => $importData[9],
//                        'cost_price' => 0,
//                        'sale_price' => 0,
//                        'tax' => $importData[12],
//                        'discount' => "0",
//                        'description' => $importData[15],
//                        'is_free' => 0,
//                        'is_batch_code' => "0",
//                        'images' => "no image",
//                        'min_alert_qty' => $importData[16],
//                        'status' => '1',
//                        'created_by' => '1',
//                        'created_at' => $importData[21],
//                        'updated_at' => $importData[22]
//                    ]);

                    if (empty($brand)) {
                        $productid = Products::create([
                            'name' => $importData[1],
                            'sku' => $importData[0],
                            'category_id' => $importData[2],
                            'sub_category_id' => 0,
                            'brand_id' => $importData[6],
                            'unit_id' => 1,
                            'cost_price' => 0,
                            'sale_price' => 0,
                            'tax' => 0,
                            'discount' => "0",
                            'description' => 0,
                            'is_free' => 0,
                            'is_batch_code' => "0",
                            'images' => "no image",
                            'min_alert_qty' => $importData[7],
                            'status' => '1',
                            'created_by' => '1',
                            'created_at' => date("Y-d-m"),
                            'updated_at' => date("Y-d-m")
                        ]);
                    //dd($productid->id);

                    ProductUnitStatus::create([
                        'product_id' => $productid->id,
                        'unit_id' => '1',
                        'quantity' => '1',
                        'cost_price' => $importData[8],
                        'sale_price' => $importData[8],
                        'created_by' => '1',
                        'created_at' => date("Y-d-m"),
                        'updated_at' => date("Y-d-m")
                    ]);


                    $j++;
                } else {
                    $section = $this->section;
                    $request->session()->flash('alert-success', 'Some Record Already Exist.');
                    //return redirect()->route($section->slug . '.index');
                }
            }
            $section = $this->section;
            $request->session()->flash('alert-success', 'Record has been uploaded successfully.');
            return redirect()->route($section->slug . '.index');
        } else {
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }

    }

    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = array("csv", "xlsx"); //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }

//    public function saveInventory(Request $request)
//    {
//
//        $data = [
//            'branch_auto_id' => $request->branch_auto_id,
//            'branch_id' => $request->branch_id,
//            'type' => $request->type,
//            'bill_id' => $request->bill_id,
//            'product_id' => $request->product_id,
//            'sku' => $request->sku,
//            'batch_code' => $request->batch_code,
//            'quantity' => $request->quantity,
//            'cost_price' => $request->cost_price,
//            'sale_price' => $request->sale_price,
//            'total' => $request->total,
//            'profit' => $request->profit,
//            'is_sync' => $request->is_sync,
//            'created_by' => $request->created_by,
//        ];
//
//        $inventory = Inventory::create($data);
//
//    }

//    public function saveReceiveItems(Request $request)
//    {
//
//        $data = [
//            'product_id' => $request->product_id,
//            'is_batch_code' => $request->is_batch_code,
//            'sku' => $request->sku,
//            'batch_code' => $request->batch_code,
//            'purchase_id' => $request->purchase_id,
//            'purchase_detail_id' => $request->purchase_detail_id,
//            'quantity' => $request->quantity,
//            'description' => $request->description,
//            'created_by' => $request->created_by
//        ];
//
//        $receive_item = ReceiveItem::create($data);
//
//
//    }

    public function getData(Request $request)
    {
//        dd( $request->toArray(), $request->branch_auto_id);

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

        dd($data);



        if (isset($data['inventory'])) {
            $count = 0;
            $inventoryBatchCode = [];
            foreach ($data['inventory'] as $value) {

                $cdate = new DateTime($value['created_at']);
                $created_at = $cdate->format('Y-m-d H:i:s');

                $udate = new DateTime($value['updated_at']);
                $updated_at = $udate->format('Y-m-d H:i:s');

                $inventoryBatchCode[] = [
                    'branch_auto_id' => $value['branch_auto_id'],
                    'branch_id' => $value['branch_id'],
                    'product_id' => $value['product_id'],
                    'category_id' => $value['category_id'],
                    'product_name' => $value['product_name'],
                    'sku' => $value['sku'],
                    'quantity' => $value['quantity'],
                    'is_sync' => $value['is_sync'],
                    'created_by' => $value['created_by'],
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ];
                $count++;
                if ($count == 1000) {
                    Inventory::create($inventoryBatchCode, ['id']);
                    $count = 0;
                    $inventoryBatchCode = [];
                }
            }
            Inventory::create($inventoryBatchCode, ['id']);
        }

        if (isset($data['receiveItem'])) {
            $count = 0;
            $receiveItemBatchCode = [];
            foreach ($data['receiveItem'] as $value) {

                $cdate = new DateTime($value['created_at']);
                $created_at = $cdate->format('Y-m-d H:i:s');

                $udate = new DateTime($value['updated_at']);
                $updated_at = $udate->format('Y-m-d H:i:s');

                $receiveItemBatchCode[] = [
                    'id' => $value['id'],
                    'product_id' => $value['product_id'],
                    'is_batch_code' => $value['is_batch_code'],
                    'sku' => $value['sku'],
                    'batch_code' => $value['batch_code'],
                    'purchase_id' => $value['purchase_id'],
                    'purchase_detail_id' => $value['purchase_detail_id'],
                    'quantity' => $value['quantity'],
                    'description' => $value['description'],
                    'is_sync' => $value['is_sync'],
                    'created_by' => $value['created_by'],
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ];
                $count++;
                if ($count == 1000) {
                    ReceiveItem::upsert($receiveItemBatchCode, ['id']);
                    $count = 0;
                    $receiveItemBatchCode = [];
                }
            }
            ReceiveItem::upsert($receiveItemBatchCode, ['id']);
        }

        $response['msg'] = 'Successfully Save1';
        $response['status'] = 200;
        return response()->json($response);



//        $url = env('FETCH_BRANCH_API_URL');
//
//        $curl = curl_init($url);
//        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//
//        //for debug only!
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//
//        $resp = curl_exec($curl);
//        curl_close($curl);
//        $data = json_decode($resp, true);
//
//
//
//
//        if (isset($data['inventory'])) {
//            $count = 0;
//            $unit = [];
//            foreach ($data['inventory'] as $value) {
//
//                $cdate = new DateTime($value['created_at']);
//                $created_at = $cdate->format('Y-m-d H:i:s');
//
//                $udate = new DateTime($value['updated_at']);
//                $updated_at = $udate->format('Y-m-d H:i:s');
//
//                $unit[] = [
//                    'id' => $value['id'],
//                    'branch_auto_id' => $value['branch_auto_id'],
//                    'branch_id' => $value['branch_id'],
//                    'type' => $value['type'],
//                    'bill_id' => $value['bill_id'],
//                    'product_id' => $value['product_id'],
//                    'sku' => $value['sku'],
//                    'batch_code' => $value['batch_code'],
//                    'quantity' => $value['quantity'],
//                    'cost_price' => $value['cost_price'],
//                    'sale_price' => $value['sale_price'],
//                    'total' => $value['total'],
//                    'profit' => $value['profit'],
//                    'is_sync' => $value['is_sync'],
//                    'created_by' => $value['created_by'],
//                    'created_at'  => $created_at,
//                    'updated_at'  => $updated_at,
//                ];
//                $count++;
//                if ($count == 1000) {
//                    Inventory::upsert($unit, 'id');
//                    $count = 0;
//                    $unit = [];
//                }
//            }
//            Inventory::upsert($unit, 'id');
//        }
//
//        if (isset($data['receiveItem'])) {
//            $count = 0;
//            $unit = [];
//            foreach ($data['receiveItem'] as $value) {
//
//                $cdate = new DateTime($value['created_at']);
//                $created_at = $cdate->format('Y-m-d H:i:s');
//
//                $udate = new DateTime($value['updated_at']);
//                $updated_at = $udate->format('Y-m-d H:i:s');
//
//                $unit[] = [
//                    'id' => $value['id'],
//                    'product_id' => $value['product_id'],
//                    'is_batch_code' => $value['is_batch_code'],
//                    'sku' => $value['sku'],
//                    'batch_code' => $value['batch_code'],
//                    'purchase_id' => $value['purchase_id'],
//                    'purchase_detail_id' => $value['purchase_detail_id'],
//                    'quantity' => $value['quantity'],
//                    'description' => $value['description'],
//                    'is_sync' => $value['is_sync'],
//                    'created_at' => $created_at,
//                    'updated_at' => $updated_at,
//                ];
//                $count++;
//                if ($count == 1000) {
//                    ReceiveItem::upsert($unit, 'id');
//                    $count = 0;
//                    $unit = [];
//                }
//            }
//            ReceiveItem::upsert($unit, 'id');
//        }


    }


    public function product_inven(){
        $section = $this->section;
        $section->title = 'Update Inventory';
        $section->heading = 'Inventory';
        $section->method = 'POST';
        $section->route = $section->slug . '.fileUpload';
        $products=[];
        return view($section->folder . '.fileUpload', compact( 'section','products'));


    }


    public function fileUpload(Request $request)
    {

        $file = $request->file('file');
        if ($file) {
            $filename = "9090_" . $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $this->checkUploadedFileProperties($extension, $fileSize);
            $filepath = $file->move(public_path('uploads'), $filename);
            $file = fopen($filepath, "r");
            $importData_arr = array();
            $i = 0;
            while (($filedata = fgetcsv($file, 10000, ",")) !== FALSE) {
                $num = count($filedata);
                if ($i == 0) {
                    $i++;
                    continue;
                }
                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];


                }
                $i++;
            }
            fclose($file);
            $j = 0;

            //dd($importData_arr);
            foreach ($importData_arr as $importData) {

                //dd($importData[0],$importData[1],$importData[2],$importData[3]);
                    $dataInvcentery=[
                        'quantity'=>$importData[3]
                    ];
                    Inventory::where('sku',$importData[1])->where('product_name',$importData[0])->update($dataInvcentery);
                    $j++;
            }
            $request->session()->flash('alert-success', $j.' Records has been Update Successfully.');
            return redirect()->route('products.product_inven');
        }
    }


    public function exportSelected(Request $request)
    {
        $rows = explode(',', $request->input('rows'));
        // Query the database to retrieve the selected rows
        $products = Products::whereIn('id', $rows)->get()->toArray();
        // Export the data to Excel format
        //return Excel::download(new ProductsExport($products), 'products.xlsx');
        return Excel::download(new ProductsExport($products), 'products.xls', \Maatwebsite\Excel\Excel::XLS);
    }


    public function InventoryUpdateProduct(Request $request, $sale_id)
    {

//        $inventories = Inventory::whereNotNull('branch_quantity')->get();
        $inventories = Inventory::get();
//        dd("InventoryUpdateProduct", $sale_id, $inventories->toArray());
        foreach ($inventories as $inventory){
//            $saleItems = SaleItem::where('sales_id', '>=', $sale_id)->where('sku', $inventory->sku)->get();
//            if(count($saleItems) != 0){
//                $itemQuantity = 0;
//                foreach ($saleItems as $saleItem){
//                    $productUnit = ProductUnitStatus::where('product_id', $saleItem->product_id)->where('unit_id', $saleItem->unit_id)->first();
//                    $itemQuantity += $productUnit->quantity * $saleItem->quantity;
//                }
//                $inventory->branch_quantity_new = $inventory->branch_quantity;
//                $inventory->quantity = $inventory->branch_quantity - $itemQuantity;
//                $inventory->save();
//                dump("Inventory ID : " . $inventory->id .' - Inventory Quantity : '. $itemQuantity);
////                dump($inventory->toArray(), $itemQuantity);
//            }
//            else {
//                $inventory->branch_quantity_new = $inventory->branch_quantity;
//                $inventory->quantity = $inventory->branch_quantity;
//                $inventory->save();
//                dump("Inventory ID : " . $inventory->id);
//            }


//            dd($inventory->toArray());
            if($inventory->branch_quantity != null){
                $inventory->branch_quantity_time = $inventory->quantity;
                $inventory->branch_quantity_new = $inventory->branch_quantity;
                $inventory->quantity = $inventory->branch_quantity;
                $inventory->save();
            }
            else {
                $inventory->branch_quantity_time = $inventory->quantity;
                $inventory->quantity = 0;
                $inventory->save();
            }
        }
        dd('DONE');
    }

}
