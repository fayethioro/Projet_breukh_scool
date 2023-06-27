<?php

namespace Database\Seeders;

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
            NiveauSeeder::class,
            ClasseSeeder::class,
        ]);
    }
}
