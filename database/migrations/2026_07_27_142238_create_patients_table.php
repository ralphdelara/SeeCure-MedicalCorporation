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
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(gen_random_uuid())'));
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('age')->nullable();
            $table->string('contact_number1')->nullable();
            $table->string('contact_number2')->nullable();
            $table->text('email')->nullable();
            $table->string('occupation')->nullable();
            $table->text('philhealth_id')->nullable();

            $table->string('house_no')->nullable();
            $table->text('street')->nullable();
            $table->foreignId('barangay_id')->nullable()->constrained();
            $table->foreignId('city_id')->nullable()->constrained();
            $table->foreignId('province_id')->nullable()->constrained();

            $table->foreignId('gender_id')->nullable()->constrained();
            $table->foreignId('civil_status_id')->nullable()->constrained();
            $table->foreignId('nationality_id')->nullable()->constrained();
            $table->foreignId('status_id')->constrained('patient_statuses', 'id');
            $table->foreignId('patient_suffix_id')->nullable()->constrained();
            $table->text('photo')->nullable();

            $table->string('first_name_index')->nullable()->index();
            $table->string('last_name_index')->nullable()->index();

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
        Schema::dropIfExists('patients');
    }
};
