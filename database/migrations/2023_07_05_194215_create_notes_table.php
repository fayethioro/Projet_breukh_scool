<?php

use App\Models\Inscription;
use App\Models\NoteMaximal;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Inscription::class)->constrained();
            $table->foreignIdFor(NoteMaximal::class)->constrained();
            $table->float('note');
            $table->boolean('Etat')->default(1);
            $table->unique([
                'note_maximal_id', 'inscription_id'
        ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
