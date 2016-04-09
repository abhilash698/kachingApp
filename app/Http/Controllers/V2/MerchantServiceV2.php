<?php
namespace App\Http\Controllers\V2;

use App\Http\Controllers\MerchantService;

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

class MerchantServiceV2 extends MerchantService {
	public function getStoreDetails(request $request){
		$user_id = Auth::user()->id;
		$storeMain = MerchantStore::with('Merchant','Address','Tags')->where('user_id',$user_id)->first();
		$user = User::where('id','=',$user_id)->first();

		
		if($storeMain == '' || empty($storeMain)){
			return response()->json(['response_code' => 'RES_SE' , 'messages' => 'Store Empty','data' => [ 'user' => $user] ]);
		}

		if($storeMain->is_parent){
			$linked = [];
			$matchThese = [ 'is_child' => true , 'parent_id' => $storeMain->id];
			$stores = MerchantStore::with('Address','OffersCount')->where($matchThese)->get();
			foreach ($stores as $key => $store) {
				$linked[$key]['store_token']   = Crypt::encrypt($store->id);
				$linked[$key]['store_name'] = $store->store_name;
				$linked[$key]['store_area'] = $store->Address->Area->title;
				$linked[$key]['store_city'] = $store->Address->City->title;
				$linked[$key]['offers_count'] = $store->OffersCount->first()->count;

			}
		}
		else{
			$linked = '';
		}
		 
		return response()->json(['response_code' => 'RES_SD' , 'messages' => 'Store Details' , 'data' => ['store' => $storeMain , 'user' => $user , 'linked' => $linked , 'is_parent' => $storeMain->is_parent ] ]);
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

    protected function checkIfStoreIsParent($store_id){
    	$store = Auth::user()->stores;
    	if($store->is_parent && ($store_id == $store->id)){
    		return true;
    	}
    	return false;
    }

    public function postStore(request $request){
		
		$rules = array(
			'store_name' => 'required|min:2|max:60', 
			'tags' => 'required',
			'cost_two' => 'required',
			'landline' => 'required', 
			'veg' => 'required',
			);
		$Validator = $this->customValidator($request->all(), $rules, array());
		
		if($Validator->fails()){
			return response()->json([ 'response_code' => 'ERR_RULES' , 'messages' => $Validator->errors()->all() ],400);
		}

		
		$storeInput = $request->only('store_name','cost_two','landline','veg');
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

    public function addStoreAddress(request $request){
		$rules = array(
			'street' => 'required',
			'city_id' => 'required',
			'area_id' => 'required',
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


		$store_id = Auth::user()->stores->id;

		$store = MerchantStore::find($store_id);
		$store->address()->create($request->only('street','area_id','city_id','state_id','country_id','pincode','latitude','longitude'));

		return response()->json(['response_code' => 'RES_SAC' , 'messages' => 'Store Address Created' , 'data' => $store->address ],201);

	}

    public function editStore(request $request){
		 
		$store_id = Auth::user()->stores->id;

		$store = MerchantStore::find($store_id);
		foreach ($request->only('store_name','cost_two','status','landline','veg') as $key => $value) {
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
		$tags = $request->only('tags');
		$tagStore = explode(',', $tags['tags']);
		$store->tags()->attach($tagStore);

		$matchThese = ['store_id' => $store_id];
		$address = MerchantStoreAddress::where($matchThese)->first();

		foreach ($request->only('street','area_id','city_id','state_id','country_id','pincode','latitude','longitude') as $key => $value) {
			$address->$key = $value;
		}
		$address->save();

		$output = ['store' => $store , 'address' => $address];

		return response()->json(['response_code' => 'RES_SU' , 'messages' => 'Store Upadated','data' => $output ]);

	}

	public function disableOffer(request $request){
		$validator =  Validator::make($request->all(), [
            'offer_id' => 'required'
        ]);

        if($validator->fails()){
			 return response()->json(['response_code' => 'ERR_RULES' , 'messages' => $Validator->errors()->all() ],400);
		}

		$matchThese = ['id' => $request->input('offer_id') , 'is_child' => false ];

		$offer = Offers::where($matchThese)->first();
		if ($offer == '' || empty($offer)) {
			return response()->json(['response_code' => 'ERR_UNA' , 'messages' => 'User Not Authorized'],403);
		}

		if (!$this->checkUserHasStorePermission($offer->store_id)) { // checking if offer can be editable by logged in store
			return response()->json(['response_code' => 'ERR_UNA' , 'messages' => 'User Not Authorized'],403);
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

		return response()->json(['response_code' => 'ERR_OU' , 'messages' => 'Offer Updated' , 'data' => $status]);

	}



    public function editOffer(request $request){
    	$rules = array(
			'offer_id' => 'required',
			'title' => 'required',
			'fineprint' => 'required',
			'startDate' => 'required',
			'endDate' => 'required',
			);

		$Validator = $this->customValidator($request->all(), $rules, array());
		
		if($Validator->fails()){
			return response()->json(['response_code' => 'ERR_RULES' , 'messages' => $Validator->errors()->all() ],400);
		}
		

		$matchThese = ['id' => $request->input('offer_id') , 'is_child' => false];
		$offer = Offers::where($matchThese)->first();

		if(empty($offer)){
			return response()->json(['response_code' => 'ERR_UNA' , 'messages' => 'User Not Authorized'],403);
		}
		if (!$this->checkUserHasStorePermission($offer->store_id)) { // checking if offer can be editable by logged in store
			return response()->json(['response_code' => 'ERR_UNA' ,'messages' => 'User Not Authorized'],403);
		}

		foreach ($request->only('title','fineprint','startDate','endDate') as $key => $value) {
			$offer->$key = $value;
		}

		$offer->save();

		if($offer->is_parent && $this->checkIfStoreIsParent($offer->store_id)){
			//edit all child offer if above conditions are satisfied

			$matchThese = ['is_child' => true , 'parent_id' => $offer->id];
			Offers::where($matchThese)->update($request->only('title','fineprint','startDate','endDate'));
			//updating all offers
		}

		return response()->json(['response_code' => 'RES_OU' , 'messages' => 'Offer Updated']);

	}


	public function addOffer(request $request){

		$rules = array(
			'title' => 'required',
			'fineprint' => 'required',
			'startDate' => 'required',
			'endDate' => 'required',
			);

		$Validator = $this->customValidator($request->all(), $rules, array());
		
		if($Validator->fails()){
			return response()->json(['response_code' => 'ERR_RULES' , 'messages' => $Validator->errors()->all() ],400);
		}
		$is_parent = false;

		$offerArr = $request->only('title','fineprint','startDate','endDate');

		if($request->has('store_token')){
			if($request->input('store_token') == 'all' && Auth::user()->Stores->is_parent){
				$store_id = Auth::user()->Stores->id; 
				$is_parent = true;
 			}
 			else if($request->input('store_token') == 'all'){
 				return response()->json(['response_code' => 'ERR_UNA' ,'messages' => 'User Not Authorized'],403);
 			}
 			else{
 				$storeId = Crypt::decrypt($request->input('store_token'));
 				if (!$this->checkUserHasStorePermission($storeId)) {
					return response()->json(['response_code' => 'ERR_UNA' ,'messages' => 'User Not Authorized'],403);
				}
 				$store_id = $storeId;
 			}

		}
		else{
			$store_id = Auth::user()->Stores->id; 
		}

		$offerArr['store_id'] = $store_id;

		$offer = Offers::create($offerArr);

		if($is_parent){ 
			//creating offer for all sub merchants if user selects and if he is super merchant 
			$offer->is_parent = true;
		    $offer->save(); 
		    
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
		
		return response()->json(['response_code' => 'RES_SOC' , 'messages' => 'Store Offer Created','data' =>$offer],201);

	}

	public function getStoreOffers(request $request){

		$store_id = Auth::user()->stores->id; 

		return response()->json(['response_code' => 'RES_OFF' , 'messages' => 'Offers' , 'data' => Offers::with('votesCount','Store.Address.Area')->where('store_id',$store_id)->get()]);
	}
	 

	public function getLinkedStoreOffers(request $request){
		$rules = array(
			'store_token' => 'required',
		);

		$Validator = $this->customValidator($request->all(), $rules, array());


		if($Validator->fails()){
			return response()->json(['response_code' => 'ERR_RULES' , 'messages' => $Validator->errors()->all() ],400);
		}
		$store_id = Crypt::decrypt($request->input('store_token'));


		if(!$this->checkUserHasStorePermission($store_id)){
			return response()->json(['response_code' => 'ERR_UNA' ,'messages' => 'User Not Authorized'],403);
		}
		 

		return response()->json(['response_code' => 'RES_OFF' , 'messages' => 'Offers' , 'data' => Offers::with('votesCount','Store.Address.Area')->where('store_id',$store_id)->get()]);
	}

	public function getAllLinkedStoreOffers(){
		if(!Auth::User()->Stores->is_parent){
			return response()->json(['response_code' => 'ERR_UNA' ,'messages' => 'User Not Authorized'],403);
		}

		$matchThese = [ 'status' => true ,'is_child' => true , 'parent_id' => Auth::User()->Stores->id];
		$stores = MerchantStore::where($matchThese)->get();
		$storesArr = [];
		foreach ($stores as $key => $store) {
			$storesArr[$key] = $store->id;
		}
		$offers = Offers::with('Store.Address.Area','votesCount')
		              ->whereIn('store_id',$storesArr)
			          ->orderby('created_at','desc')
			          ->get();

		return response()->json(['response_code' => 'RES_OFF' , 'messages' => 'Offers' , 'data' => $offers ]);

	}


}