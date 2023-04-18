<?php

namespace App\Exports;

use App\Models\AdminCustomer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class UsersExport implements FromCollection,WithHeadings,WithColumnWidths,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function columnWidths(): array
    {
        $customers=AdminCustomer::all();
        foreach($customers as $customer){
            if(strlen($customer->email)>10){
                if(strlen($customer->address)>30){
                return [
                    'D'  => 55,
                    'c' =>  25,      
                ];
                } 
                return [
                    'D'  => 30,
                    'c' =>  25,      
                ];
            }
        }
        return [
            'D'  => 10,           
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
    public function collection()
    {
       $customers =AdminCustomer::all();
    //    $info=array();
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
