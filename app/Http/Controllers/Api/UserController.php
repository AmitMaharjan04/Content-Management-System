<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Crypt;
use App\Entities\Queries;
use App\Http\Helper\ResponseCode;
use App\Http\Helpers\ResponseCode as HelpersResponseCode;
use App\Repositories\Repository;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public  $username;
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login']]);
    }
    public function index(Request $request)
    {
        // $response=Repository::showAll($request);
        // return response()->json($response);
        $token=JWTAuth::parseToken();
        return response()->json(JWTAuth::authenticate($token));
        $id=JWTAuth::getPayload($token)->get('sub');
        $user=User::find($id);
        return response(JWTAuth::toUser($token));  //get  current user
        return response(JWTAuth::fromUser($user));  //get token of current user
        return response()->json($token);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required']
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $user=[
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        $response=Repository::register($user);
        return response()->json($response);
    }
    // protected function respondWithToken($token)
    // {
    //     // $token = JWTAuth::parseToken()->getToken();

    //     // // Get the payload data
    //     // $payload = JWTAuth::decode($token)->payload();

    //     // // Get all the data from the payload as an array
    //     // $data = $payload->toArray();
    //     // return response()->json([
    //     //     'message' => $data,
    //     // ], 200);
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60,
    //         'status' => 1
    //     ]);
    // }
    public function login(Request $request)
    {
        // $response=new ResponseCode;
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if ($validator->fails()) {
            // $result=$response->errorMessageClient($validator->messages());
            // return response()->json($result);
            return response()->json($validator->messages());
        }
        // $credentials = $request->only('email', 'password');
        // $obj=new Repository;
        // $test=$obj->login($request);
        // if(!$test){
        //     return response()->json('Incorrect Email or Password');
        // }
        // return response()->json('Login successful');


        $credentials = $request->only('email', 'password');
        if($token=Auth::attempt($credentials)){
            return response()->json([
                'msg' =>'login successful',
                'token' => $token,
            ]);
        }else{
            return response()->json("invalid credentials");
        }
        // $response=Repository::login($credentials);
        // return response()->json($response);
        // //start
        // if (!$token = JWTAuth::attempt($credentials)) {
        //     return response()->json(['Error' => 'Incorrect email or password'], 400);
        // }

        // // $user = JWTAuth::user();
        // // $payload = [
        // //     'sub' => $user->id,
        // //     'name' => $user->name,
        // //     'email' => $user->email,
        // // ];
        //     $token=JWTAuth::claims(['foo'=>'bar'])->attempt($credentials);;
        // // Generate the JWT token with the user information
        // // $token = JWTAuth::claims($payload)->attempt($credentials);
        // // $token=Crypt::encryptString($token);
        // return response()->json($token,201);
        // //end


        // $credentials = $request->only('email', 'password');
        // try {
        //     if (!$token = JWTAuth::attempt($credentials)) {
        //         // if (!$token = auth()->attempt($credentials)) {
        //         return response()->json([
        //             'message' => 'Invalid credentials',
        //             'status' => 0,
        //         ], 401);
        //     }
        // } catch (JWTException $e) {
        //     return response()->json([
        //         'message' => 'Could not create token',
        //         'status' => 0
        //     ], 500);
        // }
        // // return response()->json([
        // //     'message' => $token,
        // // ], 401);
        // return $this->respondWithToken($token);
        // return response()->json($credentials);
        // return response()->json([
        //     'token' => $token,
        //     'status' => 1
        // ], 200);

        // $validator = Validator::make($request->all(), [
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);
        // if ($validator->fails()) {
        //     return response()->json($validator->messages(), 400);
        // } else {
        //     // $user=User::where();
        //     $user = User::where('email', $request['email'])->first();
        //     if($user!=null){
        //         if ($user && Hash::check($request['password'], $user->password)) {
        //             // $token = $user->createToken("auth_token")->accessToken;

        //             // $this->username=$user->name;
        //             return response()->json([
        //                 // 'token' => $token,
        //                 // 'name' => $username,
        //                 'message' => "logged in successfully",
        //                 'user' => $user
        //             ]);
        //         } else {
        //             // User credentials are invalid
        //             return response()->json(['message' => 'Invalid credentials'], 401);
        //         }
        //     }
        //     else{
        //         return response()->json(['message' => 'Invalid credentials'], 401);
        //     }

        // }
    }
    public function logout()
    {
        $response=Repository::logout();
        return response()->json($response);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id,Request $request)
    {
        //show current datas in payload of token

        // $payload = auth()->payload();
        // $name=$payload->get('name'); 
        // $email=$payload['email']; 
        // $expiry=$payload('exp');  
        // return response()->json([
        //     'name'=>$name,
        //     'email '=>$email,
        //     'expiry time'=>$expiry,
        // ]);
        $response=Repository::showUserInfo($request,$id);
        return response()->json($response);
        //this is how u check issuer legit?
        // $issuer = JWTAuth::getPayload($token)->get('iss');
        // if($issuer!="http://127.0.0.1:8000/api/login"){
        $token = JWTAuth::parseToken()->getToken();

        // Decode the token and get the user information from the payload
        // $user = JWTAuth::decode($token->get())->getClaim('name');
        $payload = JWTAuth::decode($token)->payload();

        // Get all the data from the payload as an array
        $data = $payload->toArray();
        return response()->json([
            'message' => $data,
        ], 200);
        return response()->json(compact('user'));

        // $user2 = auth()->user();

        // return response()->json([
        //     'msg' => $user2,
        // ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $user=[
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        
        $response=Repository::update($request,$id);

        // $response=Repository::update($user);
        return response()->json($response);
        $user = User::find($id);
        // return response()->json($user);
        // if ($user == null) {
        //     return response()->json([
        //         'message' => 'User doesnt exist',
        //         'status' => 0
        //     ], 200);
        // } else {
        //     $user->name = $request->name;
        //     $user->email = $request->email;
        //     $user->save();
        //     // return response()->json([
        //     //     'message' => $request->name,
        //     //     'status' => $request->email
        //     // ], 200);

        //     return response()->json([
        //         'message' => 'User updated successfully',
        //         'status' => 1
        //     ], 200);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $response=Repository::delete();
        return response()->json($response);
        // $user=User::find($id);
        // if(is_null($user)){
        //     $response=[
        //         'message' => 'user doesnt exist',
        //         'status'=> 0
        //     ];
        //     $resCode=400;
        // }else{
        //     DB::beginTransaction();
        //     try{
        //          $user->delete();
        //          DB::commit();
        //          $response =[
        //             'message'=> 'user deleted successfully',
        //             'status' => 1
        //          ];   
        //          $resCode=200;
        //     }catch(\Exception $e){
        //         DB::rollBack();
        //         $response =[
        //             'message'=> 'internal server issue',
        //             'status' => 0
        //          ];   
        //     }
        //     // return response()->json([
        //     //     'message' => 'user doesnt exist',
        //     //     'status'=> 0
        //     // ],400);
        // }
        // return response()->json($response, $resCode);
    }
    public function changePassword(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => ['required'],
            'confirmed_password' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $user=[
            'new_password'=>$request->new_password,
            'confirmed_password'=>$request->confirmed_password,
        ];

        $response=Repository::changePassword($user);
        return response()->json($response);
        // return response()->json($response->password);
        // $user = User::find($id);
        // if (is_null($user)) {
        //     return response()->json([
        //         'message' => 'User doesnt exist',
        //         'status' => 0
        //     ], 404);
        // } else {
        //     // return response()->json($request->old_password);
        //     // if($user->password == $request['old_password']){
        //     if (Hash::check($request['old_password'], $user->password)) {
        //         if ($request['new_password'] == $request['confirmed_password']) {
                 
        //             $user->password = Hash::make($request->new_password);
        //             $user->save();
        //             return response()->json([
        //                 'message' => 'Password changed succesfully',
        //                 'status' => 0
        //             ], 200);
        //         } else {
        //             return response()->json([
        //                 'message' => 'New password and confirmed password doesnt match',
        //                 'status' => 0
        //             ], 400);
        //         }
        //     } else {
        //         return response()->json([
        //             'message' => 'Old Password doesnt match succesfully',
        //             'status' => 0
        //         ], 400);
        //     }

        // }
    }
}
    /*public function createBlog(Request $request){
        $user_id = auth()->guard('api')->user()->name;
        // $data = DB::table('users')->where('id', $user_id)->get();
        // $users=DB::table('users')
        // ->select('users.name')
        // ->join('oauth_access_tokens', 'users.id', '=', 'oauth_access_tokens.user_id')
        // // ->where('oauth_access_tokens.id', '=', `$hashedToken`)
        // ->where('oauth_access_tokens.user_id', '=', `$user_id`)
        // ->get();
        return response()->json([
            "message" => $user_id
        ]);

/*
    $token=$request->header('Authorization');
    // $hashedToken=hash('sha256', $token);
    $accessToken = DB::select('SELECT id FROM oauth_access_tokens');
    // return response()->json([
    //     "message"=>$accessToken
    // ]);
    // $hashedToken=[];
    foreach($accessToken as $accessToken1){
        $hashedToken = decrypt($accessToken1);
    }
*/
    /*$token=$request->header('Authorization');
    // $hash=hash::make($token);
    // $hash=hash('sha256', $token);
    $accessToken = DB::select('SELECT id FROM oauth_access_tokens where id=1');
    $hash="";
    // foreach($accessToken as $value){
    // $hash=decrypt($value);
    // }
    return response()->json([
        // "message" => $hashedToken,
        "header" => $token,
        "message" => decrypt($accessToken)
    ]);
    for($i=1;$i<=count($hashedToken);$i++){
        if($hashedToken!=$token){
            return response()->json([
                        "message" => "invalid user"
                    ]);
        }
        else{
            $users=DB::table('users')
        ->select('users.name')
        ->join('oauth_access_tokens', 'users.id', '=', 'oauth_access_tokens.user_id')
        ->where('oauth_access_tokens.id', '=', `$hashedToken`)
        ->get();
            return response()->json([
                "message" => $users
            ]);
        }
    }
    }*/
// }
