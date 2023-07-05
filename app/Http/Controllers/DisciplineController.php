<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostDisciplineRequest;
use App\Models\Discipline;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return [
            'statusCode' => Response::HTTP_OK,
            'message' => 'Liste des discipline',
            'data' => Discipline::all()
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostDisciplineRequest $request)
    {
        try {
             /**
              * Créer une nouvelle discipline
              */
            $discipline = new Discipline();
            $discipline->libelle = $request->libelle;
            $discipline->code = $request->code;
            $discipline->save();

            return [
                'statusCode' => Response::HTTP_CREATED,
                'message' => 'Discipline créée avec succès',
                'data' => $discipline
            ];
        } catch (\Exception $e) {
            return [
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Erreur lors de la création de la discipline',
                'error' => $e->getMessage()
            ];
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Discipline $discipline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discipline $discipline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discipline $discipline)
    {
        //
    }
}
