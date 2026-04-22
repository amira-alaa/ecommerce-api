<?php
namespace App\Services\IService;

use App\Http\Requests\Cart\AddItemRequest;
use Illuminate\Http\Request;

interface ICartService{
    public function GetCartForUser(Request $req);

    public function AddItemToCart(AddItemRequest $req);
    public function DecrementItemInCart(Request $req , $product_id);
    public function DeleteItemFromCart(Request $req , $product_id);

    public function checkOut(Request $req);
}



?>
