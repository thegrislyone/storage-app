<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{

    public function registration(Request $request) {

        try {

            $credentials = $request->validate([
                'name' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $user = User::create([
                "name" => "dolbayob",
                "email" => $credentials['email'],
                "password" => Hash::make($credentials['password'])
            ]);

            Auth::login($user, true);

            $request->session()->regenerate();

            return response()->json([
                "meta" => [ "success" => true, "errors" => [] ],
                "data" => [ "user" => Auth::user() ]
            ], 200);

        } catch(Exception $e) {

            return response()->json([
                "meta" => [ "success" => false, "errors" => ["Ошибка регистрации"] ],
                "data" => []
            ], 400);

        }

    }

    public function login(Request $request) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, true)) {

            $request->session()->regenerate();

            return response()->json([
                "meta" => [ "success" => true, "errors" => [] ],
                "data" => [ "user" => Auth::user() ]
            ], 200);

        } else {

            return response()->json([
                "meta" => [ "success" => false, "errors" => ["Пароль или логин неверный"] ],
                "data" => []
            ], 400);

        }

    }

    public function logout(Request $request) {

        try {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                "meta" => [ "success" => true, "errors" => [] ],
                "data" => []
            ]);

        } catch(Exception $e) {

            return response()->json([
                "meta" => [ "success" => true, "errors" => ["Ошибка логаута"] ],
                "data" => []
            ]);

        }

    }

    public function check(Request $request) {

        try {

            return response()->json([
                "meta" => [ "success" => true, "errors" => [] ],
                "data" => [ "is_authorized" => !!Auth::check() ]
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                "meta" => [ "success" => true, "errors" => [$e] ],
                "data" => []
            ], 200);

        }

    }

}
