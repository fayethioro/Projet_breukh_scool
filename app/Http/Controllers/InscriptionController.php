<?php

namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use Carbon\Carbon;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ClasseResource;
use Symfony\Component\HttpFoundation\Response;

class InscriptionController extends Controller
{
    public function enregistrer(Request $request)
    {
        try {

            // Valider les données du formulaire
            $request->validate([
                'firstName' => 'required',
                'lastName' => 'required',
                'gender' => 'required',
                'profil' => 'required',
                'classeId' => 'required',
            ]);

            // Vérifier si la classe existe
            $classeExists = $this->classeExists($request->classeId);
            if (!$classeExists) {
                return response()->json([
                    'statusCode' => Response::HTTP_BAD_REQUEST,
                    'message' => 'La classe sélectionnée n\'existe pas.'
                ]);
            }

            // Début de la transaction
            DB::beginTransaction();

            // Récupérer l'année scolaire avec le statut 1
            $anneeScolaire = AnneeScolaire::where('status', 1)->first();

            // Créer l'élève
            $eleve = $this->createEleve($request);

            // Créer l'inscription
            $inscription = $this->createInscription($eleve, $request, $anneeScolaire);

            // Commit de la transaction
            DB::commit();

            return response()->json([
                'statusCode' => Response::HTTP_CREATED,
                'message' => 'Inscription réussie',
                'data'   => $eleve
            ]);
        } catch (\Exception $e) {
            // Rollback de la transaction en cas d'erreur
            DB::rollback();

            return response()->json([
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Erreur lors de l\'inscription',
                'error' => $e->getMessage()
            ]);
        }
    }

    private function createEleve(Request $request)
    {
        $eleve = new Eleve;
        $eleve->nom = $request->lastName;
        $eleve->prenom = $request->firstName;
        $eleve->date_naissance = $request->birthdayDate;
        $eleve->lieu_naissance = $request->birthdayPlace;
        $eleve->sexe = $request->gender;
        $eleve->profil = $request->profil;
        $eleve->save();

        return $eleve;
    }

    private function createInscription(Eleve $eleve, Request $request, AnneeScolaire $anneeScolaire)
    {
        $inscription = new Inscription;
        $inscription->date_inscription = now();
        $inscription->eleve_id = $eleve->id;
        $inscription->classe_id = $request->classeId;
        $inscription->annee_scolaire_id = $anneeScolaire->id;
        $inscription->save();

        return $inscription;
    }

    private function classeExists($classeId)
    {
        return Classe::where('id', $classeId)->exists();
    }

}

