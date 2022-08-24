<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $user = User::where('email', $request->login)->orWhere('name', $request->login)->first();
        if( !$user ) return response(['message' => 'Email atau Nama tidak ditemukan']);
        if( !Hash::check($request->password, $user->password) ) return response(['message' => 'Password Salah']);
        return response([
            'data' => $user,
            'token' => $user->createToken($user->remember_token)->plainTextToken
        ]);
    }
}
