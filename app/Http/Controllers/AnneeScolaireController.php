<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostAnneeScolaireRequest;
use App\Models\AnneeScolaire;
use Symfony\Component\HttpFoundation\Response;

class AnneeScolaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return [
            'statusCode' => Response::HTTP_OK,
            'message' => 'Inscription réussie',
            'data'   => AnneeScolaire::all()
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostAnneeScolaireRequest $request)
    {
       /**
        *  Créer une nouvelle année scolaire
        */
        $annee = new AnneeScolaire();
        $annee->libelle = $request->libelle;

        /**
         * Par défaut, on désactive la nouvelle année scolaire
         */
        $annee->status = 1;
        $annee->save();
        return [
            'statusCode' => Response::HTTP_CREATED,
            'message' => 'Inscription réussie',
            'data'   => $annee
        ];
    }
    public function getAnneeScolaire()
    {
        try {
            return AnneeScolaire::where('statut', 1)->firstOrFail();
            
        } catch (\Exception $e) {
            return ['error' => 'Erreur lors de la récupération de l\'année scolaire'];
        }
    }

}
