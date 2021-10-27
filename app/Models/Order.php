<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function items(){
        return $this->hasMany(OrderItem::class,'order_id');
    }


    public function card(){
        return $this->belongsTo(UserCard::class,'card_id');
    }

    public function saveOrder($request=null){
        $this->user_id = $request->user_id;
    }
}
