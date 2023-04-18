<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminLogin;
use App\Models\AdminCustomer;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;


class AdminController extends Controller
{

    public function index()
    {
        return view('admin::login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // new
        if (Auth::attempt($credentials)) {
            session(['email'=>$request->email]);
            Log::channel('custom')->info('Admin logged in',['id'=>Auth::user()->id,'email'=>Auth::user()->email]);
        
            return redirect('/admin/dashboard')->with('success','Logged in successfully');
        } else {
            return redirect()->back()->with('error','Invalid email or password');
        }
    }
    public function register()
    {
        return view('admin::register');
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
        $emails = $request->email;
        // $emailRegex= "/[a-zA-Z0-9\.-]+@[a-zA-Z0-9]+[\.-]/i";
        $admin = new AdminLogin();
        dump("here");
        $emailCheck=AdminLogin::select('email')->get();
        foreach($emailCheck as $email){
            if($email->email==$emails){
                dump("inside");
                return redirect()->back()->with('email','Email already registered.');
            }
        }
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        Log::channel('custom')->info('Admin has been registered',['id'=>$admin->id,'email'=>$admin->email]);
        return redirect('/admin')->with('success','User registered successfully');
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        // $request->session()->regenerate();
        return redirect('/admin');
    }
    public function dashboard(Request $request)
    {
        // $value = session('email');
        // dd($value);
        $customer = AdminCustomer::all();
        return view('admin::dashboard',compact('customer'));

    }
    public function add($id = null)
    {
        if ($id != null) {
            $customer = AdminCustomer::find($id);
            $url = url('/admin/add') . "/" . $id;
            $title = "Update Customer";
            return view('admin::add', compact('url', 'title', 'customer'));
        } else {
            $url = url('/admin/add');
            $customer = new AdminCustomer();
            $title = "Customer Registration";
            return view('admin::add', compact('url', 'title', 'customer'));
        }
    }
    public function editStore($id, Request $req)
    {   
        $old=AdminCustomer::find($id);
        $req->validate([
            'name' => ['required', ' min:3', ' max:30'],
            'email' => ['required ', 'email', 'regex:/\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+/'],
            'address' => ['required', 'max:50'],
            'description' => ['required', 'max:50'],
            'hobby' => ['required'],
        ], [
            'email.regex' => 'Please enter a valid email address.'
        ]);
        $uniqueEmailCheck=AdminCustomer::select('email')
                                        ->where('email','!=',$old->email)
                                        ->get();
        foreach($uniqueEmailCheck as $unique){
            if($req->email==$unique->email){
                return redirect()->back()->with('aerror','Email already registered.Choose new email');
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
        return redirect('/admin/dashboard')->with('edit','Customer edited successfully');
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
        return redirect('/admin/dashboard')->with('add','Customer added successfully');
    }

    public function delete($id)
    {
        $customer = AdminCustomer::find($id);
        Log::channel('custom')->info('Customer has been soft deleted',['id'=>$customer->id,'email'=>$customer->email]);
        $customer->delete();
        return redirect('/admin/dashboard')->with('softDelete','Customer deleted temporarily');
    }
    public function trash()
    {
        $customer = AdminCustomer::onlyTrashed()->get();
        return view('admin::trash',compact('customer'));
    }
    public function restore($id)
    {
        $customer = AdminCustomer::withTrashed()->find($id);
        $customer->restore();
        Log::channel('custom')->info('Customer has been restored',['id'=>$customer->id,'email'=>$customer->email]);
        return redirect('/admin/dashboard')->with('restore','Customer restored successfully');
    }
    public function deleteForced($id)
    {
        $customer = AdminCustomer::withTrashed()->find($id);
        $customer->forceDelete();
        Log::channel('custom')->info('Customer has been permanently deleted',['id'=>$customer->id,'email'=>$customer->email]);
        return redirect('/admin/dashboard')->with('delete','Customer deleted PERMANENTLY');
    }
    public function export()
    {
        Log::channel('custom')->info('Customers information have been exported');
        return Excel::download(new UsersExport, 'users.xlsx');
        
    }
    public function import(Request $request)
    {
        Excel::import(new UsersImport, $request->file('file'));
        Log::channel('custom')->info('Customers have been added through excel');
        // Excel::import(new UsersImport, $request->file('file')->store('files'));
        return redirect('/admin/dashboard')->with('import', 'File imported and stored in db');
    }
}
