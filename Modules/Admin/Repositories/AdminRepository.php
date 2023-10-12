<?php

namespace Modules\Admin\Repositories;

use Modules\Admin\Entities\AdminUser;
use Modules\Admin\Entities\AdminCustomer;
use Illuminate\Session\Store;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Parents;
use App\Models\Child;

class AdminRepository{
    public function __construct(){
    }

    public function login($request){
        $user = AdminUser::where('email',$request->email)
                        ->first();

        if($user){
            if (Hash::check($request->password, $user->password)) {
                session(['email'=>$request->email]);
                Log::channel('custom')->info('Admin logged in',['id'=>$user->id,'email'=>$user->email]);
                return true;
            } else {
                return false;
            
            }
        }
        return false;
    }

    public function register($request){
        $email=AdminUser::where('email',$request->email)->exists();
        if($email){
            return false;
        }

        $admin = new AdminUser;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        Log::channel('custom')->info('Admin has been registered',['id'=>$admin->id,'email'=>$admin->email]);
        return true;
    
    }

    public function edit($id,$req){
        $old=AdminCustomer::find($id);
        $uniqueEmailCheck=AdminCustomer::select('email')
                                        ->where('email','!=',$old->email)
                                        ->get();
        if($uniqueEmailCheck){
            foreach($uniqueEmailCheck as $unique){
                if($req->email==$unique->email){
                    return false;
                }
            }
        }
        $hobbies = $req['hobby'];
        $hobby = implode(',', $hobbies);

        $customer = AdminCustomer::find($id);
        if ($req->file('file')) {
            $file = $req->file('file');
            $filename = $file->hashName();
            $location = 'uploads';
            $file->move($location, $filename);
            $filepath = url('uploads/' . $filename);
            $customer->file = $filepath;
        }
        $customer->name = $req['name'];
        $customer->gender = $req['gender'];
        $customer->email = $req['email'];
        $customer->address = $req['address'];
        $customer->blood_group = $req['blood'];
        $customer->hobbies = $hobby;
        $customer->description = $req['description'];
        $customer->save();
        Log::channel('custom')->info('Customer has been edited', ['id' => $customer->id,'email'=>$customer->email]);
        return true;
    }

    public function add($request){
        $selects = $request['hobby'];
        $hobby = implode(",", $selects);

        $customer = new AdminCustomer;
        if ($request->file('file')) {
            $file = $request->file('file');
            $filename = $file->hashName();
            $location = 'uploads';
            $file->move($location, $filename);
            $filepath = url('uploads/' . $filename);
            $customer->file = $filepath;
        }
        $customer->name = $request['name'];
        $customer->email = $request['email'];
        $customer->gender = $request['gender'];
        $customer->address = $request['address'];
        $customer->description = $request['description'];
        $customer->blood_group = $request['blood'];
        $customer->hobbies = $hobby;
        $customer->save();
        Log::channel('custom')->info('Customer has been added',['id'=>$customer->id,'email'=>$customer->email]);
        return true;
    }

    public function delete($id){
        $customer = AdminCustomer::find($id);
        Log::channel('custom')->info('Customer has been soft deleted',['id'=>$customer->id,'email'=>$customer->email]);
        $customer->delete();
        return true;
    }

    public function trash(){
        return AdminCustomer::onlyTrashed()->get();
    }
   
    public function restore($id){
        $customer = AdminCustomer::withTrashed()->find($id);
        $customer->restore();
        Log::channel('custom')->info('Customer has been restored',['id'=>$customer->id,'email'=>$customer->email]);
        return true;
    }
    public function deleteForced($id){
        $customer = AdminCustomer::withTrashed()->find($id);
        $customer->forceDelete();
        Log::channel('custom')->info('Customer has been permanently deleted',['id'=>$customer->id,'email'=>$customer->email]);
        return true;
    }

    public function import($request){
        try{
            Excel::import(new UsersImport, $request->file('file'));
        }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
            $failures = $e->failures();
     
    //  foreach ($failures as $failure) {
    //      $failure->row(); // row that went wrong
    //      $failure->attribute(); // either heading key (if using heading row concern) or column index
    //      $failure->errors(); // Actual error messages from Laravel validator
    //      $failure->values(); // The values of the row that has failed.
    //  }
            // dump("error caught");
            // return redirect('/dashboard')->with('importError', 'Fail to upload. As file has empty values where there needs data');
        }
        Log::channel('custom')->info('Customers have been added through excel');
        // Excel::import(new UsersImport, $request->file('file')->store('files'));
        return true;
    }
}