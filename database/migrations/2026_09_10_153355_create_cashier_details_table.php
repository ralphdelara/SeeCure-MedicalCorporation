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
        Schema::create('cashier_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('cashier_id')->constrained('cashier', 'id')->cascadeOnDelete();

            $table->foreignId('cashier_type_id')->constrained();

            $table->text('name');

            $table->decimal('cost_price', 12, 2)->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 12, 2)->nullable();

            $table->decimal('discount', 12, 2)->nullable();
            $table->foreignId('discount_type_id')->nullable()->constrained();
            $table->decimal('tax_percent', 12, 2)->nullable();
            $table->decimal('tax_amount', 12, 2)->nullable();
            $table->decimal('nett_price', 12, 2)->nullable();
            $table->unsignedBigInteger('order')->autoIncrement()->unique();

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
        Schema::dropIfExists('cashier_details');
    }
};
