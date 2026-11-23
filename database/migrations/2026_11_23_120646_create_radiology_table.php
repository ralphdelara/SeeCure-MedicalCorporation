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
        Schema::table('radiology', function (Blueprint $table) {
            if (Schema::hasColumn('radiology', 'consultation_id')) {
                $table->dropColumn('consultation_id');
            }

            if (Schema::hasColumn('radiology', 'patient_id')) {
                $table->dropConstrainedForeignId('patient_id');
            }

            $table->foreignUuid('patient_id')->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
