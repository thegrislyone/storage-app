<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    
    public function login(Request $request) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // return ["email" => $request['email'], "password" => $request['password'], "users" => User::get()];

        if (Auth::attempt($credentials, true)) {

            $request->session()->regenerate();

            return "заебись";

        } else {

            return response()->json(['error' => true], 400);

        }
        
    }

    public function register(Request $request) {
        
        try {

            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            User::create([
                "name" => "dolbayob",
                "email" => $credentials['email'],
                "password" => Hash::make($credentials['password'])
            ]);

            return response()->json(["success_suka" => true], 200);

        } catch(Exception $e) {

            return response()->json(["error" => true], 400);

        }

    }

}
