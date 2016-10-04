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
use App\Areas;
use App\States;
use App\Countries;
use App\TempMobile;
use App\UserSmsCode;
use App\PasswordOtpReset;
use App\AppElement;
use Hash;
use App\MerchantStoreAddress;
use Image;
use Input;
use Auth;
use Session;
use Curl;
use Crypt;

class MerchantController extends Controller
{
	public function __construct()
	{
		$is_super = Auth::User()->Stores->is_parent;
		if($is_super){
			$matchThese = [ 'is_child' => true , 'parent_id' => Auth::User()->Stores->id];
			$stores = MerchantStore::with('Address','OffersCount')->where($matchThese)->get();
			foreach ($stores as $key => $store) {
				$linked[$key]['store_id']   = Crypt::encrypt($store->id);
				$linked[$key]['store_name'] = $store->store_name;
				$linked[$key]['store_area'] = $store->Address->Area->title;
				$linked[$key]['store_city'] = $store->Address->City->title;
				if(!empty($store->OffersCount->first())){
					$linked[$key]['offers_count'] = $store->OffersCount->first()->count;
				}
				else{
					$linked[$key]['offers_count'] = 0;
				}

			}
		}
		else{
			$linked = '';
		}

		$output = ['is_super' => $is_super , 'linked' => $linked];
		view()->share($output);
		$this->middleware('auth');
	}

	protected function checkIfStoreIsParent($store_id){
    	$store = Auth::user()->stores;
    	if($store->is_parent && ($store_id == $store->id)){
    		return true;
    	}
    	return false;
    }

    protected function checkUserHasStorePermission($store_id){
    	$store = Auth::user()->stores;
    	if($store_id == $store->id){
    		return true;
    	}

    	$matchThese = ['id' => $store_id , 'parent_id' => $store->id , 'is_child' => true];
    	$merchant  = MerchantStore::where($matchThese)->first();

		if(empty($merchant) || $merchant == ''){
			return false;
		}
		
		return true;
    }

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
	public function getLinkedStoreOffers(request $request){
		$rules = array(
			'id' => 'required',
		);
		$validator =  Validator::make($request->all(), $rules );
        if($validator->fails()){
            return redirect('/merchant/dashboard');  
        }

		$store_id = Crypt::decrypt($request->input('id'));
		if (!$this->checkUserHasStorePermission($store_id)) {
			 return redirect('/merchant/dashboard');  
		}

		$offers = Offers::with('Store','votesCount')
		              ->where('store_id',$store_id)
			          ->orderby('created_at','desc')
			          ->paginate(15);

		$output = ['offers'=>$offers];

		//return $output;
		return view('merchant.dashboard',$output);
	}


	public function getDashboard(){
		$user_id = Auth::user()->id;
		$store = MerchantStore::where('user_id',$user_id)->first();

		if($store == '' || empty($store)){
			return redirect('merchant/add/store');
		}

		$offers = Offers::with('Store','votesCount')
		              ->where('store_id',$store->id)
			          ->orderby('created_at','desc')
			          ->paginate(15);
	    
	    
	    $output = ['offers'=>$offers];

		//return $output;
		return view('merchant.dashboard',$output);
	}

	public function getAllStoresOffers(){
		if(!Auth::User()->Stores->is_parent){
			return redirect('/merchant/dashboard');
		}
		$matchThese = [ 'status' => true ,'is_child' => true , 'parent_id' => Auth::User()->Stores->id];
		$stores = MerchantStore::where($matchThese)->get();
		$storesArr = [];
		foreach ($stores as $key => $store) {
			$storesArr[$key] = $store->id;
		}
		$offers = Offers::with('Store','votesCount')
		              ->whereIn('store_id',$storesArr)
			          ->orderby('created_at','desc')
			          ->paginate(15);

	    $output = ['offers'=>$offers];
		//return $output;
		return view('merchant.dashboard',$output);
	}

	public function getAbout(){
		$AppElement = AppElement::find(1);
		$output['about'] = $AppElement->mabout;
		return view('merchant.about',$output);
	}

