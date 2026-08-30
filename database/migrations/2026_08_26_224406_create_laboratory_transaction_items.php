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
        Schema::create('laboratory_transaction_items', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(gen_random_uuid())'));
            $table->foreignUuid('laboratory_id')->nullable()->constrained('laboratory', 'id')->nullOnDelete();
            $table->foreignUuid('laboratory_transaction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('laboratory_product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('laboratory_test_sub_type_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->decimal('quantity', 12, 2);
            $table->decimal('discount', 12, 2);
            $table->decimal('nett_price', 12, 2);
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
        Schema::dropIfExists('laboratory_transaction_items');
    }
};
