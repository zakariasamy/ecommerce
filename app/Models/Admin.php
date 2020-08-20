<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    protected $table='admins';
    protected $guarded = []; // instead of using fillable for all elements
    public $timestamps = true;
}
