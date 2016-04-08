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
			$matchThese = [ 'is_child' => true , 'parent_id' => $storeMain->id];
			$stores = MerchantStore::with('Address','OffersCount')->where($matchThese)->get();
			foreach ($stores as $key => $store) {
				$linked[$key]['store_id']   = $store->id;
				$linked[$key]['store_name'] = $store->store_name;
				$linked[$key]['store_area'] = $store->Address->Area->title;
				$linked[$key]['store_city'] = $store->Address->City->title;
				$linked[$key]['offers_count'] = $store->OffersCount->first()->count;

			}
		}
		else{
			$linked = '';
		}
		 
		return response()->json(['response_code' => 'RES_SD' , 'messages' => 'Store Details' , 'data' => ['store' => $storeMain , 'user' => $user , 'linked' => $linked ] ]);
	}

	 
	 

    protected function checkUserHasStorePermission($store_id){
    	$hasStore = false;
    	$storeId = Auth::user()->stores->id;
    	$matchThese = ['id' => $store_id , 'parent_id' => $storeId , 'is_child' => true];
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
		$store->address()->create($request->only('street','city_id','state_id','country_id','pincode','latitude','longitude'));

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


    public function editOffer(request $request){
    	$rules = array(
			'store_id' => 'required',
			'offer_id' => 'required',
			'title' => 'required',
			'fineprint' => 'required',
			'startDate' => 'required',
			'endDate' => 'required',
			'is_parent' => 'required', // is used to check either editing is done on global offer or normal offer
			);

		$Validator = $this->customValidator($request->all(), $rules, array());
		
		if($Validator->fails()){
			return response()->json(['response_code' => 'ERR_RULES' , 'messages' => $Validator->errors()->all() ],400);
		}

		if($request->has('store_id')){  
		   // edit offer for only linked store * two cases -> supermerchant tab edit global offer selecting single merchant 
		   // and sub merchant tab edit individual offer. store token can be passed to edit that store offer only
			
			$store_id = $request->input('store_id');
			
			if(!$this->checkUserHasStorePermission($store_id)){ 
			    // check token give is valid , checking wiether token belongs to child merchant
				
				return response()->json(['response_code' => 'ERR_UNA' ,'messages' => 'User Not Authorized'],403);
			}
		}
		else{
			// if token is empty offer belongs to logged in user
			$store_id = Auth::user()->stores->id;
		}    
		

		$matchThese = ['id' => $request->input('offer_id') , 'store_id' => $store_id];
		$offer = Offers::where($matchThese)->first();

		if(empty($offer)){
			return response()->json(['response_code' => 'ERR_UNA' , 'messages' => 'User Not Authorized'],403);
		}
		foreach ($request->only('title','fineprint','startDate','endDate') as $key => $value) {
			$offer->$key = $value;
		}

		$offer->save();

		if($request->input('is_parent') && $offer->is_parent && $this->checkIfStoreIsParent($store_id)){
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
			'is_parent' => 'required', // is user option , either offer is created as global offer or normal offer
			);

		$Validator = $this->customValidator($request->all(), $rules, array());
		
		if($Validator->fails()){
			return response()->json(['response_code' => 'ERR_RULES' , 'messages' => $Validator->errors()->all() ],400);
		}

		$offerArr = $request->only('title','fineprint','startDate','endDate');

		if($request->has('store_id')){
			// adding offer to single store from super merchant logged in user

			$store_id = $request->input('store_id');

			if(!$this->checkUserHasStorePermission($store_id)){
				// cheking super merchant has permission to add offer to selected store
				return response()->json(['response_code' => 'ERR_UNA' ,'messages' => 'User Not Authorized'],403);
			}

			$offerArr['is_parent'] = false;

		}
		else{
			$store_id = Auth::user()->stores->id;
			$offerArr['is_parent'] = $request->input('is_parent');
		}   
		
		$offerArr['store_id'] = $store_id;

		$offer = Offers::create($offerArr);

		if($request->input('is_parent') && $this->checkIfStoreIsParent($store_id)){ 
			//creating offer for all sub merchants if user selects and if he is super merchant 
			$offer->is_parent = true;
		    $offer->save(); 
		    
			$matchThese = [ 'is_child' => true , 'parent_id' => $store_id];
			$stores = MerchantStore::where($matchThese)->get();
			foreach ($stores as $store) {
				$offerInp = $request->only('title','fineprint','startDate','endDate');
				$offerInp['store_id'] = $store->id;
				$offerInp['is_child'] = true;
				$offerInp['parent_id'] = $offer->id;
				Offers::create($offerInp);
			}
		}
		
		return response()->json(['response_code' => 'RES_SOC' , 'messages' => 'Store Offer Created','data' =>$offer],201);

	}

	public function getStoreOffers(request $request){

		$store_id = Auth::user()->stores->id; 

		return response()->json(['response_code' => 'RES_OFF' , 'messages' => 'Offers' , 'data' => Offers::with('votesCount','favouriteCount')->where('store_id',$store_id)->get()]);
	}
	 

	public function getLinkedStoreOffers(request $request){
		$rules = array(
			'store_id' => 'required',
		);

		$Validator = $this->customValidator($request->all(), $rules, array());


		if($Validator->fails()){
			return response()->json(['response_code' => 'ERR_RULES' , 'messages' => $Validator->errors()->all() ],400);
		}
		$store_id = $request->input('store_id');


		if(!$this->checkUserHasStorePermission($store_id)){
			return response()->json(['response_code' => 'ERR_UNA' ,'messages' => 'User Not Authorized'],403);
		}
		 

		return response()->json(['response_code' => 'RES_OFF' , 'messages' => 'Offers' , 'data' => Offers::with('votesCount','favouriteCount')->where('store_id',$store_id)->get()]);
	}


}