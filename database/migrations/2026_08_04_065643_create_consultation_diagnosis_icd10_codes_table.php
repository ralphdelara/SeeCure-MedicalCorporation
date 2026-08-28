<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consultation_diagnosis_icd10_codes', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(gen_random_uuid())'));
            $table->foreignUuid('consultation_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('consultation_diagnosis_id')->constrained('consultation_diagnosis', 'id');
            $table->text('icd_code_id')->nullable();
            $table->foreignUuid('created_by')->constrained('users', 'id');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_diagnosis_icd10_codes');
    }
};
