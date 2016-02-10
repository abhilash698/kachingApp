<?php
namespace App\Http\Controllers;
use Carbon\Carbon;


use App\Tag;
use App\User;
use App\Offers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\MerchantStore;
use Validator;
use Auth;
use Curl;
use App\OfferFavourite;
use App\OfferVote;
use App\UserSmsCode;
use DB;

class CustomerService extends Controller {
	
	protected function customValidator(array $data, array $rules, array $messages)
    {
        return Validator::make($data,$rules,$messages);  // muqf mobile unique fail
    }

    protected function ifOfferHasFav($offer_id,$user_id){
    	$offerFav = OfferFavourite::where(['user_id'=> $user_id , 'offer_id' => $offer_id])->first();
    	if($offerFav == ''){
    		return false;
    	}
    	else{
    		return true;
    	}
    }

    protected function ifOfferHasVote($offer_id,$user_id){
    	$offerFav = OfferVote::where(['user_id'=> $user_id , 'offer_id' => $offer_id])->first();
    	if($offerFav == ''){
    		return false;
    	}
    	else{
    		return true;
    	}
    }

    public function validateOtp(Request $request){
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
    }


    public function getTags(){
		return response()->json(['response_code' => 'RES_TAGS' , 'messages' => 'Tags' , 'data' => Tag::get()]);
	}

	public function getOffers(request $request){
		$location = $request->only('latitude','longitude');
        $user_id = Auth::user()->id;
		$input = $request->only('tags');
		if (empty($input['tags'])) {
			$offers = DB::select(DB::raw("select offers.*,store.store_name,store.logoUrl,store.landline,store.cost_two,address.latitude,address.longitude,merchant.name, 
			        	(select count(*) from offer_vote where offer_id = offers.id) as votes, 
			        	(select count(*) from offer_vote where offer_id = offers.id AND user_id =".$user_id.") as hasUserVoted ,
			        	(select count(*) from offer_favourite where offer_id = offers.id AND user_id =".$user_id.") as hasUserFav,
			        	(select GROUP_CONCAT(tag_id SEPARATOR ',') FROM tag_store where store_id=offers.store_id GROUP BY store_id) as tags,
			        	(((acos(sin((".$location['latitude']."*pi()/180)) * 
				            sin((`Latitude`*pi()/180))+cos((".$location['latitude']."*pi()/180)) * 
				            cos((`Latitude`*pi()/180)) * cos(((".$location['longitude']."- `Longitude`)* 
				            pi()/180))))*180/pi())*60*1.1515
				        ) as distance  
			        	from offers  
			        	left join merchant_store as store on store.id = offers.store_id 
			        	left join users as merchant on merchant.id = store.user_id 
			        	left join merchant_store_address as address on address.store_id = offers.store_id
			        	where offers.status = 1 AND offers.deleted_at IS NULL
			        	ORDER BY distance DESC;"
		        	));
		}
		else{
			/*$tags = explode(',', $input['tags']); 
			$in = "IN ('" . implode("', '", $tags) . "')";*/

			$offers = DB::select(DB::raw("select offers.*,store.store_name,store.logoUrl,store.landline,store.cost_two,address.latitude,address.longitude,merchant.name, 
			        	(select count(*) from offer_vote where offer_id = offers.id) as votes, 
			        	(select count(*) from offer_vote where offer_id = offers.id AND user_id =".$user_id.") as hasUserVoted ,
			        	(select count(*) from offer_favourite where offer_id = offers.id AND user_id =".$user_id.") as hasUserFav,
			        	(select GROUP_CONCAT(tag_id SEPARATOR ',') FROM tag_store where store_id=offers.store_id GROUP BY store_id) as tags,
			        	(((acos(sin((".$location['latitude']."*pi()/180)) * 
				            sin((`Latitude`*pi()/180))+cos((".$location['latitude']."*pi()/180)) * 
				            cos((`Latitude`*pi()/180)) * cos(((".$location['longitude']."- `Longitude`)* 
				            pi()/180))))*180/pi())*60*1.1515
				        ) as distance  
			        	from offers  
			        	left join merchant_store as store on store.id = offers.store_id 
			        	left join users as merchant on merchant.id = store.user_id 
			        	left join merchant_store_address as address on address.store_id = offers.store_id
			        	left join tag_store on tag_store.store_id = offers.store_id and tag_store.tag_id IN (".$input['tags'].")
			        	where offers.status = 1 AND offers.deleted_at IS NULL
			        	ORDER BY distance DESC;"
		        	));
			
			 
		}

		return response()->json(['response_code' => 'RES_OFF' , 'messages' => 'Offers' , 'data' => $offers]);
	}


