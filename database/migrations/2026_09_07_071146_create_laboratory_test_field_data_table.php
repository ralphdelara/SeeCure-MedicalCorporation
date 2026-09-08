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
        Schema::create('laboratory_test_field_data', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('laboratory_id')->constrained('laboratory', 'id')->cascadeOnDelete();
            $table->foreignUuid('laboratory_test_data_id')->constrained('laboratory_test_data', 'id');
            $table->foreignId('laboratory_test_field_id')->constrained();
            $table->text('value')->nullable();
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
        Schema::dropIfExists('laboratory_test_field_data');
    }
};
