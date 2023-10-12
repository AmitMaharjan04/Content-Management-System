<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminCustomer extends Model
{
    use SoftDeletes;
    protected $table = 'admin_customers';
    protected $fillable = ['name', 'email', 'password'];
    
}
