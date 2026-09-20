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
        Schema::create('consultation_signs_or_symptoms', function (Blueprint $table) {
            $table->foreignUuid('consultation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('signs_or_symptom_id')->constrained();
            $table->primary(['consultation_id', 'signs_or_symptom_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_signs_or_symptoms');
    }
};
