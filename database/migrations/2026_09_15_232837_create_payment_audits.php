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
        Schema::create('payment_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('payment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('audit_type_id')->constrained();
            $table->text('data');
            $table->foreignUuid('created_by')->constrained('users', 'id');
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_audits');
    }
};
