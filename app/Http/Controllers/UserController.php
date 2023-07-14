<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }
    public static function createAccessToken()
    {
        $user = Auth::user();

        return $user->createToken('mon-Token')->plainTextToken;
    }


}
