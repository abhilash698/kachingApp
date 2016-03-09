<?php
namespace App\Http\Controllers\Merchant;

use Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\MerchantStore;
use Carbon\Carbon;
use App\Offers;
use App\Role;
use App\Tag;
use App\Cities;
use App\States;
use App\Countries;
use App\TempMobile;
use App\UserSmsCode;
use App\PasswordOtpReset;
use Hash;
use App\MerchantStoreAddress;
use Image;
use Input;
use Auth;
use Session;
use Curl;

class MerchantController extends Controller
{
	protected function customValidator(array $data, array $rules, array $messages)
    {
        return Validator::make($data,$rules,$messages);  // muqf mobile unique fail
    }

    public function getForgotMobile(){
    	return view('merchant.forgotMobile');
    }

    public function getChangePassword(){
    	return view('merchant.changePassword');
    }

    public function getChangeSuccess(){
    	return view('merchant.ChangeSuccess');
    }

    public function postForgotMobile(request $request){
        $input = $request->only('mobile'); 

        $validator =  Validator::make($input, ['mobile' => 'required']);
        if($validator->fails()){
            return redirect('/merchant/store/edit')
                        ->withErrors($validator);   
        }

        $user = User::where('mobile',$input['mobile'])->first();
        if(empty($user) || $user == ''){
        	return redirect('/merchant/forgot/mobile')
                        ->with('message','Mobile Number Not Registered');  
        }

        if(!$user->hasRole('merchant')){
        	return redirect('/merchant/forgot/mobile')
                        ->with('message','Mobile Number Not Registered');  
        }

        $token = bin2hex(random_bytes(40));

        $otp = rand(100000, 999999);
        $sms = Curl::to('https://control.msg91.com/api/sendhttp.php?authkey=101670ALSycXxv0ZZX56920dcd&mobiles='.$input['mobile'].'&message=Your%20Kaching%20OTP%20is%20'.$otp.'.%20Start%20dealing!&sender=KACHIN&route=4')
        ->get();

        PasswordOtpReset::create(['user_id' => $user->id , 'token' => $token , 'code' => $otp]);

        $output = ['mobile_token' => $token];

    	return view('merchant.forgotOtp',$output);
    }

    public function postForgotOtp(request $request){
    	$input = $request->only('otp','mobile_token'); 

        $validator =  Validator::make($input, ['mobile_token' => 'required' , 'otp' => 'required']);
        if($validator->fails()){
            return redirect('/merchant/forgot/otp')
                        ->with('message','Mobile Number Not Registered');  
        }

        $matchThese = ['token' => $input['mobile_token'] , 'code' => $input['otp']];

        $check = PasswordOtpReset::where($matchThese)->first();
        if(empty($check) || $check == ''){
            return redirect('/merchant/forgot/otp')
                        ->with('message','Invalid Otp');
        }

        $check->is_verified = true;
        $check->save();
        $output = ['mobile_token' => $input['mobile_token']];

    	return view('merchant.changePassword',$output);
    }

    public function postChangePassword(request $request){
    	$input = $request->only('new','mobile_token'); 

        $validator =  Validator::make($input, ['mobile_token' => 'required' , 'new' => 'required']);
        if($validator->fails()){
            return response()->json([ 'response_code' => 'ERR_RULES' ,'message' => $validator->errors()->all()],400);  
        }

        $check = PasswordOtpReset::where('token',$input['mobile_token'])->first();

        if(empty($check) || $check == '' || !$check->is_verified){
            return response()->json(['response_code' => 'RES_ITK' , 'messages' => 'Invalid Token Key'],422);
        }


        $user  = User::where('id',$check->user_id)->first();
        $user->password = bcrypt($input['new']);
        $user->save();

        $check->delete();

    	return view('merchant.changeSuccess');
    }

	public function getSingleStore($id){
		$store = MerchantStore::with(['Address','Tags','Merchant','Offers'])
		->where('id',$id)
		->first();

		$output['store'] = $store;
		return view('merchant.store',$output);
	}

	public function getDashboard(){
		$user_id = Auth::user()->id;
		$store = MerchantStore::where('user_id',$user_id)->first();

		if($store == '' || empty($store)){
			return redirect('merchant/add/store');
		}

		$offers = Offers::with('Store','favouriteCount','votesCount')
		              ->where('store_id',$store->id)
			          ->orderby('created_at','desc')
			          ->paginate(15);
	    
	    
	    $output = ['offers'=>$offers ];

		//return $output;
		return view('merchant.dashboard',$output);
	}

	public function getAddStore(){

	}

	public function addStore(request $request){

	}

