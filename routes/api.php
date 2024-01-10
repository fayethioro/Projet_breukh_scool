<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\SemestreController;

use App\Http\Controllers\EvenementController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AnneeScolaireController;
use App\Http\Controllers\AuthController;

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
*/


Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'connect'])->name('auth.login');


Route::middleware(['auth:sanctum', 'role:ADMIN, ATTACHE'])->group(function () {
    
    Route::get("/niveaux/classe/{id}", [NiveauController::class, 'find']);
    Route::get("/niveaux", [NiveauController::class, 'index'])->name('niveau.index');
    Route::get("/niveaux/{id}", [NiveauController::class, 'show']);
    Route::post("/niveaux", [NiveauController::class, 'store'])->name('niveau.store');

    Route::post('/enregistrer', [InscriptionController::class, 'enregistrer']);
    Route::get('/inscriptions', [InscriptionController::class, 'index']);

    Route::get("/classes", [ClasseController::class, 'index']);
    Route::get("/classes/{id}/niveau", [ClasseController::class, 'classeById']);
    Route::get('/classes/{id}/eleves', [ClasseController::class, 'getEleveByClasse']);
    Route::post("/classe/{id}/coef", [ClasseController::class, 'addNoteMax']);
    Route::get("/classe/{id}/coef", [ClasseController::class, 'getNoteMax']);

    Route::put("/eleves/sorti", [EleveController::class, 'updadeEtat']);
    Route::get("/eleves", [EleveController::class, 'index']);
    Route::post( "/classe/{classeId}/discipline/{disciplineId}/eval/{evaluationId}",
                                [EleveController::class, 'addNoteEleve']);

    Route::resource("/annees", AnneeScolaireController::class);
    Route::get('/annee-scolaire', [AnneeScolaireController::class, 'getAnneeScolaire']);

    Route::get('/evaluations', [EvaluationController::class, 'index']);

    Route::apiresource("/disciplines", DisciplineController::class)->only('index', 'store');

    Route::apiresource("/semestres", SemestreController::class)->only('index', 'store');
    Route::put('/semestres/{id}/activer', [SemestreController::class, 'activer']);

    Route::get('/users/{id}/evenement', [UserController::class, 'getEvenementbyUser']);
    Route::get('/eleve/{id}/participations', [UserController::class, 'getParticipationEleve']);

    Route::get("/classe/{classeId}/discipline/{disciplineId}/eval/{evaluationId}",[EleveController::class, 'getNotesEleve']);
    Route::put("/classe/{classeId}/discipline/{disciplineId}/eval/{evaluationId}/eleve/{eleveId}",[EleveController::class, 'updateNoteEleve']);
});

Route::middleware(['auth:sanctum', 'role:ADMIN, ATTACHE, PROF,PARENT'])->group(function () {
    Route::get("/classe/{classe}/discipline/{discipline}/notes/eleves/{eleve}",[NoteController::class, 'getNotesByclasseByDisciplineByEleve'] );

    Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware(['auth:sanctum', 'role:ADMIN'])->group(function () {
    Route::apiresource("/users", UserController::class);
});

Route::middleware(['auth:sanctum', 'role:ADMIN,ATTACHE,PROF'])->group(function () {
    Route::get("/notes", [NoteController::class, 'index']);
    Route::get("/classe/{classe}/discipline/{discipline}/notes", [NoteController::class, 'getNotesByclasseByDiscipline']);
    Route::get("/classe/{classe}/notes", [NoteController::class, 'getNotesByclasse']);

    Route::apiresource("/evenements", EvenementController::class)->only('index', 'store');
    Route::post("evenements/{id}/participation", [EvenementController::class, 'ajouterParticipation']);
    Route::get("event", [EvenementController::class, 'getParticipations']);
});

