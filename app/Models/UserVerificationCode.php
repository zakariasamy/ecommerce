<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVerificationCode extends Model
{
    public $table = 'user_verification_codes';


    protected $fillable = ['user_id', 'code','created_at','updated_at'];


    public function attribute(){
        return $this -> belongsTo(Attribute::class,'attribute_id');
    }
}
