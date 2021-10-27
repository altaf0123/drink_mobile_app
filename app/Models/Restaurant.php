<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table='restaurants';
    use HasFactory;



    public function images(){
        return $this->hasMany(RestaurantImage::class,'restaurant_id');
    }
}
