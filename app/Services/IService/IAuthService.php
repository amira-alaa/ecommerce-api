<?php
namespace App\Services\IService;

interface IAuthService{
    public function createUser($request);
    public function softDeleteUser($id);

    public function restoreUser($id);
    public function checkToken($token);
}




?>
