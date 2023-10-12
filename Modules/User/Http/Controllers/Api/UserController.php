<?php

namespace Modules\User\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\Entities\EndUser;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Helper\ResponseCode;
use App\Repositories\Repository;
use Modules\User\Repositories\UserRepository;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public  $username;
    private $userRepo, $response;
    public function __construct()
    {
        $this->userRepo = new UserRepository;
        $this->response = new ResponseCode;
    }
    public function index(Request $request)
    {
        // $response=Repository::showAll($request);
        // return response()->json($response);
        $token=JWTAuth::parseToken();
        return response()->json(JWTAuth::authenticate($token));
        $id=JWTAuth::getPayload($token)->get('sub');
        $user=EndUser::find($id);
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
            'password' => ['required', 'confirmed', 'min:5'],
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
        $response = $this->userRepo->register($user);
        return response()->json($response);
        $response=Repository::register($user);
        return response()->json($response);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $result = $this->userRepo->login($request);
        return response()->json($result);
        // $credentials = $request->only('email', 'password');
        // if($token=Auth::attempt($credentials)){
        //     return response()->json([
        //         'msg' =>'login successful',
        //         'token' => $token,
        //     ]);
        // }
    }
    public function logout()
    {
        try {
            auth()->logout();
            $response = ResponseCode::successMessage("Logout successful");
        } catch (Exception $e) {
            $response = ResponseCode::errorMessage("Failure to logout");
        }
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
        $user = EndUser::find($id);
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
    }

    public function changePassword(Request $request, string $id)
    {
        dd("aa");
        $validator = Validator::make($request->all(), [
            'new_password' => ['required'],
            'new_password_confirmation' => ['required', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        dd("asd");
        $user=[
            'new_password'=>$request->new_password,
            'confirmed_password'=>$request->confirmed_password,
        ];
        $response = $this->userRepo->changePassword($user);
        $response=Repository::changePassword($user);

        

        return response()->json($response);
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
