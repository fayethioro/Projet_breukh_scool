<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EleveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return [
            'statusCode' => Response::HTTP_OK,
            'message' => 'liste des elves',
            'data'   => Eleve::all()
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $eleves = Eleve::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'sexe' => $request->sexe,
            'profil' => $request->profil
        ]);

        return [
            'statusCode' => Response::HTTP_CREATED,
            'message' => 'inscription reussi',
            'data'   => $eleves
        ];
    }




    /**
     * Display the specified resource.
     */
    public function show(Eleve $eleve)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Eleve $eleve)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $eleve = Eleve::find($id);

        if ($eleve) {
            // L'utilisateur existe, supprimez-le
            $eleve->delete();
            return [
                'statusCode' => Response::HTTP_NO_CONTENT,
                'message' => 'suppression reussi',
                'data'   => null
            ];
        } else {
            // L'utilisateur n'existe pas, redirigez vers la page souhaitée
            return redirect('http://127.0.0.1:8000/breukh-api/eleves');
        }
    }
}
