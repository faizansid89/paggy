<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Inventory;
use App\Models\OpeningBalance;
use App\Models\Products;
use App\Models\PurchaseDetails;
use App\Models\Purchases;
use App\Models\ReceiveItem;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'Reports';
        $this->section->heading = 'Reports';
        $this->section->slug = 'reports';
        $this->section->folder = 'reports';
    }


    public function itemMaster(Request $request)
    {
        $section = $this->section;

        $inventories = Inventory::query();

        $inventories->with(['branch', 'product', 'category']);

        // filters here
        if ($request->has('branch_id')) {
            if ($request->branch_id != "") {
                $inventories->where('branch_id', $request->branch_id);
            }
        }

        $inv = $inventories->get();
        $inventory = $inv->groupBy('product_id');

        $branches = Branch::where('status', 1)->pluck('name', 'id')->toArray();
        return view($section->slug . '.item_master', compact('section', 'inventory', 'branches'));
    }

    public function grossReport(Request $request)
    {
        $section = $this->section;
        $section->title = 'Add Products';
        $section->method = 'POST';
        $section->route = $section->slug . '.store';

        $branches = Branch::where('status', 1)->pluck('name', 'id')->toArray();
        $toDate = request()->get('to_date');
        $fromDate = request()->get('from_date');

        $totalGrossProfit = 0;
        $totalSale = 0;

        $condition = ['cash', 'card'];
        $todaySaleNew = SaleItem::with(['sales' => function ($query) use ($condition) {
            $query->whereIn('status', $condition);
        }])->when($toDate && $fromDate, function ($query) use ($toDate, $fromDate) {
            $to = \Carbon\Carbon::parse($toDate)->addDay()->format('Y-m-d');
            $from = \Carbon\Carbon::parse($fromDate)->format('Y-m-d');
            $query->whereBetween('sale_items.created_at', [$from, $to]);
        })->where('is_return', 0)->get();

        return view($section->slug . '.gross_report_testing', compact('section', 'branches', 'todaySaleNew'));

        /*

        $sales = SaleItem::join('receive_items as ri1', function ($join) {
            $join->on('sale_items.sku', '=', 'ri1.sku')
                ->whereRaw('ri1.id = (SELECT MAX(id) FROM receive_items WHERE sku = ri1.sku)');
        })
            ->leftJoin('receive_items as ri2', function ($join) {
                $join->on('sale_items.batch_code', '=', 'ri2.batch_code');
            })
            ->join('purchase_details', function ($join) {
                $join->on('purchase_details.id', '=', DB::raw('IFNULL(ri2.purchase_detail_id, ri1.purchase_detail_id)'));
            })
            ->join('product_unit_status as pus1', function ($join) {
                $join->on('purchase_details.product_id', '=', 'pus1.product_id')
                    ->on('purchase_details.unit_id', '=', 'pus1.unit_id');
            })
            ->join('product_unit_status as pus2', function ($join) {
                $join->on('sale_items.product_id', '=', 'pus2.product_id')
                    ->on('sale_items.unit_id', '=', 'pus2.unit_id');
            })
            ->when($toDate && $fromDate, function ($query) use ($toDate, $fromDate) {
                $to = \Carbon\Carbon::parse($toDate)->addDay()->format('Y-m-d');
                $from = \Carbon\Carbon::parse($fromDate)->format('Y-m-d');

                $query->whereBetween('sale_items.created_at', [$from, $to]);
            })
            ->where('sale_items.is_return', 0)
            ->select('sale_items.*', 'sale_items.created_at as itemDate', 'sale_items.quantity as itemQuantity', 'sale_items.discount as saleDiscount', 'sale_items.unit_id as saleItemUnit', 'ri1.*', DB::raw('IFNULL(ri2.purchase_detail_id, ri1.purchase_detail_id) AS purchase_detail_id'), 'purchase_details.*', DB::raw('pus1.quantity AS unit_quantity'), DB::raw('pus2.quantity AS sale_unit_quantity'), DB::raw('purchase_details.cost_price AS unit_cost_price'))
            //->limit(20)
            ->get();

        $date = '2023-07-12';
        $condition = ['cash', 'card'];
//        $results = Sale::whereDate('created_at', $date)->where('is_return', 0)->where('status', '!=' ,'credit')->get();
        $todaySaleNew = SaleItem::with(['sales' => function ($query) use ($condition) {
            $query->whereIn('status', $condition);
        }])->when($toDate && $fromDate, function ($query) use ($toDate, $fromDate) {
            $to = \Carbon\Carbon::parse($toDate)->addDay()->format('Y-m-d');
            $from = \Carbon\Carbon::parse($fromDate)->format('Y-m-d');

            $query->whereBetween('sale_items.created_at', [$from, $to]);
        })->where('is_return', 0)->get();

        //dd($todaySaleNew->toArray());


        if ($request->get('view') == "testing") {


            $totalGrossProfit = 0;
            $totalSale = 0;
            foreach ($sales as $sale) {
                $quantity_sale_item = $sale->itemQuantity;
                $product_name = $sale->product_name;
                $price = $sale->price;
                $unit_name = $sale->saleItemUnit . ' - ' . $sale->unit_name;
                $quantity_sale_item = $sale->itemQuantity;
                $sub_total = $sale->sub_total;

                $unit_quantity = ($sale->unit_quantity != 0) ? $sale->unit_quantity : 1;
                $unit_cost_price = $sale->unit_cost_price;
                $sale_unit_quantity = $sale->sale_unit_quantity;


                if ($sale->saleItemUnit == 1 && $unit_cost_price > 0 && $unit_quantity > 0) {
                    $calculation = $unit_cost_price / $unit_quantity;
                    $gross = $sub_total - ($calculation * $quantity_sale_item);
                } else {
                    $calculation = $unit_cost_price / $unit_quantity;
                    $gross = $sub_total - ($calculation * $sale_unit_quantity);
                }
                $totalGrossProfit += $gross;
                $totalSale += $sub_total;
            }


            return view($section->slug . '.gross_report_testing', compact('section', 'sales', 'branches', 'totalGrossProfit', 'totalSale', 'todaySaleNew'));
        } else {


            $products = [];
            $encountered_product_ids = [];
            $totalGrossProfit = 0;
            $totalSale = 0;
            foreach ($sales as $sale) {

                $quantity_sale_item = $sale->itemQuantity;
                $product_name = $sale->product_name;
                $price = $sale->price;
                $unit_name = $sale->saleItemUnit . ' - ' . $sale->unit_name;
                $quantity_sale_item = $sale->itemQuantity;
                $sub_total = $sale->sub_total;

                $unit_quantity = ($sale->unit_quantity != 0) ? $sale->unit_quantity : 1;
                $unit_cost_price = $sale->unit_cost_price;
                $sale_unit_quantity = $sale->sale_unit_quantity;
                if ($sale->saleItemUnit == 1 && $unit_cost_price > 0 && $unit_quantity > 0) {
                    $calculation = $unit_cost_price / $unit_quantity;
                    $gross = $sub_total - ($calculation * $quantity_sale_item);
                } else {
                    $calculation = $unit_cost_price / $unit_quantity;
                    $gross = $sub_total - ($calculation * $sale_unit_quantity);
                }

                if ($sale_unit_quantity == 1) {
                    $cp = $calculation * $quantity_sale_item;
                } else {
                    $cp = $calculation * $sale_unit_quantity;
                }


                if (!in_array($sale->product_id, $encountered_product_ids)) {
                    $encountered_product_ids[] = $sale->product_id;
                    $products[$sale->product_id]['product_name'] = $sale->product_name;
                    $products[$sale->product_id]['sub_total'] = $sale->sub_total;
                    $products[$sale->product_id]['cost_price'] = $cp;
                    $products[$sale->product_id]['created_at'] = $sale->itemDate;

                    $gp = $sale->sub_total - $cp;
                    $products[$sale->product_id]['gross_profit'] = $gp;

                } else {
                    $products[$sale->product_id]['product_name'] = $sale->product_name;
                    $products[$sale->product_id]['sub_total'] += $sale->sub_total;
                    $products[$sale->product_id]['cost_price'] += $cp;
                    $products[$sale->product_id]['created_at'] = $sale->itemDate;

                    $gp = $sale->sub_total - $cp;
                    $products[$sale->product_id]['gross_profit'] += $gp;
                }

                $totalGrossProfit += $gp;
                $totalSale += $sub_total;

            }


            return view($section->slug . '.gross_report', compact('section', 'sales', 'branches', 'totalGrossProfit', 'totalSale', 'products'));
        }
        */
    }

    public function GenerateCostPrice()
    {
        $saleItems = SaleItem::where('cost_price', '=', NULL)->orderBy('id', 'DESC')->get();
//        $saleItems = SaleItem::where('id', 85)->get();
//        dd('GenerateCostPrice', $saleItems->toArray());

        foreach ($saleItems as $saleItem){
            if($saleItem->batch_code != NULL){
                $receviedItem = ReceiveItem::with(['purchaseDetailData', 'productUnitState'])->where('sku', $saleItem->sku)->where('batch_code', $saleItem->batch_code)->orderBy('id', 'DESC')->first();
//                dd('Batch Code', $saleItem->batch_code, $receviedItem->toArray());
            }
            else {
                $receviedItem = ReceiveItem::with(['purchaseDetailData', 'productUnitState'])->where('sku', $saleItem->sku)->orderBy('id', 'DESC')->first();
//                dd('SKU Only', $saleItem->sku, $receviedItem->toArray(), '====================');
            }


            if(($receviedItem) && ($receviedItem->purchaseDetailData != null)){
                if($receviedItem->purchaseDetailData->unit_id == $saleItem->unit_id){
                    $costPrice = $receviedItem->purchaseDetailData->cost_price * $saleItem->quantity;
                }
                else {
//                dump($receviedItem->purchaseDetailData->unit_id, $receviedItem->purchaseDetailData->cost_price);
                    foreach ($receviedItem->productUnitState as $productUnitState){
                        if($productUnitState->unit_id == $saleItem->unit_id){
                            $saleQuantity = $productUnitState->quantity;
                        }

//                    dump('***********');

                        if($productUnitState->unit_id == $receviedItem->purchaseDetailData->unit_id){
                            $purchaseQuantity = $productUnitState->quantity;
                        }
                    }

                    $perPeacePrice = $receviedItem->purchaseDetailData->cost_price / $purchaseQuantity;
                    $costPrice = ($perPeacePrice * $saleQuantity)  * $saleItem->quantity;
                }
                $saleItem->cost_price =  $costPrice;
                $saleItem->save();
                dump("Update Item Number : ". $saleItem->id);
            }
        }
    }


    public function showProductBatchCode(Request $request)
    {
        $product = Products::where('id', $request->product_id)->first();
        $html = '';
        if($product->is_batch_code == 1){
            $receivedItems = ReceiveItem::where('product_id', $request->product_id)->pluck('purchase_id', 'batch_code')->toArray();
            foreach ($receivedItems as $key => $receivedItem){
                $html .= '<tr><td><a href="'.route('purchases.show', $receivedItem).'" target="_blank">Purchase Order # '.$receivedItem.'</a></td><td class="batchCodeNumber">'.$key.'</td><td><a href="'.route("updateSpecificSaleItemBatchCode", ['sale_lineItem' => $request->sale_line_item, 'batch_code' => $key]) .'" class="btn btn-primary btn-sm">Update This</a></td></tr>';
            }
        }
        else {
            $html .= '<tr><td colspan="3">No Batch Code Available</td></tr>';
        }
        return $html;
    }

    public function updateSpecificSaleItemBatchCode(Request $request, $sale_lineItem, $batch_code)
    {
        // Update Batch Code
        SaleItem::where('id', $sale_lineItem)->update(['batch_code' => $batch_code]);

        $saleItem = SaleItem::where('id', $sale_lineItem)->first();

        $receviedItem = ReceiveItem::with(['purchaseDetailData', 'productUnitState'])->where('sku', $saleItem->sku)->where('batch_code', $batch_code)->orderBy('id', 'DESC')->first();
//        dd($receviedItem->toArray(), $sale_lineItem, $batch_code, $saleItem->toArray());

        if(($receviedItem) && ($receviedItem->purchaseDetailData != null)){
            if($receviedItem->purchaseDetailData->unit_id == $saleItem->unit_id){
                $costPrice = $receviedItem->purchaseDetailData->cost_price * $saleItem->quantity;
            }
            else {
//                dump($receviedItem->purchaseDetailData->unit_id, $receviedItem->purchaseDetailData->cost_price);
                foreach ($receviedItem->productUnitState as $productUnitState){
                    if($productUnitState->unit_id == $saleItem->unit_id){
                        $saleQuantity = $productUnitState->quantity;
                    }

//                    dump('***********');

                    if($productUnitState->unit_id == $receviedItem->purchaseDetailData->unit_id){
                        $purchaseQuantity = $productUnitState->quantity;
                    }
                }

                $perPeacePrice = $receviedItem->purchaseDetailData->cost_price / $purchaseQuantity;
                $costPrice = ($perPeacePrice * $saleQuantity)  * $saleItem->quantity;
            }
            $saleItem->cost_price =  $costPrice;
            $saleItem->save();
        }

        $request->session()->flash('alert-success', 'Batch Code has been Updated successfully.');
        return redirect()->back();
    }




    public function cashierReport(Request $request)
    {
        $section = $this->section;
        $branches = Branch::where('status', 1)->pluck('name', 'id')->toArray();
        $createdByArray = DB::table('sales')
            ->select('created_by', 'created_by_name')
            ->distinct()
            ->pluck('created_by_name', 'created_by')
            ->toArray();

        if (!empty($request->from_date) || !empty($request->biller_id)) {

            // sales
            $s = Sale::query();

            // opening balance
            $o = OpeningBalance::query();

            $from = \Carbon\Carbon::parse($request->from_date);
            if (!empty($request->from_date)) {
                $o = $o->whereDate('created_at', $from);
                $s = $s->whereDate('created_at', $from);
            }
            if (isset($request->biller_id)) {
                $o->where('user_id', $request->biller_id);
                $s->where('created_by', $request->biller_id);
            }

            $opening_balance = $o->get();
            $sales = $s->get();

            $open_bal = $opening_balance->sum('opening_balance');
            $total_Sales = $sales->sum('total');

        } else {
            $opening_balance = $open_bal = $total_Sales = $sales = [];
        }

        return view($section->slug . '.cashier_report', compact('section', 'opening_balance', 'branches', 'createdByArray', 'open_bal', 'sales', 'total_Sales'));
    }


    public function saleReport(Request $request)
    {
        $section = $this->section;
        $branches = Branch::where('status', 1)->pluck('name', 'id')->toArray();

//        $sales = Sale::with(['sales_items', 'customer', 'branch'])->get();

        $saleTotal = Sale::query();

        $s = Sale::query();
        //$s = $s->where('is_return',0);
        $s = $s->with(['sales_items', 'customer', 'branch'])->where('is_return', 0);
        // filters here
        if (!empty($request->from_date) || !empty($request->to_date)) {
            $to = \Carbon\Carbon::parse($request->to_date)->format('Y-m-d');
            $from = \Carbon\Carbon::parse($request->from_date)->addDay()->format('Y-m-d');
            $s->whereBetween('created_at', [$to, $from]);
            $saleTotal->whereBetween('created_at', [$to, $from]);
        }
        if (isset($request->branch_id)) {
            $s->where('branch_id', $request->branch_id);
        }
        if (isset($request->status)) {
            $s->where('status', $request->status);
        }
        $sales = $s->get();

//        dd($sales->toArray());
        return view($section->slug . '.sale_report', compact('section', 'sales', 'branches'));
    }

    public function minQtyNotification(Request $request)
    {
        $section = $this->section;
        $branches = Branch::where('status', 1)->pluck('name', 'id')->toArray();
        $products = [];
        if (isset($request->branch_id)) {
            $p = Products::query();
            $p = $p->with(['getInventory' => function ($q) use ($request) {
                $q->where('branch_id', $request->branch_id);
            }])->where('status', 1);
            $products = $p->get();
        }


        return view($section->slug . '.min_alert_html', compact('products', 'section', 'branches'));

//        $dompdf = new Dompdf();
//        $dompdf->loadHtml($html);
//        $dompdf->setPaper('A4', 'landscape');
//        $dompdf->render();
//
//        $pdfOutput = $dompdf->output();
//        $filename = 'document.pdf';
//
//        Storage::disk('public')->put($filename, $pdfOutput);
//        $filePath = Storage::disk('public')->path($filename);
//
//        Mail::send([], [], function($message) use ($filePath, $filename) {
//            $message->to('recipient@example.com')
//                ->subject('PDF Attachment')
//                ->attach($filePath, [
//                    'as' => $filename,
//                    'mime' => 'application/pdf',
//                ])
//                ->setBody('Hello, this email contains a PDF attachment. Please see the attachment for more information.');
//        });
//
//        request()->session()->flash('alert-success','Email has been sent.');
//        return redirect()->back();

    }

    public function processSelectedProducts(Request $request)
    {

        $validationMessages = [
        ];

        $validator = Validator::make($request->all(), [
            'product.unit' => 'required',
            'product.unit_id' => 'required',
            'product.cost_price' => 'required',
            'product.total' => 'required',
        ], $validationMessages);

        //validation fails
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        } else {

            $data = [
                'date' => date('d-m-Y'),
                'branch_id' => 1,
                'supplier_id' => 1,
                'created_by' => auth()->user()->id,
                'status' => 'pending',
            ];
            $purchasesItem = Purchases::create($data);
            foreach ($request->product as $product) {
                $purchases = new PurchaseDetails();
                $purchases->purchase_id = $purchasesItem->id;
                $purchases->product_id = $product['product_id'];
                $purchases->quantity = $product['quantity'];
                $purchases->unit = $product['unit'];
                $purchases->unit_id = $product['unit_id'];
                $purchases->cost_price = $product['cost_price'];
                $purchases->discount = $product['discount'];
                $purchases->total = $product['total'];
                $purchases->created_by = auth()->user()->id;
                $purchases->save();
            }

            return redirect()->route("purchases.edit", $purchasesItem->id);
        }

    }


    public function priceAnalysisReport(Request $request)
    {
        $section = $this->section;
        $supplier = Supplier::where('status', 1)->distinct()->pluck('name', 'id')->toArray();
        $receiveItems = ReceiveItem::select('product_id', DB::raw('MAX(id) as max_id'))->groupBy('product_id')->get();

        /*foreach( $receiveItems as $receiveItem ){
            $purchaseDetails = PurchaseDetails::with('supplier', 'units')->where('product_id', $receiveItem->product_id)->get();
            foreach ($purchaseDetails as $purchaseDetail){
                $supp[] =  $purchaseDetail->supplier->name;
            }
        }*/

        //$supplier = array_unique($supp);

        return view($section->slug . '.price_analysis_report', compact('section', 'receiveItems', 'supplier'));
    }

    public function topSellingProducts(Request $request)
    {
        $section = $this->section;
        return view($section->slug . '.top_selling_products', compact('section'));
    }

    public function expiryReport(Request $request)
    {
        $section = $this->section;

        $fromExpiryDate = $request->input('from_expiry_date');
        $toExpiryDate = $request->input('to_expiry_date');


        $receiveItems = ReceiveItem::with('product')->select('product_id', 'batch_code', 'description', DB::raw('SUM(quantity) as total_quantity'), DB::raw('MAX(id) as max_id'))
            //->where('product_id', 262)
            ->where('is_batch_code', '=', 1)
            ->groupBy('product_id', 'batch_code', 'description')
            ->when($fromExpiryDate, function ($query) use ($fromExpiryDate) {
                $fromDate = Carbon::parse($fromExpiryDate)->startOfDay();
                return $query->where('description', '>=', $fromDate);
            })
            ->when($toExpiryDate, function ($query) use ($toExpiryDate) {
                $toDate = Carbon::parse($toExpiryDate)->endOfDay();
                return $query->where('description', '<=', $toDate);
            })
            ->get();


//        foreach ($receiveItems as $receiveItem) {
//            $sale_items = SaleItem::where('product_id', $receiveItem->product_id)->where('batch_code', $receiveItem->batch_code)->get();
//            dd($sale_items);
//            if ($sale_items->count() > 0) {
//                foreach($sale_items as $sale_item) {
//
//                    dd($sale_item);
//                }
//            }
//        }
//
//        dd('f');

        //dd($receiveItems->toArray());


//        foreach($receiveItems as $receiveItem){
//
//
//            echo "Product ID :". $receiveItem->product_id.'<br>';
//            echo "Batch Code :". $receiveItem->batch_code.'<br>';
//            echo "Quantity :". $receiveItem->total_quantity.'<br>';
//            echo "<br><hr/>";
//
//            $sale_items = SaleItem::where('product_id',$receiveItem->product_id)->where('batch_code',$receiveItem->batch_code)->get();
//
//            if(count($sale_items)>0) {
//                echo "<br>";
//                echo "sales item found!". '<br>';
//                foreach ($sale_items as $sale_item) {
//
//                    $totQty[] = $sale_item->quantity;
//
//                    $totalqtyleft = $receiveItem->total_quantity - $sale_item->quantity;
//
//                    echo "Product ID :" . $sale_item->product_id . '<br>';
//                    echo "Batch Code :" . $sale_item->batch_code . '<br>';
//                    echo "Quantity :" . $sale_item->quantity . '<br>';
//                    echo "Expiry :" . $receiveItem->description . '<br>';
//                    echo "Stock left :" . $totalqtyleft . '<br>';
//                    echo "<br><hr/>";
//
//
//
//                }
//            } else {
//                echo "sales item not found!". '<br>';
//                echo "<br><hr/>";
//            }
//
//
//        }
//
//
//
//        dd($receiveItems->tOArray());


        return view($section->slug . '.expiry_report', compact('section', 'receiveItems'));
    }


    public function InventoryCostReport()
    {

        $section = $this->section;

        $inventory = Products::with(['getInventory', 'productUnitState' => function ($query) {
            $query->where('unit_id', 1)->orWhere('quantity', 1);
        }])->where('status', 1)->get();

//        dd($inventory->toArray());

        return view($section->slug . '.inventory_cost_report',compact('section','inventory'));
    }

}
