<?php
namespace App\Http\Controllers\Admin;

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
use Hash;
use App\MerchantStoreAddress;
use Image;
use Input;

class AdminController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getDashboard(){
		$now =  Carbon::now();
		$date  = Carbon::now();
		$date->subWeek();
		$output = [
		'aUsers' => User::where('status',true)->count(),
		'iUsers' => User::where('status',false)->count(),
		'aStores' => MerchantStore::where('status',true)->count(),
		'iStores' => MerchantStore::where('status',false)->count(),
		'today' => Offers::where('startDate' , '<=' , $now)
			          ->where('endDate' , '>=' , $now)
			          ->count(),
	    'future' => Offers::where('startDate' , '>' , $now)->count(),
	    'past' => Offers::where('endDate' , '<' , $now)->count(),
	    'week_aUsers' => User::where('status',true)->where('created_at','>', $date->toDateTimeString() )->count(),
	    'week_iUsers' => User::where('status',false)->where('created_at','>', $date->toDateTimeString() )->count(),
	    'week_offers' => Offers::where('startDate' , '>' , $date->toDateTimeString() )->where('endDate' , '<=' , $now)->count(),
	    'uber_rides' => '0',
		];
		return view('admin.dashboard',$output);
	}

	public function getElements(){
		$output = [ 'tags' => Tag::all() , 'cities'=> Cities::all() , 'states' => States::all() , 'countries' => Countries::all() ];
		return view('admin.elements',$output);
	}

	public function getAddSuperMerchant(){
		$matchThese = ['status' => true , 'is_parent' => false , 'is_child' => false];
		$output['stores'] = MerchantStore::with(['Address.Area','Merchant'])->where($matchThese)->orderby('id','DESC')->get(); //
		//return $output;
		return view('admin.addSuperMerchant',$output);
	}

	public function getSuperMerchantsList(){
		$stores = MerchantStore::parents()->with('Address.Area')->paginate(20);
		foreach ($stores as $key => $store) {
			$stores[$key]['childs'] = MerchantStore::childs($store->id)->with('Address.Area')->get();
		}
		$output['stores'] = $stores;
		return view('admin.superMerchantsList',$output);
	}

	public function getSuperMerchantEdit($id){
		$matchThese = ['id' => $id ,'status' => true , 'is_parent' => true , 'is_child' => false];
		$parent = MerchantStore::where($matchThese)->with('Address.Area')->first();
		if(empty($parent)){
			return 'No Store Exists';
		}
		$matchThese = ['parent_id' => $parent->id , 'status' => true , 'is_parent' => false , 'is_child' => true];
		$childs = MerchantStore::where($matchThese)->with('Address.Area')->get();

		$matchThese = ['status' => true , 'is_parent' => false , 'is_child' => false];
		$excludedStores = MerchantStore::with(['Address.Area'])->where($matchThese)->orderby('id','DESC')->get(); //

		$output = ['parent' => $parent , 'childs' => $childs , 'excludedStores' => $excludedStores];

		return view('admin.editSuperMerchant',$output);
	}

	public function addSuperMerchant(request $request){

		$validator = Validator::make($request->all(), [
            'superMerchant' => 'required',
            'childMerchants' => 'required'
        ]);

        if($validator->fails()){
        	return redirect('admin/addSuperMerchant')
                        ->withErrors($validator);  
        }

        $childs = explode(',', $request->input('childMerchants'));
        foreach (array_keys($childs, $request->input('superMerchant')) as $key) {
		    unset($childs[$key]);
		}

		$superMerchant = MerchantStore::find($request->input('superMerchant'));
		if(!$superMerchant->is_parent){
			$superMerchant->is_parent = true;
			$superMerchant->save();
		}
		else{
			return redirect('admin/addSuperMerchant')
                        ->with('message','Super Merchant Selected already used as Super Merchant');
		}

        $message = '';
        foreach ($childs as $value) {
        	$childMerchant = MerchantStore::find($value);
        	if(!$childMerchant->is_child){
        		$childMerchant->is_child = true;
	        	$childMerchant->parent_id = $superMerchant->id;
	        	$childMerchant->save();
        	}
        	else{
        		$message .= $childMerchant->store_name.',';

        	}
        	unset($childMercahnt);
        }

        if(!empty($message)){
        	$message = 'Given Child Merchants '.$message.' cannot be added as child for the give super merchant.'.$superMerchant->store_name;
        	return redirect('admin/addSuperMerchant')->with('message',$message);
        }

        return redirect('admin/superMerchants');
		
	}

	public function editSuperMerchant(request $request){

		$validator = Validator::make($request->all(), [
            'superMerchant' => 'required',
            'childMerchants' => 'required',
        ]);

        if($validator->fails()){
        	return redirect('admin/addSuperMerchant')
                        ->withErrors($validator);  
        }

        $childs = explode(',', $request->input('childMerchants'));

        foreach (array_keys($childs, $request->input('superMerchant')) as $key) {
		    unset($childs[$key]);
		}

		/*$old_parent_id = $request->input('parent_id'); /// first reset all previously added parent and child linking

		MerchantStore::where('id',$old_parent_id)->orWhere('parent_id',$old_parent_id)->update(['is_parent'=> false , 'is_child' => false , 'parent_id' => '0']);*/

		$superMerchant = MerchantStore::find($request->input('superMerchant'));
		// if(!$superMerchant->is_parent){
		// 	$superMerchant->is_parent = true;
		// 	$superMerchant->save();
		// }
		// else{
		// 	return redirect('admin/addSuperMerchant')
  //                       ->with('message','Super Merchant Selected already used as Super Merchant');
		// }

        $message = '';

        foreach ($childs as $value) {
        	$childMerchant = MerchantStore::find($value);
        	if(!$childMerchant->is_child){
        		$childMerchant->is_child = true;
	        	$childMerchant->parent_id = $superMerchant->id;
	        	$childMerchant->save();
        	}
        	else{
        		$message .= $childMerchant->store_name.',';

        	}
        	unset($childMercahnt);
        }

        if(!empty($message)){
        	$message = 'Given Child Merchants '.$message.' cannot be added as child for the give super merchant.'.$superMerchant->store_name;
        	return redirect('admin/addSuperMerchant')->with('message',$message);
        }

        return redirect('admin/superMerchants');
		
	}

	public function getAddElement($element){
		switch ($element) {
			case 'tag':
				$output = ['post_url' => '/admin/element/add/tag', 'tab'=> 'Tag'];
				break;

			case 'city':
				$output = ['post_url' => '/admin/element/add/city', 'tab'=> 'City'];
				break;

			case 'state':
				$output = ['post_url' => '/admin/element/add/state', 'tab'=> 'State'];
				break;

			case 'country':
				$output = ['post_url' => '/admin/element/add/country', 'tab'=> 'Country'];
				break;
			
		}

		return view('admin.addElement',$output);
	}

	public function getEditElement($id,$element){
		switch ($element) {
			case 'tag':
			    $element  = Tag::where('id',$id)->first();
				$output = ['post_url' => '/admin/element/edit/tag', 'tab'=> 'Tag', 'id'=> $id ,'title' => $element->title ];
				break;

			case 'city':
			    $element  = Cities::where('id',$id)->first();
				$output = ['post_url' => '/admin/element/edit/city', 'tab'=> 'City' , 'id'=> $id ,'title' => $element->title ];
				break;

			case 'state':
			    $element  = States::where('id',$id)->first();
				$output = ['post_url' => '/admin/element/edit/state', 'tab'=> 'State' , 'id'=> $id ,'title' => $element->title ];
				break;

			case 'country':
			    $element  = Countries::where('id',$id)->first();
				$output = ['post_url' => '/admin/element/edit/country', 'tab'=> 'Country' , 'id'=> $id ,'title' => $element->title ];
				break;
			
		}

		return view('admin.editElement',$output);
	}


	public function addElement(request $request, $element){
		switch ($element) {
			case 'tag':
				$validator = Validator::make($request->all(), [
					'title' => 'required|unique:tags',
		        ]);
		        if($validator->fails()){
		        	return redirect('admin/element/add/tag')
		                        ->withErrors($validator);  
		        }

		        Tag::create($request->only('title'));

				break;
			
			case 'city':
				$validator = Validator::make($request->all(), [
					'title' => 'required|unique:cities',
		        ]);
		        if($validator->fails()){
		        	return redirect('admin/element/add/city')
		                        ->withErrors($validator);  
		        }

		        Cities::create($request->only('title'));

				break;
			
			case 'state':
				$validator = Validator::make($request->all(), [
					'title' => 'required|unique:states',
		        ]);
		        if($validator->fails()){
		        	return redirect('admin/element/add/state')
		                        ->withErrors($validator);  
		        }

		        States::create($request->only('title'));
				break;
			
			case 'country':
				$validator = Validator::make($request->all(), [
					'title' => 'required|unique:countries',
		        ]);
		        if($validator->fails()){
		        	return redirect('admin/element/add/country')
		                        ->withErrors($validator);  
		        }

		        Countries::create($request->only('title'));
				break;
			
			 
		}

		return redirect('admin/elements');

	}

	public function editElement(request $request, $element){
		switch ($element) {
			case 'tag':
				$validator = Validator::make($request->all(), [
					'title' => 'required|unique:tags',
					'element_id' => 'required',
		        ]);
		        $input  = $request->only('element_id','title');

		        if($validator->fails()){
		        	return redirect('admin/element/edit/'.$input['element_id'].'/tag')
		                        ->withErrors($validator);  
		        }

 		        $element = Tag::where('id',$input['element_id'])->first();
		        $element->title = $input['title'];
		        $element->save();
		        
				break;
			
			case 'city':
				$validator = Validator::make($request->all(), [
					'title' => 'required|unique:cities',
					'element_id' => 'required',
		        ]);
		        $input  = $request->only('element_id','title');

		        if($validator->fails()){
		        	return redirect('admin/element/edit/'.$input['element_id'].'/city')
		                        ->withErrors($validator);  
		        }

		        $element = Cities::where('id',$input['element_id'])->first();
		        $element->title = $input['title'];
		        $element->save();

				break;
			
			case 'state':
				$validator = Validator::make($request->all(), [
					'title' => 'required|unique:states',
					'element_id' => 'required',
		        ]);
		        $input  = $request->only('element_id','title');

		        if($validator->fails()){
		        	return redirect('admin/element/edit/'.$input['element_id'].'/state')
		                        ->withErrors($validator);  
		        }

		        $element = States::where('id',$input['element_id'])->first();
		        $element->title = $input['title'];
		        $element->save();

				break;
			
			case 'country':
				$validator = Validator::make($request->all(), [
					'title' => 'required|unique:countries',
					'element_id' => 'required',
		        ]);
		        $input  = $request->only('element_id','title');

		        if($validator->fails()){
		        	return redirect('admin/element/edit/'.$input['element_id'].'/country')
		                        ->withErrors($validator);  
		        }


 		        $element = Countries::where('id',$input['element_id'])->first();
		        $element->title = $input['title'];
		        $element->save();

				break;
			
			 
		}

		return redirect('admin/elements');

	}


	public function searchUsers(request $request){
		$query  = $request->only('q');
		$users  = User::with('roles')
		          ->where('name','LIKE','%'.$query['q'].'%')
		          ->orWhere('mobile', 'LIKE','%'.$query['q'].'%')
		          ->orWhere('email', 'LIKE','%'.$query['q'].'%')
		          ->paginate(15);
		          
		$output = array('users' => $users);
		return view('admin.users',$output);
	}

	public function searchStores(request $request){
		$now =  Carbon::now();
		$query  = $request->only('q');
		$keyword = $query['q'];;
		$stores = MerchantStore::with(['Address','tags','Merchant','Offers'=> function ($query) use($now){
						$query->where('startDate' , '>=' , $now );
					}])
		            ->where('store_name','LIKE','%'.$keyword.'%')
		            ->orwhereHas('Merchant', function($query) use ($keyword) {
		                    $query->where('name', 'LIKE', "%$keyword%");
		                })
					->paginate(16);
		          
		$output = array('stores' => $stores);
		return view('admin.stores',$output);
	}

	public function searchOffers(request $request){
		$query  = $request->only('q');
		
		          
		$output = array('offers' => $offers);
		return view('admin.offers',$output);
	}

	public function getUsers(request $request,$status){
		
		if ($status == 'active') {
			$users  = User::with('roles')->where('status',true)->orderby('id','DESC')->paginate(15);
		}
		elseif($status == 'inactive'){
			$users  = User::with('roles')->where('status',false)->orderby('id','DESC')->paginate(15);
		}
		else{
			$users = User::with('roles')->orderby('id','DESC')->paginate(15);
		}

		$output = array('users' => $users);
		
		return view('admin.users',$output);
	}

	public function getTypeUsers(request $request,$type){
		$users = User::whereHas('roles' , function($q) use ($type){
				    $q->where('name', $type);
				})->orderby('id','DESC')->paginate(15);

		$output = array('users' => $users);
		
		return view('admin.users',$output);
	}

	public function getSingleUser(request $request , $id){
		$user = User::where('id',$id)->first();
	    $output = array('user' => $user);
	    return view('admin.user',$output);
	}

	public function getSingleUserEdit(request $request,$id){
		$user = User::where('id',$id)->first();
		$roles = Role::all();
	    $output = array('user' => $user,'roles'=>$roles);
	    return view('admin.userEdit',$output);
	}

	public function getAddUser(){
		$roles = Role::all();
	    $output = array('roles'=>$roles);
	    return view('admin.addUser',$output);
	}

	public function addUser(request $request){
		$validator = Validator::make($request->all(), [
            'mobile' => 'required|size:10',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'status' => 'required',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
        	return redirect('admin/user/new/add')
                        ->withErrors($validator);  
        }
        $pass = $request->only('password');
        $input  = $request->only('name','mobile','password','email','status');
        $input['password'] = Hash::make($pass['password']);

        $user = User::create($input);

        if($input['status']){
        	$user->status = true;
        	$user->save();
        }
        
        $tags  = $request->only('tags');
        if(!empty($tags['tags'])|| $tags['tags'] != ''){
        	$tags = explode(',', $tags['tags']);
        	$user->roles()->sync($tags);
        }

        return redirect('admin/user/'.$user->id);


	}


	public function updateUser(request $request){
		//return $request->only('tags');
		$validator = Validator::make($request->all(), [
            'mobile' => 'required|size:10',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'status' => 'required',
            'user_id' => 'required',
        ]);

        $input = $request->only('user_id');

        if($validator->fails()){
        	return redirect('admin/user/'.$input["user_id"].'/edit')
                        ->withErrors($validator);  
        }
        

        $user = User::find($input['user_id']);
        foreach ($request->except(['tags','_token','user_id']) as $key => $value) {
        	$user->$key = $value;
        }
        $user->save();

        $tags  = $request->only('tags');
        if(!empty($tags['tags'])|| $tags['tags'] != ''){
        	$tags = explode(',', $tags['tags']);
        	$user->roles()->sync($tags);
        }

        $userObj  = User::where('id',$input['user_id'])->first();

        $output = ['user' => $userObj];

        return redirect('admin/user/'.$input['user_id']);
		 
	}

	public function getAddStore($id){
		$tags = Tag::all();
		$areas = Areas::all();
		$cities = Cities::all();
		$states = States::all();
		$countries = Countries::all();
		$user = User::where('id',$id)->first();

		$output = ['user'=>$user, 'tags' => $tags, 'areas' => $areas, 'cities'=> $cities , 'states' => $states , 'countries' => $countries];
		return view('admin.storeAdd',$output);

	}

	public function addStore(request $request){
		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
            'store_name' => 'required|max:255',
            'veg' => 'required',
            'landline' => 'required',
            'status' => 'required',
            'street' => 'required|max:200',
            'city_id' => 'required',
            'area_id' => 'required',
            'state_id' => 'required',
            'cost_two' => 'required',
            'country_id' => 'required',
            'pincode' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'logo' => 'required|max:1000|mimes:jpeg,jpg,png',
        ]);

        $input = $request->only('user_id');

        if($validator->fails()){
        	return redirect('admin/user/'.$input["user_id"].'/addstore')
                        ->withErrors($validator);  
        }
        

        $store = MerchantStore::create($request->only('user_id','store_name','veg','cost_two','landline','status'));
        $store->Address()->create($request->only('street','area_id','city_id','state_id','country_id','pincode','latitude','longitude'));

        $image = $request->file('logo');
        $imageName = strtotime(Carbon::now()).md5($store->id).'.'. $image->getClientOriginalExtension();
        $path = public_path('assets/img/stores/'.$imageName);
        Image::make($image->getRealPath())->resize(280, null, function ($constraint) {
														    $constraint->aspectRatio();
														})->save($path);
		
		$store->logoUrl = $imageName;
		$store->save();

		$store->tags()->detach();
		$tags = $request->only('tags');
		$tagStore = explode(',', $tags['tags']);
		$store->tags()->attach($tagStore);

		return redirect('admin/store/'.$store->id);
	}

	public function getStores($type){
		$now =  Carbon::now();
		if($type == 'active'){
			$stores = MerchantStore::with(['Address','tags','Merchant','Offers'=> function ($query) use($now){
				$query->where('startDate' , '>=' , $now );
			}])
			->where('status',true)
			->orderby('id','DESC')
			->paginate(16);
		}
		elseif($type == 'inactive'){
			$stores = MerchantStore::with(['Address','tags','Merchant','Offers'=> function ($query) use($now){
				$query->where('startDate' , '>=' , $now );
			}])
			->where('status',false)
			->orderby('id','DESC')
			->paginate(16);
		}
		else{
			$stores = MerchantStore::with(['Address','tags','Merchant','Offers'=> function ($query) use($now){
				$query->where('startDate' , '>=' , $now );
			}])
			->orderby('id','DESC')
			->paginate(16);
		}
		
		//return $stores;
		$output['stores'] = $stores;
		return view('admin.stores',$output);
	}

	public function getCategoryStores($id){
		$stores = MerchantStore::whereHas('Tags', function ($query) use ($id){
		    $query->where('id',$id);
		})->with(['Address','Tags','Merchant','Offers'])->orderby('id','DESC')->paginate(10);

		$output['stores'] = $stores;
		return view('admin.stores',$output);
	}

	public function getSingleStore($id){
		$store = MerchantStore::with(['Address','tags','Merchant','Offers'])
		->where('id',$id)
		->first();

		$output['store'] = $store;
		return view('admin.store',$output);
	}

	public function getEditStore($id){
		$store = MerchantStore::with(['Address','tags','Merchant'])
		->where('id',$id)
		->first();

		$tags = Tag::all();
		$cities = Cities::all();
		$areas = Areas::all();
		$states = States::all();
		$countries = Countries::all();

		$output = ['store' => $store, 'tags' => $tags, 'areas'=> $areas, 'cities'=> $cities , 'states' => $states , 'countries' => $countries];
		return view('admin.storeEdit',$output);

	}

	public function updateStore(request $request){
		$validator = Validator::make($request->all(), [
			'store_id' => 'required',
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
        	return redirect('admin/store/'.$input["store_id"].'/edit')
                        ->withErrors($validator);  
        }
        

        $store = MerchantStore::find($input['store_id']);
		foreach ($request->only('store_name','cost_two','veg','landline','status') as $key => $value) {
			$store->$key = $value;
		}

		if($request->hasFile('logo'))
		{
			$image = $request->file('logo');
	        $imageName = strtotime(Carbon::now()).md5($input['store_id']).'.'. $image->getClientOriginalExtension();
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

		$matchThese = ['store_id' => $input['store_id']];
		$address = MerchantStoreAddress::where($matchThese)->first();

		foreach ($request->only('street','area_id','city_id','state_id','country_id','pincode','latitude','longitude') as $key => $value) {
			$address->$key = $value;
		}
		$address->save();

		return redirect('admin/store/'.$input['store_id']);

	}

	public function getStoreOffers(request $request,$id,$period){

	    $now =  Carbon::now();

		if ($period == 'today') {
			$offers = Offers::with('store','favouriteCount','votesCount')
			          ->where('store_id' , $id)
			          ->where('startDate' , '<=' , $now)
			          ->where('endDate' , '>=' , $now)
			          ->orderby('created_at','desc')
			          ->paginate(20);
		}
		elseif($period == 'future'){
			$offers = Offers::with('store','favouriteCount','votesCount')
			          ->where('store_id' , $id)
			          ->where('startDate' , '>' , $now)
			          ->orderby('created_at','desc')
			          ->paginate(20);
		}
		elseif ($period == 'past'){
			$offers = Offers::with('store','favouriteCount','votesCount')
			          ->where('store_id' , $id)
			          ->where('endDate' , '<' , $now)
			          ->orderby('created_at','desc')
			          ->get();
		}
		else {
			$offers = Offers::with('store','favouriteCount','votesCount')
			          ->where('store_id' , $id)
			          ->orderby('created_at','desc')
			          ->paginate(20);
		}
		

	    $store = MerchantStore::with(['Address','tags','Merchant'])
		->where('id',$id)
		->first();

	    $output = ['offers'=>$offers,'store'=>$store];

		//return $output;
		return view('admin.storeOffers',$output);
	}


	public function getOffers(request $request,$period){
		$now =  Carbon::now();

		if ($period == 'today') {
			$offers = Offers::with('store','favouriteCount','votesCount')
			          ->where('startDate' , '<=' , $now)
			          ->where('endDate' , '>=' , $now)
			          ->orderby('created_at','desc')
			          ->paginate(20);
		}
		elseif($period == 'future'){
			$offers = Offers::with('store','favouriteCount','votesCount')
			          ->where('startDate' , '>' , $now)
			          ->orderby('created_at','desc')
			          ->paginate(20);
		}
		elseif ($period == 'past'){
			$offers = Offers::with('store','favouriteCount','votesCount')
			          ->where('endDate' , '<' , $now)
			          ->orderby('created_at','desc')
			          ->paginate(20);
		}
		else {
			$offers = Offers::with('store','favouriteCount','votesCount')
			          ->orderby('created_at','desc')
			          ->paginate(20);
		}
		
		$output = ['offers'=>$offers];

		//return $output;
		return view('admin.offers',$output);
	}

	public function getEditOffer($id){
		$offer = Offers::where('id',$id)->first();

		$output = ['offer'=>$offer];

		//return $output;
		return view('admin.editOffer',$output);

	}

	public function updateOffer(request $request){
		$validator = Validator::make($request->all(), [
			'offer_id' => 'required',
            'title' => 'required|max:255',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'fineprint' => 'required|min:5',
        ]);

        $input = $request->only('offer_id');

        if($validator->fails()){
        	return redirect('admin/offer/'.$input["offer_id"].'/edit')
                        ->withErrors($validator);
        }
        

        $offer = Offers::where('id',$input['offer_id'])->first();
        foreach ($request->except('_token','offer_id') as $key => $value) {
        	$offer->$key = $value;
        }

        $offer->save();

        return redirect('admin/offer/'.$input['offer_id']);

	}

	public function getAddOffer($id){
		$output = ['store_id' => $id];
		return view('admin.addOffer',$output);
	}

	public function addOffer(request $request){
		$validator = Validator::make($request->all(), [
			'store_id' => 'required',
            'title' => 'required|max:255',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'fineprint' => 'required|min:5',
        ]);

        $input = $request->only('store_id');

        if($validator->fails()){
        	return redirect('admin/store/'.$input["store_id"].'/addoffer')
                        ->withErrors($validator);
        }
        
        $offer = Offers::create($request->only('store_id','title','fineprint','startDate','endDate'));

        return redirect('admin/store/'.$input['store_id'].'/offers/all');
	}

	public function deleteOffer($id){
		$offer = Offers::where('id',$id)->first();
		$offer->delete();

		return redirect('admin/offers/all');
	}

	public function deleteUser($id){
		$user = User::where('id',$id)->first();
		$user->delete();

		return redirect('admin/users/all');
	}

	public function deleteTag($id){
		$tag = Tag::where('id',$id)->first();
		$tag->delete();

		return redirect('admin/elements');
	}

	public function getSingleOffer($id){
		$offer = Offers::with('store')->where('id',$id)->first();
		$output = ['offer'=>$offer];
		return view('admin.offer',$output);

	}

	


}