<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(gen_random_uuid())'));
            $table->foreignUuid('patient_id')->constrained()->cascadeOnDelete();
            $table->boolean('has_consultation')->default(false);
            $table->boolean('has_laboratory')->default(false);
            $table->boolean('has_radiology')->default(false);
            $table->boolean('consultation_completed')->default(false);
            $table->boolean('lab_completed')->default(false);
            $table->boolean('radiology_completed')->default(false);
            $table->foreignUuid('created_by')->constrained('users', 'id');
            $table->foreignUuid('last_modified_by')->nullable()->constrained('users', 'id');
            $table->timestamps();

            $table->index(['has_consultation', 'consultation_completed']);
            $table->index(['has_laboratory', 'lab_completed']);
            $table->index(['has_radiology', 'radiology_completed']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
