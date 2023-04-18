<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class RefreshToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    { 
        $token=JWTAuth::getToken();
        // $token=Crypt::decryptString($token);
        if($token){
            // return  $next($request);
            $mins=JWTAuth::getPayload($token)->get('exp') - time();
            // $test=JWTAuth::getPayload($token)->get('foo');
            // $newToken = auth()->refresh(false,true);
            // return response()->json([
            //     'time'=>getType($mins),
            //     'test'=>getType($test),
            //     'testasd'=>getType($newToken),
            // ]);
            
            // $new=compact($token,$newToken);
            if($mins<90){
                $newToken = auth()->refresh(false,true);
                return response()->json([
                    'new token' => $newToken,
                    'old token' => 'Old token has expired',
                ]);
                return  $next($request);
            }
            else{
                return  $next($request);
            }
        }
        else{
            return response()->json(["Error"=>"Token expired"]);
        }
        
        // // Pass true as the first param to force the token to be blacklisted "forever".
        // // The second parameter will reset the claims for the new token
        // $newToken = auth()->refresh(false,true);

        // try
        // {
        //     if (! $user = JWTAuth::parseToken()->authenticate() )
        //     {
        //          return response()->json([
        //            'code'   => 101 // means auth error in the api,
        //            'response' => null // nothing to show 
        //          ]);
        //     }
        // }
        // catch (TokenExpiredException $e)
        // {
        //     // If the token is expired, then it will be refreshed and added to the headers
        //     try
        //     {
        //         $refreshed = JWTAuth::refresh(JWTAuth::getToken());
        //         $user = JWTAuth::setToken($refreshed)->toUser();
        //         header('Authorization: Bearer ' . $refreshed);
        //     }
        //     catch (JWTException $e)
        //     {
        //          return response()->json([
        //            'code'   => 103 // means not refreshable 
        //            'response' => null // nothing to show 
        //          ]);
        //     }
        // }
        // catch (JWTException $e)
        // {
        //     return response()->json([
        //            'code'   => 101 // means auth error in the api,
        //            'response' => null // nothing to show 
        //     ]);
        // }

        // // Login the user instance for global usage
        // Auth::login($user, false);
        // return  $next($request);
    }
}
