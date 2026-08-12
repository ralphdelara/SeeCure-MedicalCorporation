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
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->boolean('has_consultation')->default(false);
            $table->boolean('has_laboratory')->default(false);
            $table->boolean('has_radiology')->default(false);
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->foreignId('last_modified_by')->nullable()->constrained('users', 'id');
            $table->timestamps();

            $table->index(['has_consultation', 'has_laboratory', 'has_radiology']);
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
