<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
class CustomerController extends Controller
{

    public function index(){
        $url=url('/customer');
        $customer=new Customer();
        $title="Customer Registration";
        $data=compact('url','title','customer');
        return view('customer')->with($data);
    }

    public function store(Request $request){
        $request->validate(
            [
                'name' => 'required',
                'email'=>'required | email' ,
                'password'=>'required',
                'address'=>'required',
            ]
        );
        echo "</pre>";
        print_r($request->all());
        $customer=new Customer;
        $customer->name = $request['name'];
        $customer->email= $request['email'];
        $customer->address= $request['address'];
        $customer->gender=$request['gender'];
        $customer->password=md5($request['password']);
        $customer->save();
        return redirect('/customer/view');
    }

    public function view(){
        $customers = Customer::all();
        $data=compact('customers');

        return view('welcome')->with($data);
    }
    
    public function trash(){
        $customers= Customer::onlyTrashed()->get();
        $data=compact('customers');
        return view('customer-trash')->with($data);
    }

    public function delete($id){
        $customer=Customer::find($id);
        if(!is_null($customer)){
            $customer->delete();
        }
        return redirect('customer/view');
    }

    public function forcedDelete($id){
        $customer=Customer::withTrashed()->find($id);
        if(!is_null($customer)){
            $customer->forceDelete();
        }
        return redirect()->back();
    }

    public function restore($id){
        $customer=Customer::withTrashed()->find($id);
        if(!is_null($customer)){
            $customer->restore();
        }
        return redirect('customer/view');
    }

    public function update($id){
        $customer=Customer::find($id);
        if(!is_null($customer)){
            $title="Update Customer";
            $url=url('/customer/update') . "/" . $id;
            $data=compact('customer','url','title');
            return view('customer')->with($data);
        }
        return redirect('customer');
    }
    
    public function realUpdate($id,Request $request){
        $customer=Customer::find($id);
        $customer->name = $request['name'];
        $customer->email= $request['email'];
        $customer->address= $request['address'];
        $customer->gender=$request['gender'];
        $customer->save();
        return redirect('customer/view');
    }
    
}
