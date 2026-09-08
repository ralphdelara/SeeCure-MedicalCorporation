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
        Schema::create('laboratory_test_data', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('laboratory_id')->constrained('laboratory', 'id')->cascadeOnDelete();
            $table->foreignId('laboratory_package_id')->nullable()->constrained();
            $table->foreignId('laboratory_type_id')->constrained();
            $table->foreignId('laboratory_test_id')->constrained();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('laboratory_test_data');
    }
};
