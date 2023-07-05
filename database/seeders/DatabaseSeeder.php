<?php

namespace Database\Seeders;

use App\Models\Evaluation;
use Database\Seeders\NiveauSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AnneeScolaireSeeder::class,
            NiveauSeeder::class,
            ClasseSeeder::class,
            EvaluationSeeder::class,
        ]);
    }
}
