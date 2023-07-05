<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Niveau;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ClasseResource;


class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return [
            'statusCode' => Response::HTTP_OK,
            'message' => 'liste des classes',
            'data'   => ClasseResource::collection(Classe::all())
        ];
    }
    public function classeById($id)
    {
        $niveau = Niveau::find($id);
        return [
            'statusCode' => Response::HTTP_OK,
            'message' => '',
            'Niveau' => $niveau->libelle,
            'data'   => ClasseResource::collection($niveau->classes)
        ];
    }

    public function getEleveByClasse($id)
    {

         /**
          * Récupérer la classe correspondant à l'ID fourni
          */
        $classe = Classe::find($id);

        if (!$classe) {
            return [
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message' => 'Classe introuvable',
            ];
        }

       /**
        *  Récupérer les élèves de la classe
        */
        $eleves = DB::table('eleves')
            ->join('inscriptions', 'eleves.id', '=', 'inscriptions.eleve_id')
            ->where('inscriptions.classe_id', $id)
            /**
             * Filtre pour les élèves ayant un état de 1
             */
            ->where('eleves.etat', 1)
            ->select('eleves.*')
            ->get();

        return [
            'statusCode' => Response::HTTP_OK,
            'message' => 'Liste des élèves de la classe',
            'data' => $eleves,
        ];
    }

}
