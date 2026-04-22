<?php
namespace App\Repositories\IRepo;


interface IOrderProductsRepository{
    public function Create($orderProduct);
    public function GetAll($vendor_id);
}


?>
