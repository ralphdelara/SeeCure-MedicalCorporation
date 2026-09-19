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
        Schema::create('consultation_soap', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('consultation_id')->unique()->constrained()->cascadeOnDelete();
            $table->text('subjective')->nullable();
            $table->text('assessment')->nullable();
            $table->text('plan')->nullable();
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
        Schema::dropIfExists('consultation_soap');
    }
};
