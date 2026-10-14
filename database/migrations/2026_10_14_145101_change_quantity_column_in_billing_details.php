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
            $table->decimal('quantity', 12, 2)->default(1)->change();
        });

        Schema::table('billing_supplies', function (Blueprint $table) {
            $table->decimal('stock', 12, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billing_details', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->change();
        });

        Schema::table('billing_supplies', function (Blueprint $table) {
            $table->integer('stock')->change();
        });
    }
};
