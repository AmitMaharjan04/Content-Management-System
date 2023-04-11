<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // return $request->expectsJson() ? null : route('login');
        // return url('/');
            dump("middleware rejected");
            
            // dump(Auth::user());
            // dd(Auth::check());
            // $users=User::pluck('email');
            dump($request->session()->all());
            dd(session()->get('name'));
        // $email=$request->session()->get('name');
        // foreach($users as $user){
        //     if($user==$email){
        //         return redirect('/dashboard');
        //     }
        // }
        // return url('/');
        // return $request->expectsJson() ? null : url('/');
    }
    
}
