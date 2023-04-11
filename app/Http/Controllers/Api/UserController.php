<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Illuminate\Encryption\Encrypter;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public  $username;
    public function index()
    {
        $users= User::all();
        if(count($users)>0){
            return response()->json([
                'message'=> count($users) . '  '. 'found',
                'data' => $users
            ], 200);
        }else{
            return response()->json([
                'message'=> count($users) . '  '. 'found'
            ],200);
        }
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
        $validator=Validator::make($request->all(),[
            'name'=> ['required'],
            'email' => ['required','email','unique:users,email'],
            'password' =>['required','confirmed','min:8'],
            'password_confirmation' => ['required']
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }
        else{

            $data=[
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password) 
            ];
            DB::beginTransaction();
            try{
                $user = User::create($data);
                $token=$user->createToken("auth_token")->accessToken;
                DB::commit();
            }catch(\Exception $e){ 
                DB::rollback();
                // p($e->getMessage());
                $user=null;
            }
            if($user!=null){
                return response()->json([
                    'token' => $token,
                    'name' =>$user->name,
                    'message' => "User created successfully"
                ],200);
            }
            else{
                return response()->json([
                    'message'=>'Internal issues found'
                ],500);
            }
        }
        
    }

    public function login(Request $request){
        $validator=Validator::make($request->all(),[
            'email' => ['required','email'],
            'password' =>['required'],
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }
        else{
            $user = User::where('email', $request['email'])->first();

    if ($user && Hash::check($request['password'], $user->password)) {
        // User credentials are valid
        $token=$user->createToken("auth_token")->accessToken;
        // $this->username=$user->name;
        return response()->json([
            'token' => $token,
            // 'name' => $username,
            'message' => "logged in successfully",
            'user' => $user]);
            
    } else {
        // User credentials are invalid
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

            
        }
    }   
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user=User::find($id);
    
        if(!is_null($user)){
            return response()->json([
                'message'=>'user found',
                'status'=>'1',
                'data' => $user
            ],200);
        }else{
            return response()->json([
            'message'=>'user not found',
            'status'=>'0'
            ],400);
        }
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
        $user=User::find($id);
        if(is_null($user)){
            return response()->json([
                'message'=>'User doesnt exist',
                'status'=>0
            ],200);
        }else{
            DB::beginTransaction();
            try{
                $user->name=$request['name'];
                $user->email=$request['email'];
                $user->save();
                DB::commit();
            }catch(\Exception $e){
                DB::rollBack();
               $user=null;
            }
            if(is_null($user)){
                return response()->json([
                    'message'=>'Internal server issue',
                    'status'=>0,
                    'error' => $e->getMessage()
                ],500);
            }
            else{
                return response()->json([
                    'message'=>'User updated successfully',
                    'status'=>1
                ],200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        return response()->json([
            'user'=>$request['name']
        ]);
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
    public function changePassword(Request $request,string $id){
        $user=User::find($id);
        if(is_null($user)){
            return response()->json([
                'message'=>'User doesnt exist',
                'status'=>0
            ],404);
        }
        else{
            // if($user->password == $request['old_password']){
                if (Hash::check($request['old_password'], $user->password)) {
                    if($request['new_password'] == $request['confirmed_password']){
                        DB::beginTransaction();
                        try{
                            $user->password=Hash::make($request['new_password']);
                            $user->save();
                            DB::commit();
                        }catch(\Exception $e){
                            DB::rollBack();
                            $user=null;
                        }
                        // return response()->json([
                        //     'message'=>'Password and confirm  match succesfully',
                        //     'status'=>0
                        // ],200);
                    }else{
                        return response()->json([
                            'message'=>'New password and confirmed password doesnt match',
                            'status'=>0
                        ],400);
                    }
                }
                else{
                    return response()->json([
                        'message'=>'Old Password doesnt match succesfully',
                        'status'=>0
                    ],400);
                }
                // if($request['new_password'] == $request['confirmed_password']){
                //     // DB::beginTransaction();
                //     // try{
                //     //     $user->password=$request['new_password'];
                //     //     $user->save();
                //     //     DB::commit();
                //     // }catch(\Exception $e){
                //     //     DB::rollBack();
                //     //     $user=null;
                //     // }
                //     return response()->json([
                //         'message'=>'Password and confirm  match succesfully',
                //         'status'=>0
                //     ],200);
                // }else{
                //     return response()->json([
                //         'message'=>'New password and confirmed password doesnt match',
                //         'status'=>0
                //     ],400);
                // }
            // }else{
            //     return response()->json([
            //         'message'=>'Old Password is incorrect',
            //         'status'=>0
            //     ],400);
            // }
            
        }
        if(is_null($user)){
            return response()->json([
                'message'=>'Internal server issue',
                'status'=>0
                // 'error' => $e->getMessage()
            ],500);
        }
        else{
            return response()->json([
                'message'=>'User updated successfully',
                'status'=>1
            ],200);
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

}
