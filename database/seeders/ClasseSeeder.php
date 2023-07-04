<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;
use App\Models\AnneeScolaire;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $anneeScolaire = AnneeScolaire::where('status', 1)->first();

        $classes = [
            [
                "libelle" => "CI",
                "niveau_id" => 1,
                "annee_scolaire_id" =>$anneeScolaire->id
            ],
            [
                "libelle" => "CP",
                "niveau_id" => 1,
                "annee_scolaire_id" => $anneeScolaire->id
            ],
            [
                "libelle" => "CE1",
                "niveau_id" => 1,
                "annee_scolaire_id" => $anneeScolaire->id
            ],
            [
                "libelle" => "CE2",
                "niveau_id" => 1,
                "annee_scolaire_id" => $anneeScolaire->id
            ],
            [
                "libelle" => "CM1",
                "niveau_id" => 1,
                "annee_scolaire_id" => $anneeScolaire->id
            ],
            [
                "libelle" => "CM2",
                "niveau_id" => 1,
                "annee_scolaire_id" => $anneeScolaire->id
            ],
            [
                "libelle" => "6ieme",
                "niveau_id" => 2,
                "annee_scolaire_id" => $anneeScolaire->id
            ],
            [
                "libelle" => "5ieme",
                "niveau_id" => 2,
                "annee_scolaire_id" => $anneeScolaire->id
            ],
            [
                "libelle" => "4ieme",
                "niveau_id" => 2,
                "annee_scolaire_id" => $anneeScolaire->id
            ],
            [
                "libelle" => "3ieme",
                "niveau_id" => 2,
                "annee_scolaire_id" => $anneeScolaire->id
            ],
            [
                "libelle" => "2nd",
                "niveau_id" => 3,
                "annee_scolaire_id" => $anneeScolaire->id
            ],
        ];

        Classe::insert($classes);
    }
}
