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
        Schema::create('inventory_stock_movements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('inventory_id')->constrained('inventory', 'id')->cascadeOnDelete();
            $table->foreignId('stock_movement_type_id')->constrained();
            $table->decimal('cost_price', 12, 2);
            $table->decimal('current_stock', 12, 2);
            $table->decimal('quantity', 12, 2);
            $table->decimal('new_stock', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->string('lot_no', 50);
            $table->date('manufacture_date');
            $table->date('expiry_date');
            $table->string('supplier')->nullable();
            $table->string('reference_no')->nullable();
            $table->foreignUuid('created_by')->constrained('users', 'id');
            $table->foreignUuid('last_modified_by')->constrained('users', 'id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_stock_movements');
    }
};
