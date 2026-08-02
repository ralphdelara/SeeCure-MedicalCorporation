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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            // front desk input
            $table->foreignId('patient_id')->constrained();
            $table->text('reason');
            $table->string('last_menstrual_date')->nullable();
            $table->string('hypertensive')->nullable();
            $table->string('diabetic')->nullable();
            $table->string('asthmatic')->nullable();
            $table->string('drug_allergy')->nullable();
            $table->string('drug_allergy_text')->nullable();
            $table->string('food_allergy')->nullable();
            $table->string('food_allergy_text')->nullable();

            // doctor input
            $table->text('subjective')->nullable();
            $table->text('assessment')->nullable();
            $table->text('plan')->nullable();
            $table->text('diagnosis')->nullable();

            $table->foreignId('status_id')->constrained('consultation_statuses', 'id');
            $table->foreignId('doctor_id')->constrained('users', 'id');
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
