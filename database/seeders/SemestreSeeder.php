<?php

namespace Database\Seeders;

use App\Models\Semestre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemestreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $semestre = new Semestre();
        $semestre->libelle = 'Semestre 1';
        $semestre->status = 1;
        $semestre->save();

        $semestre = new semestre();
        $semestre->libelle = 'Semestre 2';
        $semestre->status = 0;
        $semestre->save();

        // Ajoutez d'autres années scolaires si nécessaire

        $this->command->info('Seed semestreSeeder terminé !');
    }
}
