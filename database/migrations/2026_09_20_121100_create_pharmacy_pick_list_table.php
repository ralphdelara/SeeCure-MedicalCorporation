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
        Schema::create('pharmacy_pick_lists', function (Blueprint $table) {
            $table->id('transaction_no');
            $table->foreignUuid('pharmacy_id')->constrained('pharmacy', 'id');
            $table->foreignUuid('created_by')->constrained('users', 'id');
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacy_pick_lists');
    }
};
