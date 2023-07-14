<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostAnneeScolaireRequest;
use App\Models\AnneeScolaire;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Response;

class AnneeScolaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Instanciation de la classe ReflectionClass pour le modèle Inscription
        $reflectionClass = new ReflectionClass(AnneeScolaire::class);

        // Récupération de toutes les méthodes du modèle
        $methods = $reflectionClass->getMethods();

        // Filtrer les méthodes pour ne garder que celles de la classe AnneeScolaire
        $filteredMethods = [];
        foreach ($methods as $method) {
            if (
                $method->class === AnneeScolaire::class &&
                $method->name !== 'factory' &&
                $method->name !== 'newFactory'
            ) {
                $filteredMethods[] = $method;
            }
        }

        return $filteredMethods;
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
