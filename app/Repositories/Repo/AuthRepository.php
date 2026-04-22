<?php
namespace App\Repositories\Repo;

use App\Models\User;
use App\Repositories\IRepo\IAuthRepository;
use Laravel\Sanctum\PersonalAccessToken;

class AuthRepository implements IAuthRepository{
    public function create($user){
        return User::create($user);
    }
    public function delete($user){
        return $user->delete();
    }
    public function getUser($id){
        return User::with('role')->find($id);
    }
    public function getTrashedUser($id){
        return User::onlyTrashed()->find($id);
    }

    public function restore($user){
        return $user->restore();
    }
    public function checkToken($token){
        return PersonalAccessToken::where('token' , $token)->first();
    }


}

?>
