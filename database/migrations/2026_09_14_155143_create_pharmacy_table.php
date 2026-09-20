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
        Schema::create('pharmacy', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('visit_id')->constrained()->cascadeOnDelete();

            $table->decimal('total_cost_price', 12, 2)->nullable();
            $table->decimal('total_quantity', 12)->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->decimal('total_discount', 12, 2)->nullable();
            $table->decimal('total_tax', 12, 2)->nullable();
            $table->decimal('total_nett_price', 12, 2)->nullable();

            $table->boolean('is_completed')->default(false);

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
        Schema::dropIfExists('pharmacy');
    }
};
