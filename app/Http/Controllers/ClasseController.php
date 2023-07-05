<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Niveau;
use App\Models\Inscription;
use App\Models\NoteMaximal;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\NoteMaxRequest;
use App\Http\Resources\ClasseResource;
use App\Http\Resources\NoteMaxResource;
use Illuminate\Database\QueryException;
use App\Http\Resources\GetNoteMaxResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

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
    public function addNoteMax(NoteMaxRequest $request, $id)
    {
        try {

            $validator = Validator::make(["id"=>$id], [
                'id' => 'exists:classes,id',

            ]);
            if ($validator->fails()) {
                return response()->json([
                    'statusCode' => Response::HTTP_BAD_REQUEST,
                    'message' => 'La classe sélectionnée n\'existe pas.'
                ]);
            }
            // Récupérer les données validées du formulaire
            $validatedData = $request->validated();

            // Créer une nouvelle note maximale
            $noteMax = new NoteMaximal();
            $noteMax->discipline_id = $validatedData['discipline_id'];
            $noteMax->classe_id = $id;
            $noteMax->evaluation_id = $validatedData['evaluation_id'];
            $noteMax->note_max = $validatedData['note_max'];
            $noteMax->save();

            // return [
            //     'statusCode' => Response::HTTP_CREATED,
            //     'message' => 'Note maximale ajoutée avec succès',
            //     'data' => NoteMaxResource::collection($noteMax)
            // ];

            return new NoteMaxResource($noteMax);
        } catch (QueryException $e) {
            return ['message' =>
            'Une note maximale avec le même libellé existe
            déjà pour cette classe et cette évaluation.
             '];
        } catch (\Exception $e) {
            return [
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Erreur lors de l\'ajout de la note maximale',
                'error' => $e->getMessage()
            ];
        }
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

        return new ClasseResource($classe->load('inscriptions'));
        // return [
        //     'statusCode' => Response::HTTP_OK,
        //     'message' => 'Liste des élèves de la classe',
        //     'data' => $eleves,
        // ];
    }
}
