<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Classe;
use App\Models\Semestre;
use App\Models\Discipline;
use App\Models\Inscription;
use App\Models\NoteMaximal;
use App\Models\AnneeScolaire;
use App\Http\Resources\NoteResource;
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
        $semestreId = Semestre::where('status', 1)->pluck('id')->first();

        return NoteMaximal::where([
            ['classe_id', '=', $classe],
            ['discipline_id', '=', $discipline],
            ['semestre_id', '=', $semestreId],
        ])->pluck('id');
    }
    public function getNotesByclasseByDiscipline($classe, $discipline)
    {

        $results = $this->findNoteMaximalIdByclasseByDiscipline($classe, $discipline);
        $semestreId = Semestre::where('status', 1)->pluck('id')->first();

        $classe = Classe::find($classe);
        $discipline = Discipline::findOrFail($discipline);
        $anneeScolaire = AnneeScolaire::findOrFail($classe->annee_scolaire_id);
        $semestre = Semestre::find($semestreId);

        $notesEleves = Note::whereIn('note_maximal_id', $results)->get()->SortBy('inscription_id');
        return [
            "statutCode" => Response::HTTP_OK,
            "messages" => 'Liste des notes des eleves de ' . $classe->libelle . ' en '  . $discipline->libelle . ' de ' .  $semestre->libelle . ' de ' .  $anneeScolaire->libelle,
            "NoteEleves" => $notesEleves
        ];
    }

    public function getNotesByclasseByDisciplineByEleve($classe, $discipline, $eleve)
    {

        $results = $this->findNoteMaximalIdByclasseByDiscipline($classe, $discipline);
        $semestreId = Semestre::where('status', 1)->pluck('id')->first();
        $eleveInscrit =  Inscription::where([
            ['classe_id', '=', $classe],
            ['eleve_id', '=', $eleve],
        ])->pluck('id');

        $classe = Classe::find($classe);
        $discipline = Discipline::findOrFail($discipline);
        $semestre = Semestre::find($semestreId);
        $anneeScolaire = AnneeScolaire::findOrFail($classe->annee_scolaire_id);

        $notesEleves = Note::whereIn('note_maximal_id', $results)
            ->where('inscription_id', $eleveInscrit)->get();
        return [
            "statutCode" => Response::HTTP_OK,
            "messages" => 'Liste des notes d\'un eleves de ' . $classe->libelle . ' en '  . $discipline->libelle . ' de ' .  $semestre->libelle . ' de ' .  $anneeScolaire->libelle,
            "NoteEleves" => $notesEleves
        ];
    }
    public function getNotesByclasse($classe)
    {
        $results = $this->findNoteMaximalIdByclasse($classe);
        $semestreId = Semestre::where('status', 1)->pluck('id')->first();

        $classe = Classe::find($classe);
        $semestre = Semestre::find($semestreId);
        $anneeScolaire = AnneeScolaire::findOrFail($classe->annee_scolaire_id);

        $notesEleves = Note::whereIn('note_maximal_id', $results)->get()->SortBy('inscription_id');

        return [
            "statutCode" => Response::HTTP_OK,
            "messages" => 'Liste des notes des eleves de ' . $classe->libelle . ' de ' .  $semestre->libelle . ' de ' .  $anneeScolaire->libelle,
            "NoteEleves" => $notesEleves
        ];

    }


    public function findNoteMaximalIdByclasse($classe)
    {
        $semestreId = Semestre::where('status', 1)->pluck('id')->first();

        return NoteMaximal::where([
            ['classe_id', '=', $classe],
            ['semestre_id', '=', $semestreId],
        ])->pluck('id');
    }
}
