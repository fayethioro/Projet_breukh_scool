<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Symfony\Component\HttpFoundation\Response;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            /**
             * Récupérer les élèves dont l'état est égal à 1
             */
            return [
                'statusCode' => Response::HTTP_OK,
                'message' => 'Liste des evaluation récupérée avec succès',
                'data'   => Evaluation::all()
            ];


    }
}
