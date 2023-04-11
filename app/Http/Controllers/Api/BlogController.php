<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;

class BlogController extends Controller
{
    public function createBlog(Request $request){
        $user_name = auth()->guard('api')->user()->name;
        // $data = DB::table('users')->where('id', $user_id)->get();
        // $users=DB::table('users')
        // ->select('users.name')
        // ->join('oauth_access_tokens', 'users.id', '=', 'oauth_access_tokens.user_id')
        // // ->where('oauth_access_tokens.id', '=', `$hashedToken`)
        // ->where('oauth_access_tokens.user_id', '=', `$user_id`)
        // ->get();
        // return response()->json([
        //     "message" => $user_id
        // ]);
        // $validator=Validator::make($request->all(),[
        //     'description'=> ['required'],
        // ]);
        // if($validator->fails()){
        //     return response()->json($validator->messages(),400);
        // }
        // else{
            $desc=$request->description;
            
            $data=[
                'name' => $user_name,
                'description' => $desc,
            ];
            
            DB::beginTransaction();
            try{
                $user = Blog::create($data);
                DB::commit();
            }catch(\Exception $e){ 
                DB::rollback();
                // p($e->getMessage());
                $user=null;
            }
            if($user!=null){
                return response()->json([
                    'name' =>$user->name,
                    'message' => "Blog added successfully",
                    'description' =>$user->description
                ],200);
            }
            else{
                return response()->json([
                    'message'=>'Internal issues found'
                ],500);
            }
        // }
    }
}
