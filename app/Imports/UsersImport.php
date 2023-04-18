<?php

namespace App\Imports;

use App\Models\AdminCustomer;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

// use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
class UsersImport implements ToModel,WithUpserts,WithHeadingRow,SkipsEmptyRows,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable;

    public function uniqueBy()
    {
        return 'email';
    }
    public function rules(): array
    {
        return [
            'name' => [
                'required','string',
            ],
            // 'gender' => [
            //     'required',
            // ],
            // 'email' => [
            //     'required','email'
            // ],
            // 'address' => [
            //     'required',
            // ],
            // 'hobbies' => [
            //     'required',
            // ],
            // 'blood_group' => [
            //     'required',
            // ],
            // 'description' => [
            //     'required','min:5','max:10'
            // ],
        ];
    }
    public function model(array $row)
    {
        return new AdminCustomer([
            'name' => $row['name']?? null,
            'gender' => $row['gender']?? null,
            'email'=> $row['email']?? null, 
            'address' => $row['address']?? null,
            'hobbies' =>$row['hobby']?? null,
            'blood_group' =>$row['blood_group']?? null,
            'file'=>$row['file']?? null,
            'description'=>$row['description']?? null,
        ]);
    }
}
