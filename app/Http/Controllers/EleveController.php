<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Models\Eleve;
use App\Models\NoteMaximal;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Nette\UnexpectedValueException;
use Symfony\Component\HttpFoundation\Response;

class EleveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            /**
             *  Récupérer les élèves dont l'état est égal à 1
             */
            $eleves = Eleve::where('etat', 1)->get();
            return [
                'statusCode' => Response::HTTP_OK,
                'message' => 'Liste des élèves récupérée avec succès',
                'data'   => $eleves
            ];
        } catch (\Exception $e) {
            return [
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Erreur lors de la récupération des élèves',
                'error' => $e->getMessage()
            ];
        }
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
    public function updadeEtat(Request $request)
    {
        try {

            $ids = $request->input('ids');
            // Rechercher les élèves par leurs IDs
            $eleves = Eleve::whereIn('id', $ids)->get();

            // Mettre à jour l'état des élèves à 0
            Eleve::whereIn('id', $ids)->update(['etat' => 0]);

            return [
                'statusCode' => Response::HTTP_OK,
                'message' => 'Élèves supprimés avec succès',
                'data'   => count($eleves),
            ];
        } catch (\Exception $e) {
            return [
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Erreur lors de la suppression des élèves',
                'error' => $e->getMessage()
            ];
        }
    }
    public function destroy($id)
    {
        try {
            /**
             *  Rechercher l'élève par son ID
             */
            $eleve = Eleve::findOrFail($id);

            /**
             *  Mettre à jour l'état de l'élève à 0
             */
            $eleve->etat = 0;
            $eleve->save();

            return [
                'statusCode' => Response::HTTP_OK,
                'message' => 'Élève supprimé avec succès',
                'data'   => $eleve,
            ];
        } catch (\Exception $e) {
            return [
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Erreur lors de la suppression de l\'élève',
                'error' => $e->getMessage()
            ];
        }
    }

    public function addNoteEleve(Request $request, $classeId, $disciplineId, $evaluationId)
    {
        try {
            // Valider les données reçues
            $request->validate([
                'notes' => 'required|array',
                'notes.*.eleve_id' => 'required|integer',
                'notes.*.note' => 'required|numeric',
            ]);

            // Récupérer l'ID de la note maximale
            $noteMaximalId = $this->getNoteMaximalById($classeId, $disciplineId, $evaluationId);

            // Ajouter les notes pour chaque élève
            $notes = [];
            foreach ($request->notes as $noteData) {
                $note = new Note();
                $note->eleve_id = $noteData['eleve_id'];
                $note->note_maximal_id = $noteMaximalId;
                $note->note = $noteData['note'];

                // Vérifier si la note est inférieure à la note maximale
                $noteMaximal = NoteMaximal::find($noteMaximalId);
                if ($note->note > $noteMaximal->note_max) {
                    return response()->json([
                        'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'message' => 'La note dépasse la note maximale',
                        'data' => [
                            'note' => $note->note,
                            'note_max' => $noteMaximal->note_max,
                        ]
                    ]);
                }

                $note->save();

                $note->load('noteMaximal');
                $notes[] = $note;
            }

            return NoteResource::collection($notes);

            // return response()->json([
            //     'statusCode' => Response::HTTP_CREATED,
            //     'message' => 'Notes ajoutées avec succès',
            //     'data'   => $notes
            // ]);

        } catch (QueryException $e) {
            return ['message' =>
            'Une note  avec le même eleve existe
        déjà pour cette classe et cette évaluation et cette discipline.
         '];
        } catch (\Exception $e) {
            return [
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Erreur lors de l\'ajout de la note maximale',
                'error' => $e->getMessage()
            ];
        }
    }


    private function getNoteMaximalById($classeId, $disciplineId, $evaluationId)
    {
        $noteMaximal = NoteMaximal::where([
            'classe_id' => $classeId,
            'discipline_id' => $disciplineId,
            'evaluation_id' => $evaluationId
        ])->first();

        if ($noteMaximal) {
            return $noteMaximal->id;
        }

        throw new UnexpectedValueException('Note maximale introuvable pour l\'évaluation spécifiée.');
    }
}
