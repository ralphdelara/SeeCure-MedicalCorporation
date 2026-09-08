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
        Schema::create('visit_priority_types', function (Blueprint $table) {
            $table->foreignUuid('visit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('priority_type_id')->constrained()->cascadeOnDelete();
            $table->primary(['visit_id', 'priority_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_priority_types');
    }
};
