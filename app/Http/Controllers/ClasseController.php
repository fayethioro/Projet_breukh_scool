<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        return response()->json(ClasseResource::collection(Classe::all()));
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

        // Récupérer la classe correspondant à l'ID fourni
        $classe = Classe::find($id);

        if (!$classe) {
            return [
                'statusCode' => 404,
                'message' => 'Classe introuvable',
            ];
        }

        // Récupérer les élèves de la classe
        $eleves = DB::table('eleves')
            ->join('inscriptions', 'eleves.id', '=', 'inscriptions.eleve_id')
            ->where('inscriptions.classe_id', $id)
            ->where('eleves.etat', 1) // Filtre pour les élèves ayant un état de 1
            ->select('eleves.*')
            ->get();

        return [
            'statusCode' => 200,
            'message' => 'Liste des élèves de la classe',
            'data' => $eleves,
        ];
    }


    /**
     * Show the form for creating a new resource.
     */
}
