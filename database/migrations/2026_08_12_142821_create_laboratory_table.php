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
            $table->id();
            $table->foreignId('visit_id')->constrained();
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('laboratory_type_id')->constrained();
            $table->text('data')->nullable();
            $table->foreignId('status_id')->constrained('laboratory_statuses', 'id');

            $table->foreignId('created_by')->constrained('users', 'id');
            $table->foreignId('last_modified_by')->nullable()->constrained('users', 'id');
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
