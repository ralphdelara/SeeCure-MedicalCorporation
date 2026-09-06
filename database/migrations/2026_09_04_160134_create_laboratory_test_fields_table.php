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
        Schema::create('laboratory_test_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laboratory_test_id')->constrained()->cascadeOnDelete();
            $table->text('name');
            $table->string('unit', 20)->nullable();
            $table->string('field_type', 20)->nullable();
            $table->decimal('normal_range_both_min', 12, 2)->nullable();
            $table->decimal('normal_range_both_max', 12, 2)->nullable();
            $table->decimal('normal_range_male_min', 12, 2)->nullable();
            $table->decimal('normal_range_male_max', 12, 2)->nullable();
            $table->decimal('normal_range_female_min', 12, 2)->nullable();
            $table->decimal('normal_range_female_max', 12, 2)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratory_test_fields');
    }
};
