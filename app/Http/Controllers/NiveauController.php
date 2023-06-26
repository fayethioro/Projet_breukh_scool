<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClasseResource;
use App\Http\Resources\NiveauResource;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NiveauController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return [
            'statusCode' => Response::HTTP_OK,
            'message' => '',
            // 'Niveau' => $niveau->libelle,
            'data'   => Niveau::with('classes')->get()
        ];
        // return Niveau::with('classes')->get();

        // return NiveauResource::collection(Niveau::with('classes')->get());



    }


}
