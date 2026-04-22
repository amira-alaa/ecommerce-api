<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\StoreCredentialsRequest;
use App\Services\IService\IAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthApiController extends Controller
{
    private IAuthService $_authService;
    public function __construct(IAuthService $authService)
    {
        $this->_authService = $authService;
    }
    // Login EndPoint
    public function login(Request $request){
        $credentials = $request->only('email' , 'password');
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'message' => 'Successfully Login',
                'token' => $token,
                'success' => true
            ]);
        }
        else
            return response()->json([
                'message' => 'Invalid Credentials',
                'success' => false
            ] , 401);
    }

    // register EndPoint
    public function register(StoreCredentialsRequest $request){
        // return $request->toArray();
        $role= "";
        $res = $this->_authService->createUser($request);
        if($request->role_id == 2)
            $role = "Vendor";
        else
            $role = "User" ;

        if($res)
            return response()->json([
                'message' => $role .' Created Successfully',
                'success' => true
            ]);
        else
            return response()->json([
                'message' => 'Failed To Create '.$role ,
                'success' => false
            ]);
    }

    public function getProfile(Request $req){
        return $req->user();
    }
    public function softDelete($id){
        $res = $this->_authService->softDeleteUser($id);
        if($res)
            return response()->json([
                'message' => 'User Soft Deleted Successfully',
                'success' => true
            ]);
        else
            return response()->json([
                'message' => 'Failed To Delete User',
                'success' => false
            ]);

    }
    public function restoreUser($id){
        $res = $this->_authService->restoreUser($id);
        if($res)
            return response()->json([
                'message' => 'User Restored Successfully',
                'success' => true
            ]);
        else
            return response()->json([
                'message' => 'Failed To Restore User',
                'success' => false
            ]);

    }

    public function checkToken(Request $request){
        if (!$request->has('token')) {
            return response()->json([
                'message' => 'Token is required',
                'success' => false
            ], 400);
        }
        $res = $this->_authService->checkToken($request->token);
        // return $request->token;
        if($res)
            return response()->json([
                                'message'=> 'Right Token',
                                'success' => true
                                ]);
        return response()->json([
                            'message'=> 'Wrong Token',
                            'success' => false
                            ]);

    }
}
