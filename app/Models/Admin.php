<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $fillable = ['user_name', 'password'];
    public $timestamps = true;

    protected $hidden = ['password'];
}