<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\EleveController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
|
|
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/


// Route::resource("/niveaux", NiveauController::class);
Route::get("/niveaux/{id}", [NiveauController::class, 'find']);
Route::get("/niveaux/", [NiveauController::class, 'index']);

// Route::resource("/classes", ClasseController::class);
// Route::get("/classes/{id}/niveau", [ClasseController::class, 'classeById']);

Route::resource("/eleves", EleveController::class)->only(['store']);