	public function addOffer(request $request){
		$rules = array(
			'title' => 'required',
			'fineprint' => 'required',
			'startDate' => 'required',
			'endDate' => 'required',
			);

		$validator = $this->customValidator($request->all(), $rules, array());
		
		if($validator->fails()){
			 return response()->json(['status'=>'fail' ,'message' =>  $validator->errors()->all()]); 
		}

		$fineprintArr  = explode("\n",$request->input('fineprint'));
		$fineprint = '';
		foreach ($fineprintArr as $value) {
			if($value != '' || !empty($value)){
				$fineprint .= '<li>'.$value.'</li>'; 
			}
		}

		$store_id = Auth::user()->Stores->id; 

		$offerInput = $request->only('title','startDate','endDate');
		$offerInput['store_id'] = $store_id;
		$offerInput['fineprint'] = $fineprint;

		$offer = Offers::create($offerInput);
		
		return response()->json(['status'=>'success']);
	}

	public function disableOffer(request $request){
		$validator =  Validator::make($request->all(), [
            'offer_id' => 'required'
        ]);

        if($validator->fails()){
			 return  'fail';
		}

		$store_id = Auth::user()->Stores->id; 
		$matchThese = ['id' => $request->input('offer_id') ,'store_id' => $store_id ];

		$offer = Offers::where($matchThese)->first();
		if ($offer == '' || empty($offer)) {
			return 'fail';
		}

		if($offer->status){
			$offer->status = false;
			$status = 'disabled';
		}
		else{
			$offer->status = true;
			$status = 'enabled';
		}

		$offer->save();

		return $status;

	}

	public function editOffer(request $request){
		$validator =  Validator::make($request->all(), [
            'offer_id' => 'required',
            'title' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
            'fineprint' => 'required'
        ]);

        if($validator->fails()){
			 return response()->json(['status'=>'fail' ,'message' =>  $validator->errors()->all()]);
		}

		$store_id = Auth::user()->Stores->id; 
		$matchThese = ['id' => $request->input('offer_id') , 'store_id' => $store_id];
		$offer = Offers::where($matchThese)->first();
        
		if(empty($offer)){
			return response()->json(['status'=>'fail' ,'message' => 'Not Authorized']);
		}

		$fineprintArr  = explode("\n",$request->input('fineprint'));
		$fineprint = '';
		foreach ($fineprintArr as $value) {
			if($value != '' || !empty($value)){
				$fineprint .= '<li>'.$value.'</li>'; 
			}
		}

		foreach ($request->only('title','startDate','endDate') as $key => $value) {
			$offer->$key = $value;
		}

		$offer->fineprint = $fineprint;

		$offer->save();

		return response()->json(['status'=>'success' ,'data' => $offer ]);

	}

	public function getProfile(){
		$output = ['user' => Auth::user() ];
		return view('merchant.profile',$output);
	}

	public function getStore(){
		$store_id = Auth::user()->Stores->id;
		$store = MerchantStore::with(['Address','tags','Merchant','Offers'])
		->where('id',$store_id)
		->first();

		$output['store'] = $store;
		return view('merchant.store',$output);
	}

	public function getEditStore(){
		$store_id = Auth::user()->Stores->id;
		$store = MerchantStore::with(['Address','tags','Merchant'])
		->where('id',$store_id)
		->first();

		$tags = Tag::all();
		$cities = Cities::all();
		$states = States::all();
		$countries = Countries::all();

		$output = ['store' => $store, 'tags' => $tags, 'cities'=> $cities , 'states' => $states , 'countries' => $countries];
		return view('merchant.storeEdit',$output);

	}

