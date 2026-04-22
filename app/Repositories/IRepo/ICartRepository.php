<?php
namespace App\Repositories\IRepo;

interface ICartRepository{
    public function GetCart($user_id);
    public function GetItem($user_id , $product_id);
    public function AddItem($item);
    public function DeleteItem($item);
    public function DeleteCart($user_id);
}



?>
