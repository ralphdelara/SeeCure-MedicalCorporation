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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('contact_number1')->nullable();
            $table->string('contact_number2')->nullable();
            $table->text('email')->nullable();
            $table->string('occupation')->nullable();

            $table->string('house_no')->nullable();
            $table->text('street')->nullable();
            $table->foreignId('barangay_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->foreignId('province_id')->constrained();

            $table->text('photo')->nullable();
            $table->decimal('credit_limit', 12, 2)->constrained()->nullable();

            $table->foreignId('gender_id')->constrained()->nullable();
            $table->foreignId('civil_status_id')->constrained()->nullable();
            $table->foreignId('nationality_id')->constrained()->nullable();
            $table->foreignId('status_id')->constrained('patient_statuses', 'id')->nullable();
            $table->foreignId('patient_suffix_id')->constrained()->nullable();
            $table->foreignId('created_by')->constrained('users', 'id');
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
