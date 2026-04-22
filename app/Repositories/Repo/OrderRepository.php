<?php
namespace App\Repositories\Repo;

use App\Models\Order;
use App\Repositories\IRepo\IOrderRepository;

class OrderRepository implements IOrderRepository{

    public function Create($order){
        return Order::create($order);
    }
    public function GetOrder($user_id){
        return Order::with(['products' , 'user'])->where('user_id' , $user_id)->get();
    }

}



?>
