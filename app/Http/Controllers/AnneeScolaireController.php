<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'libelle' => [
                'required',
                'regex:/^\d{4}-\d{4}$/',
                'unique:annee_scolaires',
                function ($attribute, $value, $fail) {
                    // Vérifier le format de la date
                    $startDate = intval(substr($value, 0, 4));
                    $endDate = intval(substr($value, 5, 4));

                    if ($endDate !== ($startDate + 1)) {
                        $fail('Le format de la date doit être "yyyy-yyyy"
                        et la différence entre les années doit être de 1 an.');
                    }
                }
            ],
        ]);
        // Créer une nouvelle année scolaire
        $annee = new AnneeScolaire();
        $annee->libelle = $request->libelle;
        $annee->status = 1; // Par défaut, on désactive la nouvelle année scolaire
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
            $anneeScolaire = AnneeScolaire::where('statut', 1)->firstOrFail();
            return response()->json($anneeScolaire);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération de l\'année scolaire'], 500);
        }
    }

}
