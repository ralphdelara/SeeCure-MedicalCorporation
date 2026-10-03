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
        Schema::table('inventory_stock_movements', function (Blueprint $table) {
            $table->date('expiry_date')->nullable()->change();
            $table->date('manufacture_date')->nullable()->change();
            $table->string('lot_no', 50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_stock_movements', function (Blueprint $table) {
            $table->date('expiry_date')->change();
            $table->date('manufacture_date')->change();
            $table->string('lot_no', 50)->change();
        });
    }
};
