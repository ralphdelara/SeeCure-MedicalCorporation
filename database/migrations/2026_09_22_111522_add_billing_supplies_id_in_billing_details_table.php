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
        Schema::table('billing_details', function (Blueprint $table) {
            $table->foreignId('billing_supplies_id')
                ->after('billing_id')
                ->nullable()
                ->constrained('billing_supplies', 'id')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billing_details', function (Blueprint $table) {
            $table->dropColumn('billing_supplies_id');
        });
    }
};
