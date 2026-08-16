<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(gen_random_uuid())'));
            $table->foreignUuid('product_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('transaction_id')->constrained();
            $table->decimal('cost_price', 12, 2);
            $table->decimal('quantity', 12, 2);
            $table->decimal('stock_onhand', 12, 2);
            $table->foreignId('stock_movement_type_id')->constrained();
            $table->foreignUuid('supplier_id')->nullable()->constrained();
            $table->string('reference_no')->nullable();
            $table->date('manufacture_date')->nullable();
            $table->date('expiry_date')->nullable();
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
        Schema::dropIfExists('product_stocks');
    }
};