	public function makeFavoutite(request $request){
		$rules = array(
			'offer_id' => 'required'
			);
		$Validator = $this->customValidator($request->all(), $rules, array());
		
		if($Validator->fails()){
			return response()->json([ 'response_code' => 'ERR_RULES' , 'messages' => $Validator->errors()->all() ],400);
		}

		$input  = $request->only('offer_id');
		$offer_id = $input['offer_id'];
		$user_id = Auth::user()->id;

		if ($this->ifOfferHasFav($offer_id,$user_id)){
			//remove fav
			$offer = Offers::find($input['offer_id']);
			$offer->Favourites()->detach([$user_id]);

			return response()->json([ 'response_code' => 'ERR_FR' , 'messages' => 'Favourite Removed' ]);
		}
		
		$offer = Offers::find($input['offer_id']);
		$offer->Favourites()->attach([$user_id]);

		return response()->json(['response_code' => 'RES_OMF' , 'messages' => 'Offer Made favourite']);
	}

	public function makeVote(request $request){
		$rules = array(
			'offer_id' => 'required'
			);
		$Validator = $this->customValidator($request->all(), $rules, array());
		
		if($Validator->fails()){
			return response()->json([ 'response_code' => 'ERR_RULES' , 'messages' => $Validator->errors()->all() ],400);
		}
		$input  = $request->only('offer_id');
		$offer_id = $input['offer_id'];
		$user_id = Auth::user()->id;
		if ($this->ifOfferHasVote($offer_id,$user_id)){
			$offer = Offers::find($offer_id);
			/*$offer->Votes()->updateExistingPivot($user_id,['status'=>$input['status']]);*/
			$offer->Votes()->detach([$user_id]);;
			return response()->json([ 'response_code' => 'ERR_OVR' , 'messages' => 'Offer Vote Removed' ]);
		}

		$offer = Offers::find($offer_id);
		$offer->Votes()->attach([$user_id]); 

		return response()->json(['response_code' => 'RES_OMF' , 'messages' => 'Offer Voted']);

	}

	public function userFavOffers(request $request){
		$location = $request->only('latitude','longitude');
        $user_id = Auth::user()->id;

        $offers = DB::select(DB::raw("select users.id , users.name, offers.title, offers.startDate, offers.endDate, offers.fineprint,
        	                        store.store_name , store.logoUrl , store.cost_two, store.landline ,address.latitude,address.longitude,
        	                        (select count(*) from offer_vote where offer_id = offers.id) as votes, 
						        	(select count(*) from offer_vote where offer_id = offers.id AND user_id =".$user_id.") as hasUserVoted , 
						        	(select GROUP_CONCAT(tag_id SEPARATOR ',') FROM tag_store where store_id=offers.store_id GROUP BY store_id) as tags,
						        	(((acos(sin((".$location['latitude']."*pi()/180)) * 
							            sin((`Latitude`*pi()/180))+cos((".$location['latitude']."*pi()/180)) * 
							            cos((`Latitude`*pi()/180)) * cos(((".$location['longitude']."- `Longitude`)* 
							            pi()/180))))*180/pi())*60*1.1515
							        ) as distance  
                                    from users
                                    right join offer_favourite on offer_favourite.user_id = users.id
                                    left join offers on offers.id = offer_favourite.offer_id
                                    left join merchant_store as store on store.id = offers.store_id
                                    left join merchant_store_address as address on address.store_id = store.id
                                    where users.id = ".$user_id."
                                    "));

        return response()->json(['response_code' => 'RES_OFF' , 'messages' => 'Offers' , 'data' => $offers]);
		 
	}

	public function userProfile(){
		$user_id = Auth::user()->id;
		return response()->json(['response_code' => 'RES_OFF' , 'messages' => 'Offers' , 'data' => User::find($user_id)]);
	}

	public function editProfile(request $request){
		$rules = array(
        'email' => 'unique:users',
        );

        $validator = $this->customValidator($request->all(),$rules,array());
        if($validator->fails()){
            return response()->json([ 'response_code' => 'ERR_EAE' , 'message' => 'Email Already Exists' ],409); 
        }

		$user_id = Auth::user()->id;
		$user = User::find($user_id);
		foreach ($request->only('name','email') as $key => $value) {
			$user->$key = $value;
		}

		if($request->hasFile('profileImg'))
		{
			$image = $request->file('profileImg');
	        $imageName = strtotime(Carbon::now()).md5($user_id).'.'. $image->getClientOriginalExtension();
	        $path = public_path('assets/img/users/'.$imageName);
	        Image::make($image->getRealPath())->resize(280,240)->save($path);
	        $user->profileImg = $imageName;
	    }

		$user->save();
		return response()->json(['response_code' => 'RES_UU' , 'messages' => 'User Upadated','data' => $user ]);
	}

}