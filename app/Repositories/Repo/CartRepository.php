<?php
namespace App\Repositories\Repo;

use App\Models\Cart;
use App\Repositories\IRepo\ICartRepository;

class CartRepository implements ICartRepository{
    public function GetCart($user_id){
        return Cart::with(['product' , 'user'])->where('user_id' , $user_id )->get();
    }
    public function GetItem($user_id , $product_id){
        return Cart::with(['product' , 'user'])->where('user_id' , $user_id)->where('product_id' , $product_id)->first();
    }
    public function AddItem($item){
        return Cart::create($item);
    }
    public function DeleteItem($item){
        return $item->delete();
    }

    public function DeleteCart($user_id){
        return Cart::where('user_id' , $user_id)->delete();
    }


}




?>
