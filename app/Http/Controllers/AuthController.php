<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function signin(Request $request) {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($data)) {
            return response([
                'error' => [
                    'code' => 401,
                    'message' => 'Неверный логин или пароль',
                ]
            ], 401);
        }

        $user = $request->user();
        $new_token = $user->createToken('name');

        $user->update([
            'token' => $new_token->plainTextToken
        ]);

        return response([
            'status' => 'success',
            'message' => 'OK',
            'data' => [
                'token' => $new_token->plainTextToken
            ],
        ], 200);
    }
}
