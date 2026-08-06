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
        Schema::create('patient_vital_signs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('consultation_id')->nullable()->constrained();
            $table->foreignId('vital_sign_id')->constrained();
            $table->foreignId('vital_sign_field_id')->constrained();
            $table->decimal('value', 12);
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_vital_signs');
    }
};
