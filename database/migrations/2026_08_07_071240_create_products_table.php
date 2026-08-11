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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->addColumn('citext', 'name')->unique(); 
            $table->foreignId('product_category_id')->constrained();
            $table->foreignId('product_unit_id')->constrained();
            $table->decimal('stock', 12, 2);
            $table->decimal('cost_price', 12, 2);
            $table->decimal('markup_amount', 12, 2); // selling - cost
            $table->decimal('markup_percent', 12, 2); // (markup amount / cost) x 100
            $table->decimal('vat_percent', 12, 2);
            $table->decimal('vat_amount', 12, 2);
            $table->decimal('selling_price_vat_exclusive', 12, 2);
            $table->decimal('selling_price_vat_inclusive', 12, 2);
            $table->text('photo')->nullable();
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->foreignId('last_modified_by')->nullable()->constrained('users', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
