<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Curl;
use Session;
use \Firebase\JWT\JWT;
use Config;
use App\User;

class Test extends Controller {
	public function test(request $request) {
		$token = $request->only('token');
		$response = Curl::to('https://graph.facebook.com/v2.5/me?access_token='.$token['token'].'&fields=id,name,email')
        ->asJson()
        ->get();

		return $response->email;
	}

	public function postTest(Request $request){
		$key = Config::get('custom.JWTkey');
		$userinputs = $request->only('id');
		$decoded = JWT::decode($userinputs['id'], $key, array('HS256'));

		//print_r($decoded);
		print_r($decoded);
	}

	public function makeSuperAdmin(){
		$user  = User::where('email','admin@kaching.com')->first();
		$user->status = true;
		$user->save();
		
		$user->roles()->sync([1,2,3,4]);

		return $user->name.' is added as super admin';
	}

	public function makeCurlSms(){
		$sms = Curl::to('https://control.msg91.com/api/sendhttp.php?authkey=101670ALSycXxv0ZZX56920dcd&mobiles=12345678910&message=Hi%20test%20message&sender=Kaching&route=1')
        ->get();

        return $sms;
	}
}