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
            $table->uuid('id')->primary();
            $table->foreignUuid('visit_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('patient_id')->constrained()->cascadeOnDelete();

            $table->text('guardian_name')->nullable();
            $table->string('guardian_contact_number')->nullable();
            $table->text('guardian_email')->nullable();
            $table->foreignId('guardian_relationship_id')->nullable()->constrained('relationships', 'id');

            $table->boolean('is_completed')->default(false);

            $table->date('follow_up_date')->nullable();
            $table->foreignUuid('doctor_id')->constrained('users', 'id');
            $table->foreignUuid('created_by')->constrained('users', 'id');
            $table->foreignUuid('last_modified_by')->nullable()->constrained('users', 'id');
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
