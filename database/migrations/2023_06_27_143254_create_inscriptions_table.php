<?php

use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\Eleve;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('date_inscription');
            $table->foreignIdFor(Eleve::class);
            $table->foreignIdFor(Classe::class);
            $table->foreignIdFor(AnneeScolaire::class);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
