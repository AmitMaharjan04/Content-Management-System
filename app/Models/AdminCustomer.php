<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminCustomer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name','gender','email','address','hobbies','blood_group','file','description'];
    protected $table= "admin_customers";
}
