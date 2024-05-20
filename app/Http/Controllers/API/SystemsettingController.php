<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Feedback;
use App\Models\Subscription;
use App\Models\SystemSetting;
use App\Models\TextType;
use App\Models\Order;
use Illuminate\Http\Request;

class SystemsettingController extends Controller
{
    public function settings(){

        $data['web_logo']=SystemSetting::where('type','web_logo')->first();
        $data['favicon']=SystemSetting::where('type','favicon')->first();
        $data['first_banner']=SystemSetting::where('type','first_banner')->get();
        $data['second_banner']=SystemSetting::where('type','second_banner')->get();
        $success['data']=$data;
        $success['msg']='successfully!';
        $success['status']=200;
        $success['success'] =true;

        return response()->json($success);
    }


    public function subscription(){
            $email=$_GET['email'];
            $check=Subscription::where('email',$email)->first();
            if(empty($check)){
                $data['email']=$email;
                Subscription::create($data);
                $success['msg']='Successfully Add!';
                $success['status']=200;
                $success['success'] =true;
                return response()->json($success);
            }else{
                $success['msg']='Already Add!';
                $success['status']=202;
                $success['success'] =true;
                return response()->json($success);
            }

    }

    public function text_type($type){
        $text=TextType::where('type',$type)->first();
        $data['data'] =$text;
        $data['status'] =200;
        $data['msg'] ='Success';
        $data['success'] =true;
        return response()->json($data);
    }



    public function feedback(Request $request){
        Feedback::create($request->all());
        $success['msg']='Successfully Add!';
        $success['status']=200;
        $success['success'] =true;
        return response()->json($success);
    }

    public function faq(){
        $faq=Faq::get();
        $success['data']=$faq;
        $success['msg']='Successfully Add!';
        $success['status']=200;
        $success['success'] =true;
        return response()->json($success);
    }

    public function test(){
           $data = [
                ['date' => '2023-07-19', 'time' => '09:00:00'],
                ['date' => '2023-07-19', 'time' => '13:30:00'],
                ['date' => '2023-07-20', 'time' => '10:15:00'],
                ['date' => '2023-07-20', 'time' => '15:45:00'],
                // Add more records here
            ];
            
            
            
            $groupedData = [];

            foreach ($data as $record) {
                $date = $record['date'];
                $time = $record['time'];
            
                if (!isset($groupedData[$date])) {
                            echo "0-";
                    $groupedData[$date] = [];
                }
           
                $groupedData[$date][] = $time;
               
            }
            
            
            dd($groupedData);
foreach ($groupedData as $date => $times) {
    echo "Date: $date<br>";
    foreach ($times as $time) {
        echo "Time: $time<br>";
    }
    echo "<br>";
}
            
        }

}