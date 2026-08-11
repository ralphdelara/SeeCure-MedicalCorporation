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
        Schema::create('consultation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained();
            $table->text('subjective')->nullable();
            $table->text('assessment')->nullable();
            $table->text('plan')->nullable();
            $table->text('diagnosis')->nullable();
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
        Schema::dropIfExists('consultation_details');
    }
};
