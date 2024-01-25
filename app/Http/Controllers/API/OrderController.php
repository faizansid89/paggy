<<<<<<< HEAD
=======
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Orderitem;



class OrderController extends Controller
{
    public function order_proceed(Request $request){
        // return $request->order_no;

        $data_order=[
            'order_no'=>$request->order_no,
            'customer_id'=>$request->customer_id,
            'date'=>$request->date,
            'shipping_address'=>$request->shipping_address,
            'billing_address'=>$request->billing_address,
            'payment_method'=>$request->payment_method,
            'discount'=>$request->discount,
            'shipping_charges'=>$request->shipping_charges,
            'total'=>$request->total,
            'status'=>$request->status,
            'order_through'=>$request->order_through,
            'order_type'=>$request->order_type,
        ];

        $order=Order::create($data_order);

        foreach($request->orderItem as $item){
            $data=[
                'order_id'=>$order->id,
                'order_no'=>$item['order_no'],
                'product_id'=>$item['product_id'],
                'product_name'=>$item['product_name'],
                'product_qty'=>$item['product_qty'],
                'product_type'=>$item['product_type'],
                'product_subtotal'=>$item['product_subtotal'],
                'item_processOrder'=>$item['item_processOrder'],
            ];
            Orderitem::create($data);

        }

        $dataa['status']=200;
        $dataa['msg']="Order place Successfully";
        $dataa['success']=true;
        return response()->json($dataa);


    }

    public function order_history(Request $request){
        $customer = authenticateCustomer($request->header('Token'));
        $order_history=Order::with('order_detail')->where('customer_id',$customer->id)->get();
        return $order_history;
    }

    public function order_detail($order_id){
        $order_detail=Orderitem::where('order_id',$order_id)->get();
        return $order_detail;
    }

    public function prescription(Request $request){

        if($request->hasFile('prescription')){
            $image= $request->file('prescription');
            $image_name=date('his').'-'.$image->getClientOriginalName();
            $image->move(public_path('prescription'), $image_name);
            //$request->request->remove('prescription_image');

            //$request->prescription_image = $image_name;
           $request->request->add(['prescription_image'=>asset('prescription/'.$image_name)]);
            //dd($request->toArray());
        }
        Prescription::create($request->all());
        $dataa['status']=200;
        $dataa['msg']="Prescription place Successfully";
        $dataa['success']=true;
        return response()->json($dataa);
    }

    public function prescrip($user_id){

        $pres=Prescription::where('user_id',$user_id)->orderBy('id',"DESC")->get();
        $dataa['data']=$pres;
        $dataa['status']=200;
        $dataa['msg']="Successfully";
        $dataa['success']=true;
        return response()->json($dataa);

    }

}
>>>>>>> cadbf20e819f42c88b6ae80ab2013f9840a44660
