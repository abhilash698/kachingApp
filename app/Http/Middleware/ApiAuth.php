<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;
use Auth;
use Closure;
use \Firebase\JWT\JWT;
use App\User;
use Config;
use Validator;

class ApiAuth
{
     
    public function handle($request, Closure $next, $roles)
    {
        $apiKey = $request->only('api_key');
        $validator =  Validator::make($apiKey, ['api_key' => 'required']);
        if($validator->fails()){
            $response = response()->json(['response_code' => 'ERR_IAK','messages' => 'Invalid Api Key'],403);
            return $response;
        }

        $roleArray = explode('|', $roles);

        $key = Config::get('custom.JWTkey');
        $decoded = JWT::decode($apiKey['api_key'], $key, array('HS256'));
        if(!in_array($decoded->type, $roleArray)){
            $response = response()->json(['response_code' => 'ERR_IAK','messages' => 'Invalid Api Key' ],403 );
            return $response;
        }

        
        $user = User::find($decoded->sub);

        // check the current user
        if (empty($user) || !$user->hasRole($roleArray) || !$user->status ) {
            $response = response()->json(['response_code' => 'ERR_IAK','messages' => 'Invalid Api Key' ],403);
            return $response;
        }

        Auth::onceUsingId($user->id);

        return $next($request);
    }
}
