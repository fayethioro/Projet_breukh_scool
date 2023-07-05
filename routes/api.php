<?php

use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NoteMaxController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\NiveauController;

use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AnneeScolaireController;


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


Route::post('/enregistrer', [InscriptionController::class, 'enregistrer']);

Route::get("/niveaux/classe/{id}", [NiveauController::class, 'find']);
Route::get("/niveaux", [NiveauController::class, 'index']);
Route::get("/niveaux/{id}", [NiveauController::class, 'show']);

Route::get("/classes", [ClasseController::class, 'index']);
Route::get("/classes/{id}/niveau", [ClasseController::class, 'classeById']);
Route::get('/classes/{id}/eleves', [ClasseController::class, 'getEleveByClasse']);
Route::post("/classe/{id}/coef", [ClasseController::class, 'addNoteMax']);
Route::get("/classe/{id}/coef", [ClasseController::class, 'getNoteMax']);



// Route::resource("/eleves", EleveController::class);
Route::put("/eleves/sorti", [EleveController::class,'updadeEtat']);
Route::get("/eleves", [EleveController::class,'index']);
Route::post("/classe/{classeId}/discipline/{disciplineId}/eval/{evaluationId}", [EleveController::class,'addNoteEleve']);

Route::resource("/annees", AnneeScolaireController::class);
Route::get('/annee-scolaire', [AnneeScolaireController::class, 'getAnneeScolaire']);

Route::get('/evaluations', [EvaluationController::class, 'index']);


// Route::post("/classe/{id}/coef", [NoteMaxController::class, 'createNoteMax']);
// Route::get("/classe/{id}/coef", [NoteMaxController::class, 'getNoteMax']);

Route::apiresource("/disciplines", DisciplineController::class)->only('index', 'store');









