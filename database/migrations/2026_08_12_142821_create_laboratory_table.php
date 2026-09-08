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
        Schema::create('laboratory', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('visit_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignUuid('patient_id')->nullable()->constrained()->cascadeOnDelete();
            // nullOnDelete because the data can still be accessed via patient details
            $table->foreignUuid('consultation_id')->nullable()->constrained()->nullOnDelete();
            // for walk in patients with lab request purpose only
            $table->text('patient_name')->nullable();

            $table->boolean('is_completed')->default(false);

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
        Schema::dropIfExists('laboratory');
    }
};
