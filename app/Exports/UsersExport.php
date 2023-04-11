<?php

namespace App\Exports;

use App\Models\AdminCustomer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       $customers =AdminCustomer::all();
       $info=array();
       foreach($customers as $customer){
        $data_array[] = array(
            'Name' =>$customer->name,
            'Gender' => $customer->gender,
            'Email' => $customer->email,
            'Address' => $customer->address
        );
       }
       return collect($data_array);
       
    }
    public function headings(): array
    {
        
        return ['Name', 'Gender','Email','Address'];
    }
}
