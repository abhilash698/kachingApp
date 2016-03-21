<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Tag;
use App\User;
use App\Offers;
use App\UserSmsCode;
use Curl;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\MerchantStore;
use App\MerchantStoreAddress;
use Validator;
use Auth;
use Image;
use App\TempMobile;
use Hash;
use Crypt;
use App\AppElement;

class MerchantService extends Controller {

	protected function customValidator(array $data, array $rules, array $messages)
    {
        return Validator::make($data,$rules,$messages);  // muqf mobile unique fail
    }

    protected function checkUserHasStore($store_id,$checkStatus){
    	$hasStore = false;
    	$storeId = Auth::user()->stores->id;
		if($store_id == $storeId){
			$hasStore = true;
		}
		

		if($checkStatus){
			$store = MerchantStore::where('id',$store_id)->first();
			if(!$store->status){
				$hasStore = false;
			}
		}		
		
		return $hasStore;
    }

	public function getTags(){
		return response()->json(['response_code' => 'RES_TAGS' , 'messages' => 'Tags' , 'data' => Tag::get()]);
	}

	/*public function validateOtp(Request $request){
    	$user_id = Auth::user()->id;
    	$input = $request->only('otp');

    	$matchThese = ['user_id' => $user_id , 'code' => $input['otp'] ];
    	$sms = UserSmsCode::where($matchThese)->first();

    	if($sms == '' || empty($sms)){
    		return response()->json(['response_code' => 'RES_IOG' , 'messages' => 'Invalid OTP Given'],422);
    	}

    	$sms->status = true;
    	$sms->save();

    	$user = User::where('id',$user_id)->first();
    	$user->is_mobile_verified = true;
    	$user->save();

    	return response()->json(['response_code' => 'RES_MV' , 'messages' => 'Mobile Verified']);
    }


    public function resendOtp(){
    	$user_id = Auth::user()->id;
    	$user= User::where('id',$user_id)->first();
    	
    	$previousSms = UserSmsCode::where('user_id',$user_id)->first();
    	if($previousSms != ''){
            $previousSms->delete();
        }

    	$otp = rand(100000, 999999);
        $sms = Curl::to('https://control.msg91.com/api/sendhttp.php?authkey=101670ALSycXxv0ZZX56920dcd&mobiles='.$user->mobile.',8801709993&message=Kaching%20Mobile%20Verification%20Code%20'.$otp.'&sender=777777&route=1')
        ->get();
         

        $smsDb = ['user_id' => $user->id , 'code' => $otp , 'reference_id' => $sms];
        UserSmsCode::create($smsDb);
        return response()->json(['response_code' => 'RES_OS' , 'messages' => 'OTP Sent']);
    }*/

    public function sendOtpToUpdatedMobile($user_id,$mobile){ 
    	$previousMobile = TempMobile::where('mobile',$mobile)->first();
        if($previousMobile != ''){
            $previousMobile->delete();
        }

        $otp = rand(1000, 9999);
        $sms = Curl::to('https://control.msg91.com/api/sendhttp.php?authkey=101670ALSycXxv0ZZX56920dcd&mobiles='.$mobile.'&message=Your%20Kaching%20OTP%20is%20'.$otp.'.%20Start%20dealing!&sender=KACHIN&route=4')
        ->get();
         
        $mobile = [ 'mobile' => $mobile ];
        $tempMobile = TempMobile::create($mobile);

        $smsDb = ['mobile_id' => $tempMobile->id , 'code' => $otp , 'reference_id' => $sms];
        UserSmsCode::create($smsDb);

        $encrypted = Crypt::encrypt($tempMobile->id);

        return response()->json(['response_code' => 'RES_OS' , 'messages' => 'OTP Sent' , 'data' => $encrypted ]);
    }

    public function validateUpdatedMobileOtp(Request $request){
    	$user_id = Auth::user()->id;
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

        $tempMobile = TempMobile::where('id',$mobile_id)->first();
    	$user = User::where('id',$user_id)->first();

        $user->mobile = $tempMobile->mobile; 
    	$user->save();

    	$tempMobile->status = true;
    	$tempMobile->save();

    	return response()->json(['response_code' => 'RES_MV' , 'messages' => 'Mobile Verified' ,'data' => $tempMobile->mobile ]);
    }

