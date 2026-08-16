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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(gen_random_uuid())'));
            $table->foreignId('transaction_type_id')->constrained();
            $table->string('patient_id');
            $table->foreignUuid('consultation_id')->nullable()->constrained();
            $table->text('customer_name')->nullable();
            $table->decimal('consultation_service_amount', 12, 2);
            $table->decimal('laboratory_service_amount', 12, 2);
            $table->decimal('total_product_price', 12, 2);
            $table->decimal('total_product_selling_price', 12, 2);
            $table->decimal('total_discounts', 12, 2)->nullable();
            $table->decimal('net_price', 12, 2); // total selling price - total discounts
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
