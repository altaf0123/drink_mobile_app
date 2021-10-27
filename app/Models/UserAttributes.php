<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAttributes extends Model
{
    protected $table = 'users_attributes';
    use HasFactory;
    protected $fillable=['user_id','attribute_key','attribute_value'];


    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
