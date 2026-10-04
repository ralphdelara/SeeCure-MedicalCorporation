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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('amount_change');
            $table->string('customer_address')->nullable()->after('customer_name');
            $table->foreignId('discount_type_id')->nullable()->constrained()
                ->after('customer_address');
            $table->string('id_no', 50)->nullable()->after('discount_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'customer_address',
                'discount_type_id',
                'id_no',
            ]);
        });
    }
};
