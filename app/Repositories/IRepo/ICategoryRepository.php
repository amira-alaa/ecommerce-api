<?php
namespace App\Repositories\IRepo;


interface ICategoryRepository{
    // user
    public function GetAll($user_id);
    public function GetById($id , $user_id);
    // admin
    public function Create($category);
    public function Update($category , $id);
    public function Delete($id);

}



?>
