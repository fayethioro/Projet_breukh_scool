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
        Schema::table('note_maximals', function (Blueprint $table) {
            $table->unique([
                'classe_id', 'discipline_id', 'evaluation_id', 'semestre_id'
        ], 'note_maximals_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('note_maximals', function (Blueprint $table) {
            //
        });
    }
};
