<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use App\User;
use App\Role;
use App\UserSmsCode;
use Validator;
use Auth;
use App\Http\Controllers\Controller; 
use App\Http\Requests;
use Illuminate\Http\Request;
use Config;
use Curl;
use \Firebase\JWT\JWT;
use Carbon\Carbon;
use Image;
use App\TempMobile;
use Crypt;

class ValidateMobileController extends Controller
{
	public function sendMerchantOtp(request $request){
        $data = $request->only('mobile','email');

        $validator =  Validator::make($data, ['mobile' => 'required|unique:users' , 'email' => 'unique:users']);
        $messages = $validator->messages();

        if ($messages->has('email')) {  
            $user = User::where('email','=',$data['email'])->first();

            if($user->hasRole(['merchant'])){
               return response()->json([ 'response_code' => 'ERR_UAE' , 'message' => 'User Already Exists' ],409);
            }             
        }

        if($messages->has('mobile')){ 
            $muser = User::where('mobile','=',$data['mobile'])->first();
            if($muser->hasRole(['merchant'])){
                return response()->json(['response_code' => 'ERR_MNT' , 'message' => 'Mobile Number Taken'],409);
            }              
        } 

        $previousMobile = TempMobile::where('mobile',$data['mobile'])->first();
        if($previousMobile != ''){
            $previousMobile->delete();
        }
        
        $otp = rand(1000, 9999);
        $sms = Curl::to('https://control.msg91.com/api/sendhttp.php?authkey=101670ALSycXxv0ZZX56920dcd&mobiles='.$data['mobile'].'&message=Your%20Kaching%20OTP%20is%20'.$otp.'.%20Start%20dealing!&sender=KACHIN&route=4')
        ->get();
         
        $mobile = [ 'mobile' => $data['mobile'] ];
        $tempMobile = TempMobile::create($mobile);

        $smsDb = ['mobile_id' => $tempMobile->id , 'code' => $otp , 'reference_id' => $sms];
        UserSmsCode::create($smsDb);

        $encrypted = Crypt::encrypt($tempMobile->id);

        return response()->json(['response_code' => 'RES_OS' , 'messages' => 'OTP Sent' , 'data' => $encrypted ]);
    }

    public function sendCustomerOtp(request $request){
        $data = $request->only('mobile','email');

        $validator =  Validator::make($data, ['mobile' => 'required|unique:users' , 'email' => 'unique:users']);
        $messages = $validator->messages();

        if ($messages->has('email')) {  
            $user = User::where('email','=',$data['email'])->first();

            if($user->hasRole(['customer'])){
               return response()->json([ 'response_code' => 'ERR_UAE' , 'message' => 'User Already Exists' ],409);
            }             
        }

        if($messages->has('mobile')){ 
            $muser = User::where('mobile','=',$data['mobile'])->first();
            if($muser->hasRole(['customer'])){
                return response()->json(['response_code' => 'ERR_MNT' , 'message' => 'Mobile Number Taken'],409);
            }            
        } 

        $previousMobile = TempMobile::where('mobile',$data['mobile'])->first();
        if($previousMobile != ''){
            $previousMobile->delete();
        }
        
        $otp = rand(1000, 9999);
        $sms = Curl::to('https://control.msg91.com/api/sendhttp.php?authkey=101670ALSycXxv0ZZX56920dcd&mobiles='.$data['mobile'].'&message=Your%20Kaching%20OTP%20is%20'.$otp.'.%20Start%20dealing!&sender=KACHIN&route=4')
        ->get();
         
        $mobile = [ 'mobile' => $data['mobile'] ];
        $tempMobile = TempMobile::create($mobile);

        $smsDb = ['mobile_id' => $tempMobile->id , 'code' => $otp , 'reference_id' => $sms];
        UserSmsCode::create($smsDb);

        $encrypted = Crypt::encrypt($tempMobile->id);

        return response()->json(['response_code' => 'RES_OS' , 'messages' => 'OTP Sent' , 'data' => $encrypted ]);
    }

    public function validateOtp(request $request){
        $input = $request->only('otp','mobile_key'); 

        $validator =  Validator::make($input, ['mobile_key' => 'required' , 'otp' => 'required']);
        if($validator->fails()){
            return response()->json([ 'response_code' => 'ERR_RULES' ,'message' => $validator->errors()->all()],400);  
        }

        $mobile_id = Crypt::decrypt($input['mobile_key']); 
 
        $matchThese = ['mobile_id' => $mobile_id , 'code' => $input['otp'] ];


        $sms = UserSmsCode::where($matchThese)->first();

        if($sms == '' || empty($sms)){
            return response()->json(['response_code' => 'RES_IOG' , 'messages' => 'Invalid OTP Given'],422);
        }
        $sms->status = true;
        $sms->save();


        $mobile = TempMobile::where('id',$mobile_id)->first();

        $mobile->status = true;
        $mobile->save();
 
        return response()->json(['response_code' => 'RES_MV' , 'messages' => 'Mobile Verified']);
    }

     
    
}