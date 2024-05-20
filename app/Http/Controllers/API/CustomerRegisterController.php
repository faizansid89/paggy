<?php

namespace App\Http\Controllers\API;


use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerRegisterController extends BaseController
{
    public function customerRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|unique:customers,phone',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $request->request->add(['status' => 1]);
        $input = $request->except('c_password');
        $input['password'] = bcrypt($input['password']);
        $customer = Customer::create($input);
        $success['name'] = $customer->name;
        $success['email'] = $customer->email;
        $success['phone'] = $customer->phone;
        $success['profile_picture'] = $customer->profile_picture;

        // Generate and store the API token
        $token = $customer->generateApiToken();
        $success['token'] = $token;

        return $this->sendResponse($success, 'Customer register successfully.');
    }

    public function customerLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:customers,email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $userlogin = ($request->has('email')) ? $request->email : $request->phone;

        if ($request->has('email')) {
            $customer = Customer::where('email', $userlogin)->first();
        } else {
            $customer = Customer::where('phone', $userlogin)->first();
        }

        if ($customer && Hash::check($request->password, $customer->password)) {

            $success['token'] = $customer->generateApiToken();
            $success['name'] = $customer->name;
            $success['email'] = $customer->email;
            $success['phone'] = $customer->phone;
            $success['profile_picture'] = $customer->profile_picture;
            return $this->sendResponse($success, 'Customer login successfully.');
        } else {
            $success['success'] = false;
            return $this->sendError($success, 'Incorrect password');
        }

    }

    public function customerForgotPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:customers,email',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $email = $request->input('email');
        $token = mt_rand(10000, 99999); // Generate a 5-digit random number

        // Save the token in the "customer_password_resets" table
        DB::table('customer_password_resets')->insert([
            'email' => $email,
            'token' => '12345',
            'created_at' => now(),
        ]);

//        Mail::send('emails.forgot-password', ['token' => $token], function ($message) use ($email) {
//            $message->to($email)->subject('Password Reset Token');
//        });

        $success['success'] = true;
        return $this->sendResponse($success, 'Token sent to your email address.');


//        $response = $this->broker()->sendResetLink(
//            $request->only('email')
//        );
//
//        if ($response === Password::RESET_LINK_SENT) {
//            $success['success'] = true;
//            return $this->sendResponse($success, 'Reset link sent to your email address.');
//        } else {
//            $success['success'] = false;
//            $success['message'] = $response;
//            return $this->sendError($success, ['error' => 'Unable to send reset link.']);
//        }
    }

    private function broker()
    {
        return Password::broker('customers');
    }

    public function verifyOTP(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:customers,email',
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $credentials = [
            'token' => $request->token,
            'email' => $request->email,
        ];

        $tokenData = DB::table('customer_password_resets')
            ->where('email', $credentials['email'])
            ->latest()
            ->first();

        if (!$tokenData || $credentials['token'] != $tokenData->token) {
            return $this->sendError('error', ['error' => 'Invalid token provided.']);
        }

        /*
        if (!$tokenData || !Hash::check($credentials['token'], $tokenData->token)) {
             return $this->sendError('error', ['error' => 'Invalid token provided.']);
         }

         $user = Customer::where('email', $credentials['email'])->first();
         $user->password = Hash::make($credentials['password']);
         $user->save();
        */

        /*
        DB::table('customer_password_resets')
            ->where('email', $credentials['email'])
            ->delete();
        */

        $success['data'] = $tokenData;
        return $this->sendResponse($success, 'OTP is correct.');
    }

    public function resetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:customers,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $credentials = [
            'email' => $request->email,
            'password' =>$request->password
        ];

        $tokenData = DB::table('customer_password_resets')
            ->where('email', $credentials['email'])
            ->first();


        $user = Customer::where('email', $credentials['email'])->first();
        $user->password = Hash::make($credentials['password']);
        $user->save();


        DB::table('customer_password_resets')
            ->where('email', $credentials['email'])
            ->delete();

        $success['success'] = true;
        return $this->sendResponse($success, 'Password reset successfully.');
    }

    public function profile(Request $request){

        $customer = authenticateCustomer($request->header('Token'));
        return $customer;
    }

    public function customerEditProfile(Request $request)
    {

        //dd($request->header('Token'));
        $customer = authenticateCustomer($request->header('Token'));

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

       // $data = $request->only('profile_picture','name');

        $name['name']=$request->name;
        $name['email']=$request->email;
        $name['phone']=$request->phone;

        if($request->file('profile_picture')){

            $image = $request->file('profile_picture');
            $imageName = date('his')."-".$image->getClientOriginalName();
            $image->move(public_path('attachments'),$imageName);
            $imageNameAfterUpload = asset('/attachments/'.$imageName);
            $name['profile_picture']=$imageNameAfterUpload;
        }

        $customer->update($name);
        $success['success'] = true;
        return $this->sendResponse($success, 'profile updated successfully.');
    }

    public function customerLogout(Request $request)
    {
        $apiToken = $request->header('Token');
        // Split the token to retrieve the customer ID
        $parts = explode('-', $apiToken);
        $customerId = $parts[0];

        // Retrieve the customer based on the ID
        $customer = Customer::find($customerId);

        if ($customer) {
            $customer->update(['api_token'=>null,'token_expires_at'=>null]);
            return $this->sendResponse('success', 'Logged out successfully');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function change_password(Request $request){

        $customer = authenticateCustomer($request->header('Token'));
        if($request->password == $request->c_password){
            $customer->password = Hash::make($request->password);
            $customer->save();
            $success['success'] = true;
            return $this->sendResponse($success, 'Password updated successfully.');
        }else{
            $success['success'] = true;
            return $this->sendError($success, 'Password Not Match.');
        }




    }




}