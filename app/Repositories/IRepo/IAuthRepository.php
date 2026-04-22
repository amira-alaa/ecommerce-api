<?php
namespace App\Repositories\IRepo;


interface IAuthRepository{
    public function getUser($id);
    public function create($user);
    public function delete($user);
    public function restore($user);
    public function getTrashedUser($id);
    public function checkToken($token);
}








?>
