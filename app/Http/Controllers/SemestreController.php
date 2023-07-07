<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class SemestreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return [
            "statusCode" => Response::HTTP_OK,
            "Message" => 'Listes des semestre',
            "Semestre" => Semestre::all()
        ];
    }

    public function activer(Request $request, $semestreId)
    {
        // Effectuer la mise à jour du semestre
        $semestre = Semestre::findOrFail($semestreId);
          
        // Modifier les champs du semestre avec les nouvelles valeurs
        $semestre->status = $request->status;

        // Ajoutez d'autres champs à mettre à jour si nécessaire
        $semestre->save();
         // Effectuer la mise à jour des enregistrements dans la table 'classes'

        DB::table('classes')
            ->where('semestre_id', '!=', $semestreId)
            ->update(['semestre_id' => $semestreId]);
         // Autres opérations si nécessaire...
         return
         [
            "statutCode" =>Response::HTTP_ACCEPTED,
            "Message" =>"le semestre en cours",
            "semestre"=>$semestre
         ];
    }
}
