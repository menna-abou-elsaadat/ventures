<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Services\UserService;
use App\Helpers\ApiResponse;
use Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $inputs = $request->input();
        $user = UserService::create($inputs['name'],$inputs['email'],$inputs['password'],'Customer');
        $data['name'] = $user->name;
        $data['email'] = $user->email;

        return ApiResponse::sendResponse(201,'User Account Created Successfully',$data);

    }

    public function login(LoginRequest $request)
    {
        $inputs = $request->input();
        if (Auth::attempt(['email'=>$inputs['email'],'password'=>$inputs['password']])) {
            $user = Auth::user();
            $data['token'] = $user->createToken($user->email)->plainTextToken;
            $data['name'] = $user->name;
            $data['email'] = $user->email;

            return ApiResponse::sendResponse(200,'User Account logged in Successfully',$data);

        }
        else
        {
            return ApiResponse::sendResponse(401,'User credentails not found',null);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendResponse(200,'User logged out Successfully',null);

    }
}
