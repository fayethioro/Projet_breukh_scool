<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Semestre;
use App\Models\Discipline;
use App\Models\Evaluation;
use App\Models\Inscription;
use App\Models\NoteMaximal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\UnexpectedValueException;
use App\Http\Resources\NoteResource;
use App\Http\Resources\EleveResource;
use App\Http\Requests\NoteEleveRequest;
use App\Http\Resources\GetNoteResource;
use Illuminate\Database\QueryException;
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
                'data'   => EleveResource::collection($eleves)
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

    public function addNoteEleve(NoteEleveRequest $request, $classeId, $disciplineId, $evaluationId)
    {
        try {
            // Récupérer l'ID de la note maximale
            $noteMaximalId = $this->getNoteMaximalById($classeId, $disciplineId, $evaluationId);

            // Récupérer les IDs des inscriptions
            $inscriptionIds = array_column($request->notes, 'inscription_id');

            foreach ($inscriptionIds as $inscription_id) {
                $classeInscrit = Inscription::find($inscription_id);
                if ($classeInscrit->classe_id != $classeId ) {
                    return response()->json([
                        'statusCode' => Response::HTTP_NOT_FOUND,
                        'message' => 'eleve n \'est pas inscrit dans cette calsse',
                        'data' => [
                            'inscription_id' => $inscription_id,
                        ]
                    ]);
                }
            }
            // Récupérer les notes existantes pour les inscriptions spécifiées
            $existingNotes = Note::whereIn('inscription_id', $inscriptionIds)
                ->where('note_maximal_id', $noteMaximalId)
                ->get();

            // dd($existingNotes);
            // Vérifier les notes existantes
            foreach ($existingNotes as $existingNote) {
                $inscriptionId = $existingNote->inscription_id;
                return response()->json([
                    'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'message' => 'Une note avec le même élève existe déjà pour cette classe, évaluation et discipline.',
                    'data' => [
                        'inscription_id' => $inscriptionId,
                    ]
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Ajouter les notes dans une transaction
            DB::beginTransaction();

            $notes = [];
            foreach ($request->notes as $noteData) {
                $inscriptionId = $noteData['inscription_id'];
                $note = $noteData['note'];

                // Vérifier si la note dépasse la note maximale
                $noteMaximal = NoteMaximal::find($noteMaximalId);
                if ($note > $noteMaximal->note_max) {
                    DB::rollback();
                    return response()->json([
                        'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'message' => 'La note dépasse la note maximale',
                        'data' => [
                            'note' => $note,
                            'note_max' => $noteMaximal->note_max,
                        ]
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                // Ajouter la note
                $noteModel = new Note();
                $noteModel->inscription_id = $inscriptionId;
                $noteModel->note_maximal_id = $noteMaximalId;
                $noteModel->note = $note;
                $noteModel->save();

                $notes[] = $noteModel;
            }

            DB::commit();

            return $notes;
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Erreur lors de l\'ajout de la note',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    private function getNoteMaximalById($classeId, $disciplineId, $evaluationId)
    {
        $semestreId = Semestre::where('status', 1)->first('id');
        $noteMaximal = NoteMaximal::where([
            'classe_id' => $classeId,
            'discipline_id' => $disciplineId,
            'evaluation_id' => $evaluationId,
            'semestre_id' => $semestreId->id,
        ])->first();

        if ($noteMaximal) {
            return $noteMaximal->id;
        }

        throw new UnexpectedValueException('Note maximale introuvable pour l\'évaluation spécifiée.');
    }

    public function getNotesEleve($classeId, $disciplineId, $evaluationId)
    {
        try {
            /**
             *  Récupérer l'ID de la note maximale
             */

            $noteMaximalId = $this->getNoteMaximalById($classeId, $disciplineId, $evaluationId);
            /**
             * Récupérer toutes les notes pour cette classe, discipline et évaluation
             */
            $notes = Note::where('note_maximal_id', $noteMaximalId)->get();
            $classe = Classe::find($classeId);
            $discipline = Discipline::findOrFail($disciplineId);
            $evaluation = Evaluation::find($evaluationId);
            $NoteMax = NoteMaximal::find($noteMaximalId);

            // Retourner les notes sous forme de ressource
            return [
                "statusCode" => Response::HTTP_OK,
                "message" => "Les notes  des eleves d'une classe dans un discipline pour une evaluation",
                "classe" => $classe->libelle,
                "discipline" => $discipline->libelle,
                "evaluation" => $evaluation->libelle,
                "noteMax" => $NoteMax->note_max,
                "Notes des eleves" => NoteResource::collection($notes)
            ];
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Erreur lors de la récupération des notes',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateNoteEleve(Request $request, $classeId, $disciplineId, $evaluationId, $eleveId)
    {
        // Valider les données reçues
        $request->validate([
            'note' => 'required|numeric',
        ]);

        // Récupérer la note de l'élève à mettre à jour
        $note = Note::whereHas('noteMaximal', function ($query) use ($classeId, $disciplineId, $evaluationId) {
            $query->where('classe_id', $classeId)
                ->where('discipline_id', $disciplineId)
                ->where('evaluation_id', $evaluationId);
        })->whereHas('inscription', function ($query) use ($eleveId) {
            $query->where('eleve_id', $eleveId);
        })->first();

        if (!$note) {
            return response()->json([
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message' => 'Note introuvable',
            ]);
        }

        // Mettre à jour la note
        $note->note = $request->input('note');
        $note->save();

        return response()->json([
            'statusCode' => Response::HTTP_OK,
            'message' => 'Note mise à jour avec succès',
            'data' => $note,
        ]);
    }
}
