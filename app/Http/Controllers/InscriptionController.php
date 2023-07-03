<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClasseResource;
use App\Models\Eleve;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InscriptionController extends Controller
{
    public function enregistrer(Request $request)
    {
        
        // Valider les données du formulaire
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'gender' => 'required',
            'profil' => 'required',
        ]);

        // Créer une nouvelle instance d'Eleve et assigner les valeurs
        $eleve = new Eleve;
        $eleve->nom = $request->lastName;
        $eleve->prenom = $request->firstName;
        $eleve->date_naissance = $request->birthdayDate;
        $eleve->lieu_naissance = $request->birthdayPlace;
        $eleve->sexe = $request->gender;
        $eleve->profil = $request->profil;

        // Enregistrer l'élève dans la base de données
        $eleve->save();

        // Créer une nouvelle instance d'Inscription et assigner les valeurs
        $inscription = new Inscription;
        $inscription->date_inscription = now();
        $inscription->eleve_id = $eleve->id;
        $inscription->classe_id = $request->classeId;
        $inscription->annee_scolaire_id = $request->anneeScolaireId;

        // Enregistrer l'inscription dans la base de données
        $inscription->save();

        return [
            'statusCode' => Response::HTTP_CREATED,
            'message' => 'Inscription reussi',
            'data'   => $eleve
        ];
    }
}

