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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('cashier_id')->constrained('cashier', 'id')->cascadeOnDelete();
            $table->foreignId('payment_method_id')->nullable()->constrained();
            $table->foreignId('payment_status_id')->constrained();

            $table->string('transaction_header', 10);
            $table->unsignedBigInteger('transaction_no')->autoIncrement();
            $table->text('reference_number')->nullable();

            $table->decimal('total_amount', 12, 2)->nullable();
            $table->decimal('amount_received', 12, 2)->nullable();
            $table->decimal('amount_paid', 12, 2)->nullable();
            $table->decimal('amount_change', 12, 2)->nullable();

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
        Schema::dropIfExists('payments');
    }
};
