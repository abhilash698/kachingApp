<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\UserSmsCode;
use Validator;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Config;
use Curl;
use \Firebase\JWT\JWT;
use Carbon\Carbon;
use Image;
use Crypt;
use App\TempMobile;

class AuthController extends Controller
{

    protected $loginPath = '/admin/login';

    protected $redirectPath = '/admin/dashboard';

    protected $redirectAfterLogout = '/';
     

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

   
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'mobile' => 'required|size:10|unique:users',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }


    protected function customValidator(array $data, array $rules, array $messages)
    {
        return Validator::make($data,$rules,$messages);  // muqf mobile unique fail
    }


    protected function create(array $data)
    {
        return User::create([
            'mobile' => $data['mobile'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /*protected function sendOtp($user){
        $previousSms = UserSmsCode::where('user_id',$user->id)->first();
        if($previousSms != ''){
            $previousSms->delete;
        }
        

        $otp = rand(1000, 9999);
        $sms = Curl::to('https://control.msg91.com/api/sendhttp.php?authkey=101670ALSycXxv0ZZX56920dcd&mobiles='.$user->mobile.'&message=Your%20Kaching%20OTP%20is%20'.$otp.'.%20Start%20dealing!&sender=KACHIN&route=4')
        ->get();

        $smsDb = ['user_id' => $user->id , 'code' => $otp , 'reference_id' => $sms];
        UserSmsCode::create($smsDb);
    }
*/

    protected function register($data, $role){
        if($role->name == 'customer'){
            $data['password'] = 'secret';
        }
        
        $rules = array(
            'mobile' => 'required|size:10',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
            'name' => 'required|max:30',
            'mobile_key' => 'required',
            );

        $validator = $this->customValidator($data,$rules,array());
        if ($validator->fails()) {
            return response()->json([ 'response_code' => 'ERR_RULES' ,'message' => $validator->errors()->all()],400);          
        }


        $mobile_id = Crypt::decrypt($data['mobile_key']); 
        $tempMobile = TempMobile::where('id',$mobile_id)->first();
        if($data['mobile'] != $tempMobile->mobile){
            return response()->json([ 'response_code' => 'ERR_UAE' , 'message' => 'Mobile Key Invalid' ],403);
        }

        $rules = array(
        'mobile' => 'unique:users',
        'email' => 'unique:users',
        );

        //$messages = array('mobile.unique' => 'muqf' );
        $validator = $this->customValidator($data,$rules,array());
        $messages = $validator->messages();

        if ($messages->has('email')) { 

             $user = User::where('email','=',$data['email'])->first();
             if($user->hasRole([$role->name])){
                return response()->json([ 'response_code' => 'ERR_UAE' , 'message' => 'User Already Exists' ],409);
             }

             if($user->status == 0){
                return response()->json(['response_code'=> 'RES_IAU' ,'message'=> 'In Active User'],403);
             }
             
             $user->attachRole($role);

             return $this->login($user,$role->name);         
        }

        if($messages->has('mobile')){
            $muser = User::where('mobile','=',$data['mobile'])->first();
            if($muser->hasRole([$role->name])){
                return response()->json(['response_code' => 'ERR_MNT' , 'message' => 'Mobile Number Taken'],409);
            }            
        }
        
        if (!empty($data['profileImg']) || $data['profileImg'] != '') {

            $url = $data['profileImg'];
            $extension = pathinfo($url, PATHINFO_EXTENSION);
            $imageName = strtotime(Carbon::now()).str_random(4).'.'. $extension;
            $imageName = substr($imageName, 0, strpos($imageName, '?'));

            $path = public_path('assets/img/users/'.$imageName);
            Image::make($url)->save($path);
            
            $data['profileImg'] = $imageName;
        }
        
        
        $user = $this->create($data);
        $user->attachRole($role);
        $user->status = 1;
        $user->save();


        return $this->login($user,$role->name);
    }

    protected function login($user,$type){
        $key = Config::get('custom.JWTkey');
        $token = array(
            "sub" => $user->id,
            "iss" => "http://homestead.app",
            "iat" => 1356999524,
            "name" => $user->name,
            "type" =>$type,
        );

        $jwt = JWT::encode($token, $key);

        return response()->json(['response_code' => 'TOKEN' , 'data' => $jwt ]);
    }

    public function googleLogin(Request $request){
        $token = $request->only('token');
        $rules = array(
        'token' => 'required',
        );
        $validator = $this->customValidator($token,$rules,array());
        if($validator->fails()){
            return response()->json(['response_code'=> 'ERR_RULES' ,'message'=> $validator->errors()->all()],400);  
        }
 
        $user = Curl::to('https://www.googleapis.com/oauth2/v3/tokeninfo?id_token='.$token['token'])
        ->asJson()
        ->get();

        if(empty($user)){
           return response()->json(['response_code'=> 'ERR_IAT' ,'message'=> 'Invalid Access Token'],400);
        }

        $userImg = Curl::to('https://www.googleapis.com/plus/v1/people/'.$user->sub.'?fields=image&key=AIzaSyAUNh8M4d488jVuf_vU5prwOid4FkF4xmo ')
        ->asJson()
        ->get();


        if (empty($userImg)) {
            return response()->json(['response_code'=> 'ERR_IAT' ,'message'=> 'Invalid Access Token'],400);
        }

        $customer['email'] = $user->email;
        $customer['name'] = $user->name;
        $customer['profileImg'] = $userImg->image->url;

        
        

        $customerRole = Role::find(1);
        
        $userObj = User::where('email',$user->email)->first();
        if(!empty($userObj)){
            if($userObj->hasRole('customer') && $userObj->status == 1){
                return $this->login($userObj,'customer');
            }
            elseif ($userObj->status != 1) {
                return response()->json(['response_code'=> 'RES_IAU' ,'message'=> 'In Active User'],403);
            }
            elseif ($userObj->hasRole('customer') && empty($userObj->mobile)) {
                return response()->json(['response_code'=> 'ERR_UMFE' ,'message'=> 'User Mobile Feild Empty', 'data'=> $customer],403);
            }
            

            $userObj->attachRole($customerRole);
            return $this->login($userObj,'customer');
 
        }

        return response()->json(['response_code'=> 'RES_NU','message'=> 'New User', 'data'=> $customer]); // return only success message
        
    }


    public function fbLogin(Request $request){
        $token = $request->only('token');
        $rules = array(
        'token' => 'required',
        );
        $validator = $this->customValidator($token,$rules,array());
        if($validator->fails()){
            return response()->json(['response_code'=> 'ERR_RULES' ,'message'=> $validator->errors()->all()],400);  
        }
 
        $user = Curl::to('https://graph.facebook.com/v2.5/me?access_token='.$token['token'].'&fields=id,name,email')
        ->asJson()
        ->get();
         
        if(empty($user)){
           return response()->json(['response_code'=> 'ERR_IAT' ,'message'=> 'Invalid Access Token'],400);
        }

         $userImage = Curl::to('https://graph.facebook.com/v2.5/'.$user->id.'/picture?type=large&redirect=false&access_token='.$token['token'] )
        ->asJson()
        ->get();

        //return $userImage->data->url;
        $customer['email'] = $user->email;
        $customer['name'] = $user->name;
        $customer['profileImg'] = $userImage->data->url;

        $customerRole = Role::find(1);
        
        $userObj = User::where('email',$user->email)->first();
        if(!empty($userObj)){
            if($userObj->hasRole('customer') && $userObj->status == 1){
                return $this->login($userObj,'customer');
            }
            elseif (!$userObj->status) {
                return response()->json(['response_code'=> 'RES_IAU' ,'message'=> 'In Active User'],403);
            }
            elseif(!$userObj->is_mobile_verified){
                return response()->json(['response_code'=> 'RES_IAU' ,'message'=> 'In Active User'],403); 
            }
            elseif ($userObj->hasRole('customer') && empty($userObj->mobile)) {
                return response()->json(['response_code'=> 'ERR_UMFE' ,'message'=> 'User Mobile Feild Empty', 'data'=> $customer],403);
            }
            

            $userObj->attachRole($customerRole);
            return $this->login($userObj,'customer');
 
        }

        return response()->json(['response_code'=> 'RES_NU','message'=> 'New User', 'data'=> $customer]); // return only success message
        
    }

    public function postCustomerRegister(request $request){
        $userInput = $request->only('mobile','email','name','password','profileImg','mobile_key');
        $customerRole = Role::find(1);
        return $this->register($userInput,$customerRole);
    }

    public function postMerchantRegister(request $request){
        $userInput = $request->only('mobile','email','name','password','profileImg','mobile_key');
        $merchantRole = Role::find(2);
        return $this->register($userInput,$merchantRole);
    }

    public function postMerchantLogin(request $request){
        $credentials = $request->only('email','password');

        $rules = array(
            'email' => 'required',
            'password' => 'required',
            );

        $validator = $this->customValidator($request->all(),$rules,array());
        if ($validator->fails()) {
            return response()->json([ 'response_code' => 'ERR_RULES' , 'messages' => $validator->errors()->all()],400);             
        }

        if (Auth::once(array('email' => $credentials['email'], 'password' => $credentials['password']))) {
            $user = Auth::user();
            if($user->hasRole('merchant')){
                if($user->status){
                    return $this->login($user,'merchant');
                }
                else{
                    return response()->json(['response_code'=> 'RES_IAU' ,'message'=> 'In Active User'],403);
                }
            }
            else{
                return response()->json(['response_code' => 'ERR_WUC' , 'messages' => 'Wrong User Credentials'],404);
            }

        }


        return response()->json(['response_code' => 'ERR_WUC' , 'messages' => 'Wrong User Credentials'],404);
    }


    

    


    public function postLogin(request $request){

        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            if(Auth::user()->hasRole(['admin','superAdmin']) && Auth::user()->status){
                return $this->handleUserWasAuthenticated($request, $throttles);
            }
            /*Auth::user()->roles()->attach(4);*/
            Auth::logout();
            if ($throttles) {
                $this->incrementLoginAttempts($request);
            }

            return redirect($this->loginPath())
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors([
                    $this->loginUsername() => $this->getFailedLoginMessage(),
                ]);
            
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    
}
