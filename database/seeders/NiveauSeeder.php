<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveaux = [
            [
                "libelle" => "ELEMENTAIRE"
            ],
            [
                "libelle" => 'SECONDAIRE'
            ]
        ];

        \App\Models\Niveau::insert($niveaux);
    }
}
