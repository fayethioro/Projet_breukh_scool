<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnneeScolaire;

class AnneeScolaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $anneeScolaire = new AnneeScolaire();
        $anneeScolaire->libelle = '2021-2022';
        $anneeScolaire->status = 1;
        $anneeScolaire->save();

        $anneeScolaire = new AnneeScolaire();
        $anneeScolaire->libelle = '2022-2023';
        $anneeScolaire->status = 0;
        $anneeScolaire->save();

        // Ajoutez d'autres années scolaires si nécessaire

        $this->command->info('Seed AnneeScolaireSeeder terminé !');
    }
}

