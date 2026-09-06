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
        Schema::create('laboratory_package_tests', function (Blueprint $table) {
            $table->foreignId('laboratory_package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('laboratory_test_id')->constrained()->cascadeOnDelete();
            $table->primary(['laboratory_package_id', 'laboratory_test_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratory_package_tests');
    }
};
