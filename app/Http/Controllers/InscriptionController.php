<?php

namespace App\Http\Controllers;

use ReflectionClass;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Inscription;
use Illuminate\Http\Request;
use App\Models\AnneeScolaire;
use App\Traits\JoinQueryParams;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\InscriptionResource;
use App\Http\Requests\PostInscriptionRequest;
use Symfony\Component\HttpFoundation\Response;


class InscriptionController extends Controller
{
    use JoinQueryParams;
    public function enregistrer(PostInscriptionRequest $request)
    {
        try {

            // Début de la transaction
            DB::beginTransaction();

            //Récupérer l'année scolaire avec le statut 1
            $anneeScolaire = AnneeScolaire::where('status', 1)->first();
            $eleve = $this->createEleve($request);
            $inscription = $this->createInscription($eleve, $request, $anneeScolaire);

            //    Commit de la transaction pour marque la fin de la transaction
            DB::commit();

            $classe = Classe::find($request->classeId);
            return [
                'statusCode' => Response::HTTP_CREATED,
                'message' => 'Inscription réussie',
                'classe' => $classe->libelle,
                'eleves'   => $eleve,
                'inscrit'   => $inscription
            ];
        } catch (\Exception $e) {
            //Rollback de la transaction en cas d'erreur
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
        $eleve->email = $request->email;
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
    public function index()
    {
        $modelClass = Inscription::class;
        $collections = $this->getModelMethods($modelClass);
        $collection = collect($collections);
        $join = request()->input('join');

        if (!$collection->contains($join)) {
            return [
                'statusCode' => Response::HTTP_OK,
                'message' => '',
                'data'   => Inscription::all()
            ];
        }
        return [
            'statusCode' => Response::HTTP_OK,
            'message' => '',
            'data'   => InscriptionResource::collection($this->resolve(Inscription::class, $join))
        ];
    }
}
