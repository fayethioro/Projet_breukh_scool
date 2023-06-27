<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            [
                "libelle" => "CI",
                "niveau_id" => 1
            ],
            [
                "libelle" => "CP",
                "niveau_id" => 1
            ],
            [
                "libelle" => "CE1",
                "niveau_id" => 1
            ],
            [
                "libelle" => "CE2",
                "niveau_id" => 1
            ],
            [
                "libelle" => "CM1",
                "niveau_id" => 1
            ],
            [
                "libelle" => "CM2",
                "niveau_id" => 1
            ],
            [
                "libelle" => "6ieme",
                "niveau_id" => 2
            ],
            [
                "libelle" => "5eme",
                "niveau_id" => 2
            ],
            [
                "libelle" => "4eme",
                "niveau_id" => 2
            ],
            [
                "libelle" => "3eme",
                "niveau_id" => 2
            ],
            [
                "libelle" => "2nde",
                "niveau_id" => 3
            ],

        ];

        \App\Models\Classe::insert($classes);
    }
}
