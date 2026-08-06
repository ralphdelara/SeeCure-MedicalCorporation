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
            $table->foreignId('patient_id')->constrained();

            $table->text('guardian_name')->nullable();
            $table->string('guardian_contact_number')->nullable();
            $table->text('guardian_email')->nullable();

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
