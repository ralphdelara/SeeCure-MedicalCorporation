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
        Schema::create('company_profile', function (Blueprint $table) {
            $table->tinyInteger('id')->primary()->default(1); 
            $table->string('company_name');
            $table->string('company_reg_no')->nullable();
            $table->string('bir_no')->nullable();

            $table->string('tel_no')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->string('clinic_hours')->nullable();

            $table->string('address')->nullable();
            $table->string('landmark')->nullable();

            $table->foreignUuid('last_modified_by')->constrained('users', 'id');
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Safe database-level enforcement for a single row
        DB::statement('ALTER TABLE company_profile ADD CONSTRAINT chk_single_company CHECK (id = 1)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profile');
    }
};
