<?php
namespace App\Services\Service;

use App\Repositories\IRepo\IAuthRepository;
use App\Services\IService\IAuthService;

class AuthService implements IAuthService{
    private IAuthRepository $_authRepo;
    public function __construct(IAuthRepository $authRepo)
    {
        $this->_authRepo = $authRepo;
    }
    public function createUser($request){
        try{
            $this->_authRepo->create($request->toArray());
            return true;
        }catch(\Exception $ex){
            return false;
        }
    }
    public function softDeleteUser($id){
        $user = $this->_authRepo->getUser($id);
        // return $user;
        if($user){
            try{
                $this->_authRepo->delete($user);
                $user->is_soft_deleted = !$user->is_soft_deleted;
                $user->save();
                return true;
            }catch(\Exception $ex){
                return false;
            }
        }else
            return false;
    }
    public function restoreUser($id){
        $user = $this->_authRepo->getTrashedUser($id);
        if($user)
        {
            try{
                $this->_authRepo->restore($user);
                $user->is_soft_deleted = !$user->is_soft_deleted;
                $user->save();
                return true;
            }catch(\Exception $ex){
                return false;
            }
        }else
            return response()->json([
                'message' => 'Not Found User'
            ]);
    }

    public function checkToken($token){
        $res = $this->_authRepo->checkToken($token);
        if ($res == null)
            return null;
        return $res;
    }


}




?>
