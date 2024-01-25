<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\Driver\Session;

class HomeController extends Controller
{
    public function index(){

        $link='https://staging.wecare.pk/api/categories';
        $categories=$this->curl($link);
        $categories=json_decode($categories);
        $categories=$categories->data;

        $link2='https://staging.wecare.pk/api/top_selling/top_selling';
        $top=$this->curl($link2);
        $top=json_decode($top);
        $top=$top->data;

        $link21='https://staging.wecare.pk/api/top_selling/deal';
        $deal=$this->curl($link21);
        $deal=json_decode($deal);
        $deal=$deal->data;


        $link3='https://staging.wecare.pk/api/top_selling/featured_product';
        $f_pro=$this->curl($link3);
        $f_pro=json_decode($f_pro);
        $f_pro=$f_pro->data;

        $link4='https://staging.wecare.pk/api/brands';
        $brands=$this->curl($link4);
        $brands=json_decode($brands);
        $brands=$brands->data;


        $link5='https://staging.wecare.pk/api/settings';
        $banners=$this->curl($link5);
        $banners=json_decode($banners);
        $banners=$banners->data;
        //dd($banners->first_banner);


       // dd($request->session()->get('areas'));
        return view('index',compact('categories','top','deal','f_pro','brands','banners'));
    }
    public function top_selling(){
        $link2='https://staging.wecare.pk/api/top_selling/top_selling';
        $top=$this->curl($link2);
        $top=json_decode($top);
        return $top->data;
    }


    public function categories(){
        $link='https://staging.wecare.pk/api/categories';
        $categories=$this->curl($link);
        $categories=json_decode($categories);
        $categories=$categories->data;
        $html="";
        //dd($categories);

        foreach ($categories as $cat){

           $html.="<a  href='".route('product.category_product',$cat->id) ."'>
                            <div class='col'>
                                <div class='medicine'>
                                    <div class='top-img ".  $cat->color ."'>
                                        <img src='". $cat->images ."' class='img-fluid'>
                                    </div>
                                    <div class='bottom-cont'>
                                        <h3>". $cat->name."</h3>
                                    </div>
                                </div>
                            </div>
                        </a>";
        }
        //dd($html);
        return $html;


    }

    public function area_session(Request $request){


        $link5='https://staging.wecare.pk/api/nearby_store/'.$request->area;
        $av_branch=$this->curl($link5);
        $av_branch=json_decode($av_branch);
        $av_branch=$av_branch->data;

        if($av_branch){
            \session()->put('area',$av_branch[0]->branch_id);
            \session()->put('area_name',$av_branch[0]->branch_name);
            return $av_branch[0]->branch_name;
        }else{
            return "No Available Branch For This Area";
        }
    }
    public function profile(){
        $link="https://staging.wecare.pk/api/profile";
        $token= "Token: ".\session()->get('token');
        $user_detail=$this->curlPost($link,$token);
        return view('user-profile',compact('user_detail'));
    }

    public function edit_profile(){
        $link="https://staging.wecare.pk/api/profile";
        $token= "Token: ".\session()->get('token');
        $user_detail=$this->curlPost($link,$token);
        return view('user-profile',compact('user_detail'));
    }


    public function address(){
        $link="https://staging.wecare.pk/api/address";
        $token= "Token: ".\session()->get('token');
        $address=$this->curlPost($link,$token);
        return view('address',compact('address'));

    }

    public function order_history(){

        $link="https://staging.wecare.pk/api/order_history";
        $token= "Token: ".\session()->get('token');
        $order=$this->curlPost($link,$token);
       // dd($order);
        return view('order_history',compact('order'));
    }

    public function order_detail($id){
        $link="https://staging.wecare.pk/api/order_detail/".$id;
        //dd($link);
        $orderdetail=$this->curl($link);

        return view('order_detail',compact('orderdetail'));

    }

    public function add_address(Request $request){

        $link1="https://staging.wecare.pk/api/add_address";
        $address=[
            'city_id'=>1,
            'area_id'=>$request->area,
            'street'=>$request->street,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
            'location_name'=>$request->location_name,
            'token'=>\session()->get('token'),
        ];
       // dd($address);
        $address=$this->curlPost2($link1,$address);
       return redirect()->back();

    }

    public function delete_address(){

        $link="https://staging.wecare.pk/api/delete_address";
        $token= "Token: ".\session()->get('token');
        $address=$this->curlPost($link,$token);
        return view('address',compact('address'));

    }

    public function instand_order(Request $request){

        $link="https://staging.wecare.pk/api/prescription";
        $token= "Token: ".\session()->get('token');
        if($token == 'Token: '){
            $token=0;
        }
        $file = $request->file('prescription_image');
        $filename = $file->getClientOriginalName();
        $file->move(public_path('prescriptions'), $filename);


        $prescription=[
            'user_id'=>$token,
            'name'=>$request->patient_name,
            'phone'=>$request->patient_phone,
            'prescription_image'=>asset( 'public/prescriptions/'.$filename),
        ];
        $this->curlPost2($link,$prescription);
        $response = "success";


        $link2='https://staging.wecare.pk/api/top_selling/deal';
        $deal=$this->curl($link2);
        $deal=json_decode($deal);
        $deal=$deal->data;

        return view('prescription',compact('response','deal'));

    }
    public function logout(){
        $link="https://staging.wecare.pk/api/customer-logout";
        $token= "Token: ".\session()->get('token');
        $this->curlPost($link,$token);

        //unset hofa session
        \session()->forget('token');
        \session()->forget('name');

        return redirect()->route('home');

    }


    function curlPost2($link1,$address){




            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $link1,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $address,


            ));

            $response = curl_exec($curl);

            curl_close($curl);
      return $response;



    }
    function curlPost($link,$token){

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $link,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array($token),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return  json_decode($response);


    }
    function curl($link){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $link,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
