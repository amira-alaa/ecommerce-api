<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'total_price' , 'user_id'
    ];

    public function products(){
        return $this->belongsToMany( Product::class ,'order_products' , 'order_id' , 'product_id')->withPivot('product_quantity');
    }
    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }

}
