<?php

namespace App\Entities;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class Queries
{
    public static function showFirstEmail()
    {
        // return User::select('email')->orderBy('id')->first();
        return User::select('email')->where('email', '=', 'asd@gmail.com')->first();
    }
    public static function showPassword($id){
        $user=User::find($id);
        return $user;
    }
    public static function showAll()
    {
        return User::all();
    }
    public static function create($userInfo)
    {
       
        return true;
    }
    // public static function showUser($id)
    // {
    //     return User::find($id);
    // }
    public static function updateUser($id, $userInfo)
    {
        $user = User::find($id);
        if ($user != null) {
            $user->name = $userInfo['name'];
            $user->email = $userInfo['email'];
            $user->save();
            return true;
        }
        return false;
    }
    public static function delete($id)
    {
        $user = User::find($id);
        try {
            $user->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public static function changePassword($id, $user)
    {
        $user = User::find($id);
        if ($user != null) {
            $user->password = Hash::make($user['new_password']);
            $user->save();
            return true;
        }
        return false;
    }
}
