<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
            'lastName' => ['required', 'string'],
            'birthDate' => ['required', 'date_format:Y-m-d'],
        ]);

        $is_old_user = User::where('login', $data['login'])->exists();
        if ($is_old_user) {
            return response([
                'error' => [
                    'code' => 409,
                    'message' => 'Логин уже существует',
                ]
            ], 409);
        }
        
        $new_user = User::create($data);

        return response([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => [
                'user' => [
                    'email' => $new_user->login,
                    'username' => $new_user->lastName,
                ]
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
