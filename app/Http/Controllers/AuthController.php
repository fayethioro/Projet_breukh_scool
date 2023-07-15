<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return "bonjour";
    }
    public function connect(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
        //    session()->regenerate();

        $user = Auth::user();
            return [
                "Message" => "Connesion reussi",
                "token"   => $user->createToken('mon-Token')->plainTextToken
            ];
        }

        return [
           "erreur" => "Email ou mot de passe invalide"
        ];
    }

    public function logout()
    {
        Auth::logout();
        return to_route('auth.login');
    }
}
