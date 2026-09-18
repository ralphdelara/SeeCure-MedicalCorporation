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
        Schema::create('billing_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('billing_id')->constrained('billing', 'id')->cascadeOnDelete();
            $table->foreignId('billing_type_id')->constrained();

            $table->text('name');

            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('discount', 12, 2)->nullable();
            $table->foreignId('discount_type_id')->nullable()->constrained();
            $table->decimal('tax_percent', 12, 2)->nullable();
            $table->decimal('tax_amount', 12, 2)->nullable();
            $table->decimal('nett_price', 12, 2)->nullable();

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
        Schema::dropIfExists('billing_details');
    }
};
