<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function signup(CreateUser $request){
        $validatedData = $request->validated();
        $user = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),  // 利用bcrypt加密
        ]);
        $user->save();
        return response('success', 201);
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        if(!Auth::attempt($validatedData)){
            return response('授權失敗', 401);
        }
        $user = $request->user();  // 如果登入成功會塞使用者資料
        $tokenResult = $user->createToken('Token');  // 產生token
        $tokenResult->token->save();
        return response(['token' => $tokenResult->accessToken]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();  // 讓token失效過期
        return response(
            ['message' => '成功登出']
        );
    }

    public function user(Request $request)
    {
        return response(
            $request->user()
        );
    }
}
