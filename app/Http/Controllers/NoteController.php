<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\Classe;
use App\Models\Discipline;
use App\Models\Inscription;
use App\Models\Note;
use App\Models\NoteMaximal;
use Symfony\Component\HttpFoundation\Response;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return NoteResource::collection(Note::all());
    }

    public function findNoteMaximalIdByclasseByDiscipline($classe, $discipline)
    {
        return NoteMaximal::where([
            ['classe_id', '=', $classe],
            ['discipline_id', '=', $discipline],
        ])->pluck('id');
    }
    public function getNotesByclasseByDiscipline($classe, $discipline)
    {

        $results = $this->findNoteMaximalIdByclasseByDiscipline($classe, $discipline);

        $classe = Classe::find($classe);
        $discipline = Discipline::findOrFail($discipline);

        $notesEleves = Note::whereIn('note_maximal_id', $results)->get()->SortBy('inscription_id');
        return [
            "statutCode" => Response::HTTP_OK,
            "messages" => 'Liste des notes des eleves de ' . $classe->libelle . ' en '  . $discipline->libelle,
            "NoteEleves" => $notesEleves
        ];
    }

    public function getNotesByclasseByDisciplineByEleve($classe, $discipline, $eleve)
    {

        $results = $this->findNoteMaximalIdByclasseByDiscipline($classe, $discipline);

        $eleveInscrit =  Inscription::where([
            ['classe_id', '=', $classe],
            ['eleve_id', '=', $eleve],
        ])->pluck('id');

        $classe = Classe::find($classe);
        $discipline = Discipline::findOrFail($discipline);

        $notesEleves = Note::whereIn('note_maximal_id', $results)
            ->where('inscription_id', $eleveInscrit)->get();
        return [
            "statutCode" => Response::HTTP_OK,
            "messages" => 'Liste des notes d\'un eleves de ' . $classe->libelle . ' en '  . $discipline->libelle,
            "NoteEleves" => $notesEleves
        ];
    }
}
