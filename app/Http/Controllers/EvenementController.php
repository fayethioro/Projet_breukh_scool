<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvenementRequest;
use App\Models\Evenement;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EvenementController extends Controller
{
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
    public function show(Evenement $evenement)
    {
        //
    }
}
