<?php
namespace App\Repositories\IRepo;


interface IProductRepository{
    public function GetAll($user_id);
    public function GetLatestProducts();
    public function GetById($id , $user_id);
    public function GetProductsByCatId($cat_id);
    public function Create($product);
    public function Update($product , $id);
    public function Delete($id);
}



?>
