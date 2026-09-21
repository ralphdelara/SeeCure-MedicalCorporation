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
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('consultation_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('laboratory_id')->nullable()->constrained('laboratory', 'id')->nullOnDelete();
            $table->foreignUuid('radiology_id')->nullable()->constrained('radiology', 'id')->nullOnDelete();
            $table->foreignId('document_type_id')->constrained();
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
        Schema::dropIfExists('documents');
    }
};
