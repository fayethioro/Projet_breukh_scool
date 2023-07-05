<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $evaluation = [
            [
                "libelle" => "Ressource",
            ],
            [
                "libelle" => 'Composition'
            ],

        ];

        \App\Models\Evaluation::insert($evaluation);
    }
}
