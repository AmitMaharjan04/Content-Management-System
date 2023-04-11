<?php

namespace App\Imports;

use App\Models\AdminCustomer;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AdminCustomer([
            'name' => $row[0],
            'gender' => $row[1],
            'email'=> $row[2], 
            'address' => $row[3],
            'hobbies' =>$row[4],
            'blood_group' =>$row[5],
            'file'=>$row[6],
            'description'=>$row[7],
        ]);
    }
}
