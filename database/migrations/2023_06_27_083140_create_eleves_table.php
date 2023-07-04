<?php

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
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nom');
            $table->string('prenom');
            $table->dateTime('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('sexe');
            $table->boolean('profil');
            $table->integer('code')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('etat')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};
