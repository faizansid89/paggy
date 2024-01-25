<?php

namespace App\Http\Controllers;

use App\Models\HoldOrder;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Prescription;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->section = new \stdClass();
        $this->section->title = 'Orders';
        $this->section->heading = 'All Orders';
        $this->section->slug = 'orders';
    }


    public function index()
    {
        $section = $this->section;
        $order = Order::with('user')->orderBy('id', 'DESC')->get();
        return view('system_setting.order.index', compact('section', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $section = $this->section;
        $order = Order::find($id);
        \Cart::clear();
        foreach ($order->order_detail as $detail) {
                // add items to cart
                \Cart::add(array(
                    'id' => $detail->product->sku, // inique row ID
                    'name' => $detail->product_name,
                    'price' => $detail->product_subtotal,
                    'quantity' => $detail->product_qty,
                    'attributes' => array(
                        'customer_id' => $order->customer->id,
                        'customer_name' => $order->customer->name,
                    ),
                ));
        }
        $cart = \Cart::getContent()->toArray();
        $session_items = $this->cartView();
        return view('system_setting.order.show', compact('section','session_items'));
    }

    public function deleteProduct(Request $request)
    {
        $productSku = $request->sku;

        if ($productSku == "all") {

            \Cart::clear();
            $cart = $this->cartView();
            return response()->json([
                'message' => 'All Products has been deleted.',
                'url' => route('orders.index'),
            ]);

        } else {

//            \Cart::remove($productSku);
//            $cart = $this->cartView();
//            return response()->json([
//                'message' => 'Product has been deleted.',
//                'cart' => $cart,
//            ]);

        }
    }

    public function updateProduct(Request $request)
    {
        $msg = 'Product quantity has been updated.';
        $productSku = $request->sku;
        $productQty = $request->quantity;
        $current_cart = \Cart::get($productSku);
        $inv = Inventory::where('sku',$productSku)->first();
        if($current_cart->quantity >= $inv->quantity ){
            $msg = "Inventory Storage Limit exceeded";
            $cart = $this->cartView();
            return response()->json([
                'message' => $msg,
                'cart' => $cart,
            ]);
        } else {
            $discount = $current_cart->attributes->discount;
            $tax = $current_cart->attributes->tax;
            $total_item_price = $current_cart->price * ($current_cart->quantity + $productQty);
            $taxx = $total_item_price * ($tax / 100);
            $discounts = ($total_item_price + $taxx)  * ($discount / 100);
            $total_item_price = $total_item_price + $taxx;
            $total_item_price = $total_item_price - $discounts;
            \Cart::update($productSku, array(
                'price' => $current_cart->price,
                'quantity' => $productQty, // so if the current product has a quantity of 4, it will subtract 1 and will result to 3
                'attributes' => [
                    'discount' => $discount,
                    'tax' => $tax,
                    'unit_name' => $request->unit_name,
                    'total_item_price' => $total_item_price,
                ]
            ));
            $cart = $this->cartView();
            return response()->json([
                'message' => $msg,
                'cart' => $cart,
            ]);
        }
    }

    public function orderSale(Request $request)
    {
        $session_items = \Cart::getContent()->toArray();

        foreach($session_items as $key => $item){
            $customer_id    = $item['attributes']['customer_id'];
            $customer_name  = $item['attributes']['customer_name'];
        }

        $sale = Sale::create([
            'branch_id' =>  2,
            'sale_auto_id' => 0,
            'customer_id' =>  $customer_id,
            'customer_name' => $customer_name,
            'status' => 'cash',
            'discount' => 0,
            'total' => \Cart::getTotal(),
            'created_by' => auth()->user()->id,
            'created_by_name' => auth()->user()->name,
        ]);

        $sale->update(['sale_auto_id' => $sale->id ]);


        foreach($session_items as $item){

          //  dd($item);

//            if (str_contains($item['id'], '@')) {
//                $barcode = explode('@', $item['id']);
//                $product_id =  $barcode[0];
//                $sku = $barcode[0];
//                $batchcode = $barcode[1];
//            }
//            else {
                $sku = $item['id'];
                $batchcode = null;
                $product_id = $item['id'];
            //}

            $product_id = getProductIdBySku($product_id);

            // dd($item);

//            if($item['attributes']['unit_name'] == "Pcs"){
//                $unit_id = 1;
//            } elseif ($item['attributes']['unit_name'] == "Strip"){
//                $unit_id = 2;
//            } elseif ($item['attributes']['unit_name'] == "Box"){
//                $unit_id = 3;
//            } elseif ($item['attributes']['unit_name'] == "Crate"){
//                $unit_id = 4;
//            } elseif ($item['attributes']['unit_name'] == "BOTTLE"){
//                $unit_id = 5;
//            }

            $sale_item = SaleItem::create([
                'sales_id' => $sale['id'],
                'sku' => $sku,
                'saleitem_auto_id' => 0,
                'batch_code' => $batchcode,
                'product_id' => $product_id,
                'product_name' =>  $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'tax' => $item['attributes']['tax'] ?? 0,
                'discount' => $item['attributes']['discount'] ?? 0,
                'unit_id' => $item['attributes']['unit_id'] ?? 1,
                'unit_name' => $item['attributes']['unit_name'] ?? "Pcs",
                'sub_total' => $item['attributes']['total_item_price'] ?? 0,
                'created_by' => auth()->user()->id,
                'created_by_name' => auth()->user()->name,
            ]);


            $sale_item->update(['saleitem_auto_id' => $sale_item->id ]);

//            $inv = Inventory::where('product_id',$product_id)->first();
//            $inv->quantity -= $item['quantity'];
//            $inv->save();


        }


        $generator = new \Picqer\Barcode\BarcodeGeneratorSVG();
        $timestamp = Carbon::now()->timestamp;
        file_put_contents(public_path('invoice/'.$timestamp.'.svg'), ($generator->getBarcode($sale->invoice_number, $generator::TYPE_CODE_128)));
        $imagePath = asset('invoice/'.$timestamp.".svg"); // public_path("barcode.svg");
        $total = (strlen(\Cart::getTotal()) > 25) ? substr(\Cart::getTotal(),0,25).'...' : \Cart::getTotal();

        $date = Carbon::now();
        $formattedDate = $date->format('M j, Y g:i A');

        $html = '<div style="width: 330px;height: 96px;text-align: center;">';
        $html .= '<p style="text-align: center;margin:10px auto 30px auto;"><img  height="80" width="150" src="'. asset('assets/img/logo_black.png') .'" /></p>';
        $html .= '<p style="font-size: 14px;text-align: left;text-align: left;font-size: 14px;margin: 0 !important;">FBR Invoice #: 123456789</p>';
        $html .= '<p style="text-align: left;font-size: 14px;margin: 0 !important;">'.getBranch()->city.' - '.getBranch()->short_code.' - '.getBranch()->name.'</p>';
        $html .= '<p style="text-align: left;font-size: 14px;text-align: left;font-size: 14px;margin: 0 !important;">GST # 12-34-56</p>';
        $html .= '<p style="text-align: left;font-size: 14px;text-align: left;font-size: 14px;margin: 0 !important;">Transaction No.: '.$sale->invoice_number.'</p>';
        $html .= '<p style="text-align: left;font-size: 14px;margin: 0 !important;">Transaction Date:'.$formattedDate.'</p>';
        $html .= '<p style="text-align: left;font-size: 14px;margin: 0 !important;">User: '.$sale->user->name.'</p>';
        $html .= '<p style="text-align: left;font-size: 14px;margin: 0 !important;">Customer: '.$sale->customer_name.'</p>';
        $html .= '<p style="text-align: left;font-size: 14px;margin: 0 !important;border: 1px dashed;"></p>';
        $html .= '<p style="text-align: center;font-size: 14px;font-size: 20px;font-weight: 800;">Original Receipt</p>';
        $html .= '<p style="text-align: left;font-size: 14px;margin: 0 !important;border: 1px dashed;margin-bottom: 20px !important;"></p>';
        $html .= '<p style="text-align: center;font-size: 15px;font-weight: 800;">Sales Items</p>';
        $html .= '<p style="text-align: left;font-size: 14px;margin: 0 !important;border: 1px dashed;margin-bottom: 20px !important;"></p>';
        $html .= '<table style="width:100%">';
        $qty = [];
        $html .= '<tr>';
        $html .= '<th colspan="3" style="text-align: left;">Product Description</th>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th style="text-align: left; width: 20%;">Qty</th>';
        $html .= '<th style="text-align: left; width: 30%;text-align: left;">Price</th>';
        $html .= '<th style="text-align: left; width: 30%;text-align: left;">Discount</th>';
        $html .= '<th style="text-align: left; width: 30%;text-align: left;">GST Rate</th>';
        $html .= '<th style="text-align: left; width: 30%;text-align: left;">Total</th>';
        $html .= '</tr>';


        foreach($session_items as $item){

            $disc = (isset($item['attributes']['discount'])) ? $item['attributes']['discount'] : 0;
            $tax = (isset($item['attributes']['tax'])) ? $item['attributes']['tax'] : 0;
            $total_item_price = (isset($item['attributes']['total_item_price'])) ? $item['attributes']['total_item_price'] : 0;

            $qty[] = $item['quantity'];
            $discount[] = ($item['price'] * $item['quantity']) * ( $disc / 100);
            $sales_tax[] = ($item['price'] * $item['quantity']) * ( $tax / 100);
            $html .= '<tr>';
            $html .= '<td colspan="3" style="font-weight: 900;font-size: 13px;width:150px;">'.$item['name'].'</td>';
            $html .= '</tr>';

            $html .= '<tr>';
            $html .= '<td style="font-weight: 600;font-size: 13px; width: 20%;">'.$item['quantity'].'</td>';
            $html .= '<td style="font-weight: 600;font-size: 13px; width: 30%;text-align: left;">'.getAmountFormat($item['price']).'</td>';
            $html .= '<td style="font-weight: 600;font-size: 13px; width: 30%;text-align: left;">'.$disc.'%</td>';
            $html .= '<td style="font-weight: 600;font-size: 13px; width: 30%;text-align: left;">'.$tax.'%</td>';
            $html .= '<td style="font-weight: 600;font-size: 13px; width: 30%;text-align: left;">'.getAmountFormat($total_item_price).'</td>';
            $html .= '</tr>';


        }
        $html .= '</table>';
        $html .= '<p style="text-align: left;font-size: 14px;margin: 0 !important;border: 1px dashed;margin-top: 20px !important;"></p>';
        $html .= '<p style="font-weight:bold;font-size: 20px;">Invoice Value:'.getAmountFormat(\Cart::getTotal()).'</p>';
        $html .= '<p style="text-align: left;font-size: 14px;margin: 0 !important;border: 1px dashed;margin-bottom: 20px !important;"></p>';

        $total_discount = array_sum($discount);
        $total_tax = array_sum($sales_tax);


        $html .= '<p style="text-align: center;text-align: left;font-weight:bold;font-size: 14px;margin-top: 9px !important;">Total Amount: '.getAmountFormat(\Cart::getTotal()).'</p>';
        $html .= '<p style="text-align: center;text-align: left;font-weight:bold;font-size: 14px;margin-top: 9px !important;">Total Discount: '.getAmountFormat($total_discount).'</p>';
        $html .= '<p style="text-align: center;text-align: left;font-weight:bold;font-size: 14px;margin: 0 !important;">Sales Tax: '.getAmountFormat($total_tax).' </p>';

        $html .= '<p style="text-align: center;text-align: left;font-weight:bold;font-size: 14px;margin-top: 9px !important;">POS Service Fee: 0</p>';
        $html .= '<p style="text-align: center;text-align: left;font-weight:bold;font-size: 14px;margin-top: 9px !important;">Given Amount: '.getAmountFormat($request->given_amount).'</p>';
        $html .= '<p style="text-align: center;text-align: left;font-weight:bold;font-size: 14px;margin-top: 9px !important;">Change Due: '.getAmountFormat($request->return_amount).'</p>';
        $html .= '<p style="text-align: left;text-align: left;font-weight:bold;font-size: 14px;margin: 0 !important;border: 1px dashed;margin-bottom: 20px !important;"></p>';

        $html .= '<ol style="margin-left: -30px;" >';
        $html .= '<li style="text-align: left;font-size: 13px;margin-top: 6px !important;">Returns/Exchange are accepted within 3 days from the date of purchase.</li>';
        $html .= '<li style="text-align: left;font-size: 13px;margin-top: 6px !important;">The original receipt or proof of purchase must be presented for the return.</li>';
        $html .= '<li style="text-align: left;font-size: 13px;margin-top: 6px !important;">Item being returned must be in its original packaging and in resalable condition. This means it cannot be opened, used, or damaged in any way.</li>';
        $html .= '<li style="text-align: left;font-size: 13px;margin-top: 6px !important;">Products such as refrigerated items, inhalers, sprays, loose tablets or capsules, test strips , baby milk  will not be returned or exchanged.</li>';
        $html .= '<li style="text-align: left;font-size: 13px;margin-top: 6px !important;">We Care Pharmacy shall not be held liable for any side effects or adverse reactions caused by the medication.</li>';
        $html .= '<li style="text-align: left;font-size: 13px;margin-top: 6px !important;">Customer information can be utilized for promoting products or services, providing special offers or discounts, conducting market research, and performing data analysis. We can also write to avoid legal issues </li>';
        $html .= '<li style="text-align: left;font-size: 13px;margin-top: 6px !important;">We care Pharmacy strongly discourage self medication and Valid Prescription will be required for purchasing of medicines.</li>';
        $html .= '</ol>';
        $html .= '<p style="text-align: left;text-align: left;font-weight:bold;font-size: 14px;margin: 0 !important;border: 1px dashed;margin-bottom: 20px !important;"></p>';

        //$html .= '<p style="font-size: 12px; margin: 5px 0px 3px; ">'. $total .'</p>';
        $html .= '<img src="'. $imagePath .'" />';
        $html .= '<p>'. $sale->invoice_number .'</p>';
        $html .= '</div>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->set_base_path(public_path('invoice'));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $pdfOutput = $dompdf->output();
        $filename = 'invoice-'.$sale->invoice_number.'.pdf';
        $path = public_path('invoice/');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        file_put_contents($path.$filename, $pdfOutput);

        $pdf_path = url('/invoice/'.$filename);

        $sale->update(['pdf' => $pdf_path ]);

        //Storage::disk('public')->put($filename, $pdfOutput);

        cache()->forget('custom_id');

        \Cart::clear();

        return response()->json([
            'message' => 'Order has been placed',
            'url' => route('cart.clear'),
            'html' => $html,
            'redirect_to' => route('orders.index')
        ]);
    }

    public static function cartView()
    {
        $session_items = \Cart::getContent()->toArray();
        // Ascending order by name
        usort($session_items, function ($a, $b) {
            return $a['name'] <=> $b['name'];
        });
        return view('system_setting.order.cart', compact('session_items'))->render();
    }

    public function prescription_get()
    {

        $section = $this->section;
        $pres = Prescription::orderBy('id', "DESC")->get();
        return view('system_setting.order.prescription', compact('section', 'pres'));

    }
}
