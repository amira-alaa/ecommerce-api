<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    //
    protected $fillable = ['product_id' , 'order_id' , 'product_quantity'];


    public function order(){
        return $this->belongsTo(Order::class , 'order_id');
    }
    public function product(){
        return $this->belongsTo(Product::class , 'product_id');
    }
}