	public function getService(request $request){
		$AppElement = AppElement::find(1);
		$output['support'] = $AppElement->msupport;
		return view('merchant.support',$output);
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
		$is_parent = false;

		$fineprintArr  = explode("\n",$request->input('fineprint'));
		$fineprint = '';
		foreach ($fineprintArr as $value) {
			if($value != '' || !empty($value)){
				$fineprint .= '<li>'.$value.'</li>'; 
			}
		}

		if($request->has('store_token')){
			if($request->input('store_token') == 'all' && Auth::user()->Stores->is_parent){
				$store_id = Auth::user()->Stores->id; 
				$is_parent = true;
 			}
 			else if($request->input('store_token') == 'all'){
 				return response()->json(['status'=>'fail' ,'message' =>  'Not Authorized']);
 			}
 			else{
 				$storeId = Crypt::decrypt($request->input('store_token'));
 				if (!$this->checkUserHasStorePermission($storeId)) {
					return response()->json(['status'=>'fail' ,'message' =>  'Not Authorized']);
				}
 				$store_id = $storeId;
 			}

		}
		else{
			$store_id = Auth::user()->Stores->id; 
		}


		$offerInput = $request->only('title','startDate','endDate');
		$offerInput['store_id'] = $store_id;
		$offerInput['fineprint'] = $fineprint;

		$offer = Offers::create($offerInput);

		if($is_parent){
		    $offer->is_parent = true;
		    $offer->save(); 
			//creating offer for all sub merchants if user selects and if he is super merchant 

			$matchThese = [ 'is_child' => true , 'parent_id' => $store_id];
			$stores = MerchantStore::where($matchThese)->get();
			$offerInp = $request->only('title','fineprint','startDate','endDate');
			$offerInp['is_child'] = true;
			$offerInp['parent_id'] = $offer->id;
			foreach ($stores as $store) {
				$offerInp['store_id'] = $store->id;
				Offers::create($offerInp);
			}
		}
		
		
		return response()->json(['status'=>'success']);
	}

	public function disableOffer(request $request){
		$validator =  Validator::make($request->all(), [
            'offer_id' => 'required'
        ]);

        if($validator->fails()){
			 return  'fail';
		}

		$matchThese = ['id' => $request->input('offer_id') , 'is_child' => false ];

		$offer = Offers::where($matchThese)->first();
		if ($offer == '' || empty($offer)) {
			return 'fail';
		}

		if (!$this->checkUserHasStorePermission($offer->store_id)) { // checking if offer can be editable by logged in store
			return response()->json(['status'=>'fail' ,'message' =>  'Not Authorized']);
		}

		if($offer->status){
			$statusInp = false;
			$offer->status = false;
			$status = 'disabled';
		}
		else{
			$statusInp = true;
			$offer->status = true;
			$status = 'enabled';
		}

		$offer->save();

		if($offer->is_parent && $this->checkIfStoreIsParent($offer->store_id)){ 
			$matchThese = ['is_child' => true , 'parent_id' => $offer->id];
			Offers::where($matchThese)->update(['status'=> $statusInp]);
		}

		return $status;

	}

	public function editOffer(request $request){
		$validator =  Validator::make($request->all(), [
            'offer_id' => 'required',
            'title' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
            'fineprint' => 'required',
        ]);

        if($validator->fails()){
			 return response()->json(['status'=>'fail' ,'message' =>  $validator->errors()->all()]);
		}

		$matchThese = ['id' => $request->input('offer_id') , 'is_child' => false];  // child offers are not editable by child merchants
		$offer = Offers::where($matchThese)->first();
        
		if(empty($offer)){
			return response()->json(['status'=>'fail' ,'message' => 'Not Authorized']);
		}

		if (!$this->checkUserHasStorePermission($offer->store_id)) { // checking if offer can be editable by logged in store
			return response()->json(['status'=>'fail' ,'message' =>  'Not Authorized']);
		}

		$fineprintArr  = explode("\n",$request->input('fineprint'));
		$fineprint = '';
		foreach ($fineprintArr as $value) {
			if($value != '' || !empty($value)){
				$fineprint .= '<li>'.$value.'</li>'; 
			}
		}

		$updateValues = $request->only('title','startDate','endDate');
		$updateValues['fineprint'] = $fineprint;

		foreach ($updateValues as $key => $value) {
			$offer->$key = $value;
		}

		$offer->save();

		
        // if offer is parent and store editing this also parent update all child offers
		if($offer->is_parent && $this->checkIfStoreIsParent($offer->store_id)){ 
			$matchThese = ['is_child' => true , 'parent_id' => $offer->id];
			Offers::where($matchThese)->update($updateValues);
		}

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
		$areas = Areas::all();
		$states = States::all();
		$countries = Countries::all();

		$output = ['store' => $store, 'tags' => $tags, 'areas' => $areas, 'cities'=> $cities , 'states' => $states , 'countries' => $countries];
		return view('merchant.storeEdit',$output);

	}

	public function editStore(request $request){
		$validator = Validator::make($request->all(), [
            'store_name' => 'required|max:255',
            'landline' => 'required',
            'cost_two' => 'required',
            'veg' => 'required',
            'status' => 'required',
            'street' => 'required|max:200',
            'area_id' => 'required',
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
		foreach ($request->only('store_name','veg','cost_two','landline','status','description') as $key => $value) {
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

		foreach ($request->only('street','area_id','city_id','state_id','country_id','pincode','latitude','longitude') as $key => $value) {
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