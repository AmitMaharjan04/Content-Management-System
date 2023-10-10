<?php

namespace App\Http\Controllers;

use Illuminate\Session\Store;
use Illuminate\Http\Request;
use App\Models\AdminLogin;
use App\Models\AdminCustomer;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Session\Session as SessionSession;
use Session;
use Illuminate\Support\Facades\Log;
use App\Models\Parents;
use App\Models\Child;
use App\Repositories\AdminRepository;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{

    public function index()
    {
        // $parent=Child::all()->join('parents','childs.emp_id','=','parents.emp_id')->where('emp_id','=','1')->where('iops','=','123');
        // dd($parent);
        return view('admin_login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $repo=new AdminRepository;
        $check=$repo->login($credentials,$request);
        if(!$check){
            return redirect('/dashboard')->with('success','Logged in successfully');
        }else{
            return redirect()->back()->with('error','Invalid email or password');
       }

        // if (Auth::attempt($credentials)) {
        //     session(['email'=>$request->email]);
        //     Log::channel('custom')->info('Admin logged in',['id'=>Auth::user()->id,'email'=>Auth::user()->email]);
        //     return redirect('/dashboard')->with('success','Logged in successfully');
        // } else {
        //     return redirect()->back()->with('error','Invalid email or password');
        // }
    }
    public function register()
    {
        return view('admin_register');
    }
    public function registerStore(Request $request)
    {
        $request->validate([
            'email' => ['required ', 'email', 'regex:/\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+/'],
            'password' => ['required ','min:5', ' max:30','regex:/[A-Za-z]{1,}[0-9]{1,}[!@#$%\^\-\.]{1,}/']
        ], [
            'email.regex' => 'Please enter a valid email address.',
            'password.regex' => 'Password must contain alpabets,number and alphanumeric keys.',
        ]);
            $repo=new AdminRepository;
        $check=$repo->register($request);
    if(!$check){
        return redirect()->back()->with('email','Email already registered.');
           
    }
    return redirect('/')->with('success','User registered successfully');
 
        // $emails = $request->email;
        // $admin = new AdminLogin;
        // $emailCheck=AdminLogin::select('email')->get();
        // foreach($emailCheck as $email){
        //     if($email->email==$emails){
        //         return redirect()->back()->with('email','Email already registered.');
        //     }
        // }
        // $admin->email = $request->email;
        // $admin->password = Hash::make($request->password);
        // $admin->save();

        // Log::channel('custom')->info('Admin has been registered',['id'=>$admin->id,'email'=>$admin->email]);
        // return redirect('/')->with('success','User registered successfully');
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
    public function dashboard(Request $request)
    {
            $repo=new AdminRepository;
        $customer=$repo->dashboard();
        return view('admin_dashboard',compact('customer'));

        // $customer = AdminCustomer::all();
        // return view('admin_dashboard',compact('customer'));

    }
    public function adminAjaxTable(){
        $repo=new AdminRepository;
        $result=$repo->adminAjaxTable();
        // dd(Datatables::of($result)->make(true));
        return Datatables::of($result)->make(true);
    }
    public function trashAjaxTable(){
        $repo=new AdminRepository;
        $result=$repo->trashAjaxTable();
        // dd(Datatables::of($result)->make(true));
        return Datatables::of($result)->make(true);
    }
    public function add($id = null)
    {
            $repo=new AdminRepository;
            list($info, $customer)=$repo->addPage($id);//info is array and customer is object
            return view('admin_add', compact('info','customer'));

    // return view('admin_add', compact('url', 'title', 'customer'));
        
        // if ($id != null) {
        //     $customer = AdminCustomer::find($id);
        //     $url = url('/add') . "/" . $id;
        //     $title = "Update Customer";
        //     return view('admin_add', compact('url', 'title', 'customer'));
        // } else {
        //     $url = url('/add');
        //     $customer = new AdminCustomer();
        //     $title = "Customer Registration";
        //     return view('admin_add', compact('url', 'title', 'customer'));
        // }
    }
    public function editStore($id, Request $req)
    {   
        $req->validate([
            'name' => ['required', ' min:3', ' max:30'],
            'email' => ['required ', 'email', 'regex:/\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+/'],
            'address' => ['required', 'max:50'],
            'description' => ['required', 'max:50'],
            'hobby' => ['required'],
        ], [
            'email.regex' => 'Please enter a valid email address.'
        ]);
        $repo=new AdminRepository;
        $check=$repo->editStore($id,$req);
        if(!$check){
            return redirect()->back()->with('aerror','Email already registered.Choose new email');
        }
        return redirect('/dashboard')->with('edit','Customer edited successfully');
    
        
        // $old=AdminCustomer::find($id);//this should be below validate
        // $uniqueEmailCheck=AdminCustomer::select('email')
        //                                 ->where('email','!=',$old->email)
        //                                 ->get();
        // foreach($uniqueEmailCheck as $unique){
        //     if($req->email==$unique->email){
        //         return redirect()->back()->with('aerror','Email already registered.Choose new email');
        //     }
        // }
        // $hobby = implode(',', $hobbies);

        // $customer = AdminCustomer::find($id);
        // if ($req->file('file')) {
        //     $file = $req->file('file');
        //     $filename = $file->hashName();
        //     $location = 'uploads';
        //     $file->move($location, $filename);
        //     $filepath = url('uploads/' . $filename);
        //     $customer->file = $filepath;
        // }
        // $customer->name = $req['name'];
        // $customer->gender = $req['gender'];
        // $customer->email = $req['email'];
        // $customer->address = $req['address'];
        // $customer->blood_group = $req['blood'];
        // $customer->hobbies = $hobby;
        // $customer->description = $req['description'];
        // $customer->save();
        // Log::channel('custom')->info('Customer has been edited', ['id' => $customer->id,'email'=>$customer->email]);
        // return redirect('/dashboard')->with('edit','Customer edited successfully');
    }
    public function store(Request $request)
    {
          $request->validate([
            'name' => 'required | min:3 | max:30',
            'email' => 'required | email  | unique:admin_customers,email',
            'address' => 'required | max:50',
            'description' => 'required | max:100',
            'hobby' => 'required',
        ]);

        $repo=new AdminRepository;
        $check=$repo->addStore($request);
        if(!$check){
            
         }
        return redirect('/dashboard')->with('add','Customer added successfully');
       
          
        // $selects = $request['hobby'];
        // $hobby = implode(",", $selects);

        // $customer = new AdminCustomer;
        // if ($request->file('file')) {
        //     $file = $request->file('file');
        //     $filename = $file->hashName();
        //     $location = 'uploads';
        //     $file->move($location, $filename);
        //     $filepath = url('uploads/' . $filename);
        //     $customer->file = $filepath;
        // }
        // $customer->name = $request['name'];
        // $customer->email = $request['email'];
        // $customer->gender = $request['gender'];
        // $customer->address = $request['address'];
        // $customer->description = $request['description'];
        // $customer->blood_group = $request['blood'];
        // $customer->hobbies = $hobby;
        // $customer->save();
        // Log::channel('custom')->info('Customer has been added',['id'=>$customer->id,'email'=>$customer->email]);
        // return redirect('/dashboard')->with('add','Customer added successfully');
    }

    public function delete($id)
    {
        $repo=new AdminRepository;
        $repo->delete($id);
        return redirect('/dashboard')->with('softDelete','Customer deleted temporarily');
   
        // $customer = AdminCustomer::find($id);
        // Log::channel('custom')->info('Customer has been soft deleted',['id'=>$customer->id,'email'=>$customer->email]);
        // $customer->delete();
        // return redirect('/dashboard')->with('softDelete','Customer deleted temporarily');
    }
    public function trash()
    {
        $repo=new AdminRepository;
        $customer=$repo->trash();
        return view('admin_trash',compact('customer'));
   
        // $customer = AdminCustomer::onlyTrashed()->get();
        // return view('admin_trash',compact('customer'));
    }
    public function restore($id)
    {
        $repo=new AdminRepository;
        $repo->restore($id);
         return redirect('/dashboard')->with('restore','Customer restored successfully');
   
        // $customer = AdminCustomer::withTrashed()->find($id);
        // $customer->restore();
        // Log::channel('custom')->info('Customer has been restored',['id'=>$customer->id,'email'=>$customer->email]);
        // return redirect('/dashboard')->with('restore','Customer restored successfully');
    }
    public function deleteForced($id)
    {
        $repo=new AdminRepository;
        $repo->deleteForced($id);
          return redirect('/dashboard')->with('delete','Customer deleted PERMANENTLY');
  
        // $customer = AdminCustomer::withTrashed()->find($id);
        // $customer->forceDelete();
        // Log::channel('custom')->info('Customer has been permanently deleted',['id'=>$customer->id,'email'=>$customer->email]);
        // return redirect('/dashboard')->with('delete','Customer deleted PERMANENTLY');
    }
    public function export()
    {
        $repo=new AdminRepository;
        $check=$repo->export();
        return $check;

        // Log::channel('custom')->info('Customers information have been exported');
        // return Excel::download(new UsersExport, 'users.xlsx');
        
    }
    public function import(Request $request)
    {
        $repo=new AdminRepository;
        $check=$repo->import($request);
        if(!$check){
            dd("error");
        }
        return redirect('/dashboard')->with('import', 'File imported and stored in db');
   
    //     try{
    //         Excel::import(new UsersImport, $request->file('file'));
    //     }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
    //         $failures = $e->failures();
     
    //  foreach ($failures as $failure) {
    //      $failure->row(); // row that went wrong
    //      $failure->attribute(); // either heading key (if using heading row concern) or column index
    //      $failure->errors(); // Actual error messages from Laravel validator
    //      $failure->values(); // The values of the row that has failed.
    //  }
    //         // dump("error caught");
    //         // return redirect('/dashboard')->with('importError', 'Fail to upload. As file has empty values where there needs data');
    //     }
    //     Log::channel('custom')->info('Customers have been added through excel');
    //     // Excel::import(new UsersImport, $request->file('file')->store('files'));
    //     return redirect('/dashboard')->with('import', 'File imported and stored in db');
    }
}
