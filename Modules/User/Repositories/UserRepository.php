<?php

namespace Modules\User\Repositories;
use Tymon\JWTAuth\Facades\JWTAuth;
use Modules\User\Entities\EndUser;
use Illuminate\Support\Facades\Hash;
use App\Http\Helper\ResponseCode;

class UserRepository{
    
    public function register($userInfo){
        $user = new EndUser;
        $user->name = $userInfo['name'];
        $user->email = $userInfo['email'];
        $user->password = Hash::make($userInfo['password']);
        $user->save();
        if ($user) {
            return ResponseCode::successMessage("User created successfully");
        } else {
            return ResponseCode::errorMessage("Internal issues found");
        }
    }

    public function login($request){
        // $token=JWTAuth::parseToken();
        // return response()->json(JWTAuth::authenticate($token));
        // $id=JWTAuth::getPayload($token)->get('sub');
        // $user=User::find($id);
        // return response(JWTAuth::toUser($token));  //get  current user
        // return response(JWTAuth::fromUser($user));  //get token of current user
        // return response()->json($token);

        $customer = EndUser::where('email',$request->email)->first();
        if($customer){
            if(Hash::check($request->password,$customer->password)){
                if ($token = JWTAuth::fromUser($customer)) {
                    $data = [
                        'message'   => 'Login Successful',
                        'token'     => $token
                    ];
                    return $data;
                }
                $data = ['message' => 'Token not created'];
                return $data;
            }
        }
        $data = [
            'message' => 'Invalid email or password'
        ];
        return $data;
    }

    public function changePassword($user){
        $token = JWTAuth::getToken();
        $id = JWTAuth::getPayload($token)->get('sub');
        // $userInfo=Queries::showPassword($id);
        $userInfo = EndUser::find($id);
        // return $userInfo;

        if (Hash::check($user['new_password'], $userInfo->password)) {
            $data = [
                'message'   => 'Old password cant be new password!!',
            ];
            return $data;
        }
        if ($user['confirmed_password'] != $user['new_password']) {
            return ResponseCode::errorMessageClient("Confirmed and new password doesnt match!!");
        }


        $check = Queries::changePassword($id, $user);
        if (!$check) {
            return ResponseCode::notFound();
        }
        return ResponseCode::successMessage("Password changed successfully");
    }
}