	public function editStore(request $request){
		$validator = Validator::make($request->all(), [
            'store_name' => 'required|max:255',
            'description' => 'required|min:10',
            'landline' => 'required',
            'cost_two' => 'required',
            'status' => 'required',
            'street' => 'required|max:200',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'pincode' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $input = $request->only('store_id');

        if($validator->fails()){
        	return redirect('merchant/store/edit')
                        ->withErrors($validator);  
        }
        
        $store_id = Auth::user()->Stores->id;
        $store = MerchantStore::find($store_id);
		foreach ($request->only('store_name','description','cost_two','landline','status') as $key => $value) {
			$store->$key = $value;
		}

		if($request->hasFile('logo'))
		{
			$image = $request->file('logo');
	        $imageName = strtotime(Carbon::now()).md5($store_id).'.'. $image->getClientOriginalExtension();
	        $path = public_path('assets/img/stores/'.$imageName);
	        Image::make($image->getRealPath())->resize(280, null, function ($constraint) {
														    $constraint->aspectRatio();
														})->save($path);
	        $store->logoUrl = $imageName;
	    }

		$store->save();

		$store->tags()->detach();
		$store->tags()->attach([$request->input('tag_id')]);

		$matchThese = ['store_id' => $store_id];
		$address = MerchantStoreAddress::where($matchThese)->first();

		foreach ($request->only('street','city_id','state_id','country_id','pincode','latitude','longitude') as $key => $value) {
			$address->$key = $value;
		}
		$address->save();

		return redirect('merchant/store');

	}

	public function getUserEdit(){
		$user  = Auth::user();
		$roles = Role::all();
	    $output = array('user' => $user,'roles'=>$roles);
	    return view('merchant.userEdit',$output);
	}

	public function editUser(request $request){
		//return $request->only('tags');
		$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255'
        ]);

        if($validator->fails()){
        	return redirect('merchant/profile/edit')
                        ->withErrors($validator);  
        }

        $user = Auth::user();

        if($user->email != $request->input('email')){
        	$rules = array(
	        'email' => 'unique:users',
	        );
	        $validator = $this->customValidator($request->only('email'),$rules,array());
	        if($validator->fails()){
	        	return redirect('merchant/profile/edit')
	                        ->withErrors($validator);  
	        }

        }

        foreach ($request->only(['name','email']) as $key => $value) {
        	$user->$key = $value;
        }
        $user->save();

        return redirect('merchant/profile/edit')->with('status', 'Profile Updated!');
	}

	public function changePassword(request $request){
		$rules = array(
        	'new' => 'required|min:6',
        	'old' => 'required'
        );

        $validator = $this->customValidator($request->all(),$rules,array());

        if($validator->fails()){
        	return redirect('merchant/profile/edit')
	                        ->withErrors($validator); 
        }

		$input  = $request->only('old','new');
		if (!Hash::check($input['old'], Auth::user()->password)) {
		    return redirect('merchant/profile/edit')->with('status1', 'Invalid Password');; 
		}

		$id = Auth::user()->id;
		$user = User::find($id);
		$user->password = bcrypt($input['new']);
        $user->save();

        return redirect('merchant/profile/edit')->with('status1', 'Password Changed!'); 
	}

	public function sendOtp(request $request){ 

		$user = Auth::user();
		if ($request->input('mobile') == $user->mobile) {
	        return response()->json([ 'response_code' => 'FAIL' , 'message' => 'Please Enter New Mobile Number' ]); 
		}

		$rules = array(
        'mobile' => 'unique:users'
        );

        $validator = $this->customValidator($request->all(),$rules,array());

        if($validator->fails()){
        	return response()->json([ 'response_code' => 'FAIL' , 'message' => 'Mobile Taken' ]);
        }

    	$previousMobile = TempMobile::where('mobile',$request->input('mobile'))->first();
        if($previousMobile != ''){
            $previousMobile->delete();
        }

        $otp = rand(100000, 999999);
        $sms = Curl::to('https://control.msg91.com/api/sendhttp.php?authkey=101670ALSycXxv0ZZX56920dcd&mobiles='.$request->input('mobile').'&message=Your%20Kaching%20OTP%20is%20'.$otp.'.%20Start%20dealing!&sender=KACHIN&route=4')
        ->get();
         
        $mobile = [ 'mobile' => $request->input('mobile') ];
        $tempMobile = TempMobile::create($mobile);

        $smsDb = ['mobile_id' => $tempMobile->id , 'code' => $otp , 'reference_id' => $sms];
        $smsObj = UserSmsCode::create($smsDb);

        Session::set('smsId', $smsObj->id);

        return response()->json(['response_code' => 'PASS' , 'message' => 'OTP Sent', 'dataValue'=> Session::get('smsId')]);
    }

    public function validateOtp(Request $request){
    	$input = $request->only('otp'); 

        $validator =  Validator::make($input, ['otp' => 'required']);
        if($validator->fails()){
            return response()->json([ 'response_code' => 'FAIL' ,'message' => 'Enter OTP']);  
        }

        $sms_id = Session::get('smsId'); 
 
        $matchThese = ['id' => $sms_id , 'code' => $request->input('otp') ];
        $sms = UserSmsCode::where($matchThese)->first();

    	if($sms == '' || empty($sms)){
    		return response()->json(['response_code' => 'FAIL' , 'message' => 'Invalid OTP Given']);
    	}

    	$sms->status = true;
    	$sms->save();

        $tempMobile = TempMobile::where('id',$sms->mobile_id)->first();
    	
    	$user = Auth::user();
        $user->mobile = $tempMobile->mobile; 
    	$user->save();

    	$tempMobile->status = true;
    	$tempMobile->save();

    	return response()->json(['response_code' => 'PASS' , 'message' => 'Mobile Updated' ,'dataValue' => $user->mobile ]);
    }


}