<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ClasseResource;


class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $niveau = Niveau::find(1);

        return [
            'statusCode' => Response::HTTP_OK,
            'message' => '',
            'Niveau' => $niveau->libelle,
            'data'   =>ClasseResource::collection($niveau->classes)
        ];
    }

    /**
     * Show the form for creating a new resource.
     */

}
