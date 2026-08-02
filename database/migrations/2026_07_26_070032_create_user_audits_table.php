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
        Schema::create('user_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // constrained auto creates index
            $table->foreignId('audit_type_id')->constrained();
            $table->text('action');
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_audits');
    }
};