	public function postStore(request $request){
		
		$rules = array(
			'store_name' => 'required|min:2|max:60', 
			'description' => 'required|min:10',
			'tags' => 'required',
			'cost_two' => 'required',
			'veg' => 'required',
			'landline' => 'required', 
			);
		$Validator = $this->customValidator($request->all(), $rules, array());
		
		if($Validator->fails()){
			return response()->json([ 'response_code' => 'ERR_RULES' , 'messages' => $Validator->errors()->all() ],400);
		}

		
		$storeInput = $request->only('store_name','description','cost_two','landline','veg');
		$storeInput['user_id'] = Auth::id();

		$tags = $request->only('tags');
		$tagStore = explode(',', $tags['tags']);
		$store = MerchantStore::create($storeInput);
		
		if($request->hasFile('logo'))
		{
			$image = $request->file('logo');
	        $imageName = strtotime(Carbon::now()).md5($store->id).'.'. $image->getClientOriginalExtension();
	        $path = public_path('assets/img/stores/'.$imageName);
	        Image::make($image->getRealPath())->resize(280, null, function ($constraint) {
														    $constraint->aspectRatio();
														})->save($path);
	        $store->logoUrl = $imageName;
	    }

        
        $store->status = true;  //commet it when required
		$store->save();
		$store->tags()->attach($tagStore);

		return response()->json(['response_code' => 'RES_SC' , 'messages' => 'Store Created' ,'data' =>$store ],201);
	}

	public function editStore(request $request){
		 
		$store_id = $request->only('store_id'); 
		if(!$this->checkUserHasStore($store_id['store_id'],false)){
			return response()->json(['response_code' => 'ERR_UNA' ,'messages' => 'User Not Authorized'],403);
		}

		$store = MerchantStore::find($store_id['store_id']);
		foreach ($request->only('store_name','description','cost_two','status','landline','veg') as $key => $value) {
			$store->$key = $value;
		}

		if($request->hasFile('logo'))
		{
			$image = $request->file('logo');
	        $imageName = strtotime(Carbon::now()).md5($store_id['store_id']).'.'. $image->getClientOriginalExtension();
	        $path = public_path('assets/img/stores/'.$imageName);
	        Image::make($image->getRealPath())->resize(280, null, function ($constraint) {
														    $constraint->aspectRatio();
														})->save($path);
	        $store->logoUrl = $imageName;
	    }

		$store->save();

		$store->tags()->detach();
		$tags = $request->only('tags');
		$tagStore = explode(',', $tags['tags']);
		$store->tags()->attach($tagStore);

		$matchThese = ['store_id' => $store_id['store_id']];
		$address = MerchantStoreAddress::where($matchThese)->first();

		foreach ($request->only('street','city_id','state_id','country_id','pincode','latitude','longitude') as $key => $value) {
			$address->$key = $value;
		}
		$address->save();

		$output = ['store' => $store , 'address' => $address];

		return response()->json(['response_code' => 'RES_SU' , 'messages' => 'Store Upadated','data' => $output ]);

	}

	public function editStoreAddress(request $request){
		$input = $request->only('store_id','address_id');
		if(!$this->checkUserHasStore($input['store_id'],false)){
			return response()->json(['response_code' => 'ERR_UNA' ,'messages' => 'User Not Authorized'],403);
		}

		$matchThese = ['id' => $input['address_id'] , 'store_id' => $input['store_id']];
		$address = MerchantStoreAddress::where($matchThese)->first();

		foreach ($request->except('store_id','address_id','api_key') as $key => $value) {
			$address->$key = $value;
		}
		$address->save();

		return response()->json(['response_code' => 'RES_SAU' , 'messages' => 'Store Address Upadated' , 'data' => $address ]);
	}

	public function addStoreAddress(request $request){
		$rules = array(
			'store_id' => 'required',
			'street' => 'required',
			'city_id' => 'required',
			'state_id' => 'required',
			'country_id' => 'required',
			'pincode' => 'required|size:6',
			'latitude' => 'required',
			'longitude' =>'required',
			);

		$Validator = $this->customValidator($request->all(), $rules, array());
		
		if($Validator->fails()){
			return response()->json(['response_code' => 'ERR_RULES' , 'messages' => $Validator->errors()->all() ],400);
		}


		$store_id = $request->only('store_id'); 

		if(!$this->checkUserHasStore($store_id['store_id'],false)){
			return response()->json(['response_code' => 'ERR_UNA' ,'messages' => 'User Not Authorized'],403);
		}

		$store = MerchantStore::find($store_id['store_id']);
		$store->address()->create($request->only('street','city_id','state_id','country_id','pincode','latitude','longitude'));

		return response()->json(['response_code' => 'RES_SAC' , 'messages' => 'Store Address Created' , 'data' => $store->address ],201);

	}

	public function editOffer(request $request){
		$input = $request->only('store_id','offer_id'); 

		if(!$this->checkUserHasStore($input['store_id'],true)){
			return response()->json(['response_code' => 'ERR_UNA' ,'messages' => 'User Not Authorized'],403);
		}

		$matchThese = ['id' => $input['offer_id'] , 'store_id' => $input['store_id']];
		$offer = Offers::where($matchThese)->first();

		if(empty($offer)){
			return response()->json(['response_code' => 'RES_OU' , 'messages' => 'Offer Updated']);
		}
		foreach ($request->except('offer_id','store_id','api_key') as $key => $value) {
			$offer->$key = $value;
		}

		$offer->save();

		return response()->json(['response_code' => 'RES_OU' , 'messages' => 'Offer Updated']);

	}


