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
        Schema::create('patient_guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->text('name');
            $table->string('contact_number')->nullable();
            $table->text('email')->nullable();
            $table->foreignId('relationship_id')->constrained();
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_guardians');
    }
};
