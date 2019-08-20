<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Logs the user in and out of the application
     */
    public function login()
    {
        $credentials = [
            'email' => request()->email,
            'password' => request()->password,
        ];

        if (auth()->attempt($credentials)) {
            $success['token'] = auth()->user()->createToken('honestParrot')->accessToken;
            $success['name'] = auth()->user()->name;
            return response()->json($success, 200);
        }
        return response()->json(['error' => 'Unauthorised'], 401);

    }
}