	public function addOffer(request $request){

		$rules = array(
			'store_id' => 'required',
			'title' => 'required',
			'fineprint' => 'required',
			'startDate' => 'required',
			'endDate' => 'required',
			);

		$Validator = $this->customValidator($request->all(), $rules, array());
		
		if($Validator->fails()){
			return response()->json(['response_code' => 'ERR_RULES' , 'messages' => $Validator->errors()->all() ],400);
		}

		$store_id = $request->only('store_id'); 

		if(!$this->checkUserHasStore($store_id['store_id'],true)){
			return response()->json(['response_code' => 'ERR_UNA' ,'messages' => 'User Not Authorized'],403);
		}

		$offer = Offers::create($request->only('store_id','title','fineprint','startDate','endDate'));
		
		return response()->json(['response_code' => 'RES_SOC' , 'messages' => 'Store Offer Created','data' =>$offer],201);

	}

	public function getStoreOffers(request $request){
		$rules = array(
			'store_id' => 'required',
			);

		$Validator = $this->customValidator($request->all(), $rules, array());


		if($Validator->fails()){
			return response()->json(['response_code' => 'ERR_RULES' , 'messages' => $Validator->errors()->all() ],400);
		}

		$store_id = $request->only('store_id'); 

		if(!$this->checkUserHasStore($store_id['store_id'],false)){
			return response()->json(['response_code' => 'ERR_UNA' ,'messages' => 'User Not Authorized'],403);
		}
		 

		return response()->json(['response_code' => 'RES_OFF' , 'messages' => 'Offers' , 'data' => Offers::with('votesCount','favouriteCount')->where('store_id',$store_id)->get()]);
	}

	public function getStoreDetails(request $request){
		$user_id = Auth::user()->id;
		$store = MerchantStore::with('Merchant','Address','Tags')->where('user_id',$user_id)->first();
		$user = User::where('id','=',$user_id)->first();
		
		if($store == '' || empty($store)){
			return response()->json(['response_code' => 'RES_SE' , 'messages' => 'Store Empty','data' => [ 'user' => $user] ]);
		}
		 
		return response()->json(['response_code' => 'RES_SD' , 'messages' => 'Store Details' , 'data' => ['store' => $store , 'user' => $user ] ]);
	}

	public function editProfile(request $request){
		 $rules = array( 
            'email' => 'required|email|max:255',
            'name' => 'required|max:30',
            );

        $validator = $this->customValidator($request->all(),$rules,array());
        if ($validator->fails()) {
            return response()->json([ 'response_code' => 'ERR_RULES' ,'message' => $validator->errors()->all()],400);          
        }

		$user_id = Auth::user()->id;
		$user = User::find($user_id);
		$input = $request->only('name','email','mobile');

		if($input['email'] != $user->email){
			$rules = array(
	        'email' => 'unique:users'
	        );
 
	        $validator = $this->customValidator($input,$rules,array());

	        if($validator->fails()){
	        	return response()->json([ 'response_code' => 'ERR_ET' , 'message' => 'Email Taken' ],409);
	        }
	        $user->email = $input['email'];
		}
		
		
		
		$user->name = $input['name'];
		$user->save();
		return response()->json(['response_code' => 'RES_VM' , 'message' => 'Profile Updated' , 'data' => ['email' => $user->email , 'name' => $user->name ]]);

	}
	public function editMobile(request $request){
		$rules = array(
            'mobile' => 'required|size:10');
		$validator = $this->customValidator($request->all(),$rules,array());
        if ($validator->fails()) {
            return response()->json([ 'response_code' => 'ERR_RULES' ,'message' => $validator->errors()->all()],400);          
        }

        $user_id = Auth::user()->id;
		$user = User::find($user_id);
		$input = $request->only('mobile');

        if ($input['mobile'] != $user->mobile) {
			$rules = array(
	        'mobile' => 'unique:users'
	        );
 
	        $validator = $this->customValidator($input,$rules,array());

	        if($validator->fails()){
	        	return response()->json([ 'response_code' => 'ERR_MT' , 'message' => 'Mobile Taken' ],409);
	        }
	        return $this->sendOtpToUpdatedMobile($user->id , $input['mobile']); 
		}

		return response()->json(['response_code' => 'RES_MNC' ,'message' => 'Mobile Not Changed']);
	}

	public function changePassword(request $request){
		$rules = array(
        	'new' => 'required|min:6',
        	'old' => 'required'
        );

        $validator = $this->customValidator($request->all(),$rules,array());

        if($validator->fails()){
        	return response()->json([ 'response_code' => 'ERR_RULES' ,'message' => $validator->errors()->all()],400);  
        }

		$input  = $request->only('old','new');
		if (!Hash::check($input['old'], Auth::user()->password)) {
		    return response()->json(['response_code' => 'ERR_IP' ,'message' => 'Invalid password'],409);
		}

		$id = Auth::user()->id;
		$user = User::find($id);
		$user->password = bcrypt($input['new']);
        $user->save();

        return response()->json(['response_code' => 'RES_PC' , 'message' => 'Password Changed']);
	}


}