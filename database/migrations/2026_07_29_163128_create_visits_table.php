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
        Schema::create('visits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('visit_status_id')->constrained();
            if (DB::connection()->getDriverName() !== 'sqlite') {
                $table->unsignedBigInteger('visit_no')->alwaysIdentity();
            } else {
                $table->unsignedBigInteger('visit_no')->nullable();
            }

            $table->dateTime('admitted_at')->nullable();
            $table->dateTime('discharged_at')->nullable();

            $table->boolean('has_consultation')->default(false);
            $table->boolean('has_laboratory')->default(false);
            $table->boolean('has_radiology')->default(false);
            $table->boolean('is_emergency')->default(false);
            $table->boolean('is_walk_in')->default(false);

            $table->foreignUuid('created_by')->constrained('users', 'id');
            $table->foreignUuid('last_modified_by')->nullable()->constrained('users', 'id');
            $table->timestamps();

            $table->index('visit_status_id');
            // Fast lookups for finding a patient's open or historical stays
            $table->index(['patient_id', 'discharged_at']);
            // Great for reporting analytics by date ranges
            $table->index('admitted_at');
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
