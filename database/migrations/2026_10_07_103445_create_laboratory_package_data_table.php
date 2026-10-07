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
        Schema::create('laboratory_package_data', function (Blueprint $table) {
            $table->foreignUuid('laboratory_id')->constrained('laboratory', 'id');
            $table->foreignId('laboratory_package_id')->constrained();
            $table->primary(['laboratory_id', 'laboratory_package_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratory_package_data');
    }
};
