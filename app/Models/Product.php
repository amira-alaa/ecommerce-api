<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'name', 'price' , 'quantity_in_stock' , 'category_id' , 'vendor_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class , 'category_id');
    }
    public function orders(){
        return $this->belongsToMany(Order::class , 'order_products' , 'product_id' , 'order_id');
    }
    public function users(){
        return $this->belongsToMany(User::class , 'carts' , 'product_id' , 'user_id');
    }
    public function vendor(){
        return $this->belongsTo(User::class , 'vendor_id');
    }
}
