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
        Schema::table('laboratory_package_data', function (Blueprint $table) {
            $table->dropForeign(['laboratory_id']);
        });

        Schema::table('laboratory_package_data', function (Blueprint $table) {
            $table->uuid('laboratory_id')
                ->change()
                ->constrained('laboratory', 'id')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laboratory_package_data', function (Blueprint $table) {
            //
        });
    }
};
