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
        Schema::create('laboratory_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laboratory_id')->constrained('laboratory', 'id');
            $table->foreignId('laboratory_test_type_id')->constrained();
            $table->text('data');

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
        Schema::dropIfExists('laboratory_tests');
    }
};
