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
        Schema::create('radiology', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('visit_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('consultation_id')->constrained()->cascadeOnDelete();

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
        Schema::dropIfExists('radiology');
    }
};
