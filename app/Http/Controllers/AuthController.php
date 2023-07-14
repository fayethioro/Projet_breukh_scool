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
return UserController::createAccessToken();
            // return redirect()->intended('http://127.0.0.1:8000/breukh-api/niveaux');
        }

        return to_route('auth.login')->withError([
           "erreur" => "Email ou mot de passe invalide"
        ])->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        return to_route('auth.login');
    }
}
