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

    public function login($credentials,$request){
        if (Auth::attempt($credentials)) {
            session(['email'=>$request->email]);
            Log::channel('custom')->info('Admin logged in',['id'=>Auth::user()->id,'email'=>Auth::user()->email]);
            return true;    
        } else {
           return false;
         }
    }

    public function register($request){
        $emails = $request->email;
        $admin = new AdminUser;
        $emailCheck=AdminUser::select('email')->get();
        foreach($emailCheck as $email){
            if($email->email==$emails){
                return false;
            }
        }
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        Log::channel('custom')->info('Admin has been registered',['id'=>$admin->id,'email'=>$admin->email]);
        return true;
    
    }

    public function dashboard(){
        return AdminCustomer::all();
    }

    public function addPage($id){
        if ($id != null) {
            $customer = AdminCustomer::find($id);
            $url = url('/add') . "/" . $id;
            $title = "Update Customer";
            $info=array(
                // 'customer' => $customer,
                'url' => $url,
                'title' => $title,
            );
            return [$info , $customer];    //try return add;
        } else {
            $url = url('/add');
            $customer = new AdminCustomer();
            $title = "Customer Registration";
            $info=array(
                // 'customer' => $customer,
                'url' => $url,
                'title' => $title,
            );
            return [$info , $customer];    //try return edit; }
    }
}
    public function editStore($id,$request){
        $old=AdminCustomer::find($id);
        $uniqueEmailCheck=AdminCustomer::select('email')
                                        ->where('email','!=',$old->email)
                                        ->get();
        foreach($uniqueEmailCheck as $unique){
            if($request->email==$unique->email){
                return false;
            }
        }
        $hobbies = $request['hobby'];
        $hobby = implode(',', $hobbies);

        $customer = AdminCustomer::find($id);
        if ($request->file('file')) {
            $file = $request->file('file');
            $filename = $file->hashName();
            $location = 'uploads';
            $file->move($location, $filename);
            $filepath = url('uploads/' . $filename);
            $customer->file = $filepath;
        }
        $customer->name = $request['name'];
        $customer->gender = $request['gender'];
        $customer->email = $request['email'];
        $customer->address = $request['address'];
        $customer->blood_group = $request['blood'];
        $customer->hobbies = $hobby;
        $customer->description = $request['description'];
        $customer->save();
        Log::channel('custom')->info('Customer has been edited', ['id' => $customer->id,'email'=>$customer->email]);
        return true;
    }

    public function addStore($request){
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
    public function adminAjaxTable(){
        $customer=AdminCustomer::all();
        return $customer;
    }
    public function trashAjaxTable(){
        $customer= AdminCustomer::onlyTrashed()->get();
        return $customer;
    }
    public function export(){
        Log::channel('custom')->info('Customers information have been exported');
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function import($request){
        try{
            // dd("here");
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