<?php

namespace App\Repositories;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Entities\Queries;
use App\Http\Helper\ResponseCode;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Hash;

class Repository
{
    public static function register($user)
    {

        $user = Queries::create($user);
        if ($user) {
            return ResponseCode::successMessage("User created successfully");
        } else {
            return ResponseCode::errorMessage("Internal issues found");
        }
    }

    public static function login($credentials)
    {
        $obj = new ResponseCode();
        if (!$token = JWTAuth::attempt($credentials)) {

            return $obj->loginFailure("Incorrect Email or Password");
        }
        return $obj->loginSuccessful("Login Successful", $token);
    }

    public static function logout()
    {
        try {
            auth()->logout();
            return ResponseCode::successMessage("Logout successful");
        } catch (Exception $e) {
            return ResponseCode::errorMessage("Failure to logout");
        }
    }

    public static function showUserInfo()
    {
        $token = JWTAuth::getToken();
        $mins = JWTAuth::getPayload($token)->get('exp') - time();
        $id = JWTAuth::getPayload($token)->get('sub');
        $user = Queries::showUser($id);
        $totalUser = 1;
        if (!is_null($user)) {
            return ResponseCode::getData($user, $totalUser, $mins);
        } else {
            return ResponseCode::notFound();
        }
    }

    public static function showAll()
    {
        $token = JWTAuth::getToken();
        $currentUser = JWTAuth::user();
        $superAdmin = Queries::showFirstEmail();
        if ($currentUser->email == $superAdmin->email) {
            $users = Queries::showAll();
            if (count($users) > 0) {
                $seconds = JWTAuth::getPayload($token)->get('exp') - time();
                $response = ResponseCode::getData($users, count($users), $seconds);
                return $response;
            } else {
                $response = ResponseCode::notFound();
                return $response;
            }
        } else {
            $response = ResponseCode::forbidden("nah u not the one");
            return $response;
        }
    }

    public static function update($user)
    {
        $token = JWTAuth::getToken();
        $id = JWTAuth::getPayload($token)->get('sub');
        $userCheck = Queries::updateUser($id, $user);
        if ($userCheck) {
            return ResponseCode::successMessage("User updated successfully");
        } else {
            return ResponseCode::notFound();
        }
    }

    public static function delete()
    {
        $token = JWTAuth::getToken();
        $id = JWTAuth::getPayload($token)->get('sub');
        $check = Queries::delete($id);
        if ($check) {
            return ResponseCode::successMessage("User successfully deleted");
        }
        return ResponseCode::notFound();
    }
    public static function changePassword($user)
    {
        $token = JWTAuth::getToken();
        $id = JWTAuth::getPayload($token)->get('sub');
        // $userInfo=Queries::showPassword($id);
        $userInfo=Queries::showUser($id);
        // return $userInfo;

        if (Hash::check($user['new_password'],$userInfo->password)) {
            return ResponseCode::errorMessageClient("Old password cant be new password!!");
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
