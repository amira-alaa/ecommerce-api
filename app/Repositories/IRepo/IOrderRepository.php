<?php
namespace App\Repositories\IRepo;


interface IOrderRepository{
    public function Create($order);
    public function GetOrder($user_id);
}


?>
