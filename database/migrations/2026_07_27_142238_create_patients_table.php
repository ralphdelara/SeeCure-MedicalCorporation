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
            $table->text('last_name');
            $table->text('first_name');
            $table->text('middle_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('age')->nullable();
            $table->string('contact_number1')->nullable();
            $table->string('contact_number2')->nullable();
            $table->text('email')->nullable();
            $table->string('occupation')->nullable();
            $table->text('philhealth_id')->nullable();

            $table->string('house_no')->nullable();
            $table->text('street')->nullable();
            $table->foreignId('barangay_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('province_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('gender_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('civil_status_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('nationality_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('status_id')->constrained('patient_statuses', 'id');
            $table->foreignId('patient_suffix_id')->nullable()->constrained()->nullOnDelete();
            $table->text('photo')->nullable();

            $table->text('last_name_index')->nullable()->index();
            $table->text('first_name_index')->nullable()->index();
            $table->text('middle_name_index')->nullable()->index();

            $table->unsignedBigInteger('batch')->nullable();

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
