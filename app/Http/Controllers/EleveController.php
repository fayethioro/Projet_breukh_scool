<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EleveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            /**
             *  Récupérer les élèves dont l'état est égal à 1
             */
            $eleves = Eleve::where('etat', 1)->get();
            return [
                'statusCode' => Response::HTTP_OK,
                'message' => 'Liste des élèves récupérée avec succès',
                'data'   => $eleves
            ];
        } catch (\Exception $e) {
            return [
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Erreur lors de la récupération des élèves',
                'error' => $e->getMessage()
            ];
        }

    }










    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $eleves = Eleve::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'sexe' => $request->sexe,
            'profil' => $request->profil
        ]);

        return [
            'statusCode' => Response::HTTP_CREATED,
            'message' => 'inscription reussi',
            'data'   => $eleves
        ];
    }




    /**
     * Display the specified resource.
     */
    public function show(Eleve $eleve)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Eleve $eleve)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        try {
            // Rechercher l'élève par son ID
            $eleve = Eleve::findOrFail($id);

            // Mettre à jour l'état de l'élève à 0
            $eleve->etat = 0;
            $eleve->save();

            return [
                'statusCode' => Response::HTTP_OK,
                'message' => 'Élève supprimé avec succès',
                'data'   => $eleve,
            ];
        } catch (\Exception $e) {
            return [
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Erreur lors de la suppression de l\'élève',
                'error' => $e->getMessage()
            ];
        }
    }
}
