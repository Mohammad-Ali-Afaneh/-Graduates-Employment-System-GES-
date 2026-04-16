<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    protected $table = 'company';
    protected $fillable = ['company_name', 'location', 'email', 'password'];
}