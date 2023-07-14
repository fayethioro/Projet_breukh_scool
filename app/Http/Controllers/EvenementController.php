<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvenementRequest;
use App\Models\Classe;
use App\Models\Evenement;
use App\Models\Participation;
use App\Traits\JoinQueryParams;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EvenementController extends Controller
{
    use JoinQueryParams;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return [
            "statutCode" => Response::HTTP_OK,
            "message" => "Mes evenements",
            "Evenement" => Evenement::all()
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EvenementRequest $request)
    {
        $evenement = new Evenement;
        $evenement->libelle = $request->libelle;
        $evenement->date_evenement = $request->date_evenement;
        $evenement->description = $request->description;
        $evenement->user_id = $request->user_id;
        $evenement->save();

        return [
            'stautCode' => Response::HTTP_CREATED,
            'message' => 'Événement créé avec succès',
            "evenement crée" =>  $evenement
        ];
    }

    /**
     * Display the specified resource.
     */

     public function ajouterParticipation(Request $request, $id)
    {
        // Récupérer l'événement en fonction de l'ID
        $evenement = Evenement::findOrFail($id);

        // Récupérer les données de la requête
        $classeIds = $request->input('classe_ids');

        // Parcourir les IDs des classes et créer les participations
        foreach ($classeIds as $classeId) {
            $classe = Classe::findOrFail($classeId);

            $participation = new Participation();
            $participation->evenement_id = $evenement->id;
            $participation->classe_id = $classe->id;
            $participation->save();
        }

        // Retourner une réponse appropriée
        return response()->json(['message' => 'Participations ajoutées avec succès'], 200);
    }

      public function getParticipations()
      {
          return $this->hasJoin('classes');
      }


}
