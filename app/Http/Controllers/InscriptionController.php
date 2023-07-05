<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostInscriptionRequest;
use App\Models\AnneeScolaire;
use App\Models\Eleve;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class InscriptionController extends Controller
{
    public function enregistrer(PostInscriptionRequest $request)
    {
        try {
           /**
            *  Début de la transaction
            */
            DB::beginTransaction();

            /**
             * Récupérer l'année scolaire avec le statut 1
             */
            $anneeScolaire = AnneeScolaire::where('status', 1)->first();

            /**
             * Créer l'élève
             */
            $eleve = $this->createEleve($request);

           /**
            *  Créer l'inscription
            */
            $inscription = $this->createInscription($eleve, $request, $anneeScolaire);

            /**
             * Commit de la transaction pour marque la fin de la transaction
             */
            DB::commit();

            return [
                'statusCode' => Response::HTTP_CREATED,
                'message' => 'Inscription réussie',
                'eleves'   => $eleve,
                'inscrit'   => $inscription
            ];
        } catch (\Exception $e) {
           /**
            *  Rollback de la transaction en cas d'erreur
            */
            DB::rollback();

            return [
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Erreur lors de l\'inscription',
                'error' => $e->getMessage()
            ];
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

}

