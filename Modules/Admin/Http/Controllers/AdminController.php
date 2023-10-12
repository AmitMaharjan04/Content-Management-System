<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\AdminUser;
use Modules\Admin\Entities\AdminCustomer;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;
use Modules\Admin\Repositories\AdminRepository;

class AdminController extends Controller
{
    private $adminRepo;

    public function __construct()
    {
        $this->adminRepo = new AdminRepository;
    }
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
        
        $result = $this->adminRepo->login($request);
        if($result)
            return redirect()->route('admin.dashboard')->with('success','Logged in successfully');
        return redirect()->back()->with('error','Invalid email or password');
        
    }
    public function register()
    {
        return view('admin::register');
    }
    public function registerStore(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required ', 'email', 'regex:/\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+/'],
            'password' => ['required ','min:5', ' max:30','regex:/[A-Za-z]{1,}[0-9]{1,}[!@#$%\^\-\.]{1,}/']
        ], [
            'name.required' => 'Please enter name!',
            'email.regex' => 'Please enter a valid email address!',
            'password.regex' => 'Password must contain alpabets,number and alphanumeric keys.',
        ]);

        $result = $this->adminRepo->register($request);
        if($result)
            return redirect('/')->with('success','User registered successfully');
        
        return redirect()->back()->with('email','Email already registered.');
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
    public function dashboard(Request $request)
    {
        $customer = AdminCustomer::all();
        return view('admin::dashboard',compact('customer'));

    }
    public function add($id = null)
    {
        if ($id != null) {
            $url = url('/admin/add') . "/" . $id;
            $customer = AdminCustomer::find($id);
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
        $req->validate([
            'name' => ['required', ' min:3', ' max:30'],
            'email' => ['required ', 'email', 'regex:/\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+/'],
            'address' => ['required', 'max:50'],
            'description' => ['required', 'max:50'],
            'hobby' => ['required'],
        ], [
            'email.regex' => 'Please enter a valid email address.'
        ]);

        $result = $this->adminRepo->edit($id,$req);
        if($result)
            return redirect('/admin/dashboard')->with('edit','Customer edited successfully');
                
        return redirect()->back()->with('aerror','Email already registered.Choose new email');
        
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
        
        $result = $this->adminRepo->add($request);
        if($result)
            return redirect('/admin/dashboard')->with('add','Customer added successfully');
    }

    public function delete($id)
    {
        $result = $this->adminRepo->delete($id);
        if($result)
            return redirect('/admin/dashboard')->with('softDelete','Customer deleted temporarily');
    }
    public function trash()
    {
        $customer = $this->adminRepo->trash();
        return view('admin::trash',compact('customer'));
    }
    public function restore($id)
    {
        $result = $this->adminRepo->restore($id);
        if($result)
            return redirect('/admin/dashboard')->with('restore','Customer restored successfully');
    }
    public function deleteForced($id)
    {
        $result = $this->adminRepo->deleteForced($id);
        if($result)
            return redirect('/admin/dashboard')->with('delete','Customer deleted PERMANENTLY!!');
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
