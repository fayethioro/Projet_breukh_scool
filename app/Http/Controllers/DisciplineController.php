<?php

namespace App\Http\Controllers;

use App\Http\Resources\GetNoteMaxResource;
use App\Http\Resources\NoteMaxResource;
use App\Models\Classe;
use App\Models\Discipline;
use App\Models\NoteMaximal;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class DisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createNoteMax($id, Request $request)
    {
        $libelle = $request->libelle;
        $evaluationId = $request->evaluation_id;

      /**
       *   Vérifier si une note maximale existe déjà pour
       * la discipline, la classe et l'évaluation spécifiées
       */
        $existingNoteMaximal = NoteMaximal::where('classe_id', $id)
            ->where('evaluation_id', $evaluationId)
            ->whereHas('discipline', function ($query) use ($libelle) {
                $query->where('libelle', $libelle);
            })
            ->exists();

        if ($existingNoteMaximal) {
            return ['message' =>
            'Une note maximale avec le même libellé existe
            déjà pour cette classe et cette évaluation.
             '];
        }

        /**
         *  Démarrez la transaction
         */
        DB::beginTransaction();

        try {
            /**
             * Récupérer ou créer la discipline avec le libellé fourni
             */

            $discipline = Discipline::firstOrCreate(
                ['libelle' => $libelle],
                ['code' => $request->code]
            );

            /**
             * Insérer une nouvelle note maximale liée à la
             *  discipline, la classe et l'évaluation
             */
            $noteMaximal = NoteMaximal::create([
                'discipline_id' => $discipline->id,
                'classe_id' => $id,
                'evaluation_id' => $evaluationId,
                'note_max' => $request->note_max
            ]);

            /**
             * Valider la transaction
             */
            DB::commit();

            return new NoteMaxResource($noteMaximal);

        } catch (\Exception $e) {

            /**
             * En cas d'erreur, annuler la transaction
             */
            DB::rollBack();

            return [
                'message' => 'Erreur lors de l\'insertion des données',
                'error' => $e->getMessage()
            ];
        }
    }
    public function getNoteMax($id)
    {
        $classe = Classe::findOrFail($id);
        $disciplines = $classe->disciplinesWithNotes()->get();

        return [
            'statusCode' => Response::HTTP_OK,
            'message' => "Liste des disciplines d'une classe",
            'Niveau' => $classe->libelle,
            'data' => GetNoteMaxResource::collection($disciplines)
        ];
    }
}
