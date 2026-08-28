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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(gen_random_uuid())'));
            $table->string('username')->unique();
            $table->string('password');

            $table->text('last_name');
            $table->text('first_name');
            $table->text('middle_name')->nullable();

            $table->foreignId('gender_id')->nullable()->constrained()->nullOnDelete();
            $table->string('date_of_birth')->nullable();

            $table->string('contact_number')->nullable();
            $table->text('email')->nullable();

            $table->string('house_no')->nullable();
            $table->text('street')->nullable();
            $table->foreignId('barangay_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->foreignId('province_id')->nullable();
            $table->string('license_no')->nullable();
            $table->string('ptr_no')->nullable();
            $table->string('date_hired')->nullable();
            $table->string('date_resigned')->nullable();
            $table->boolean('status');
            $table->rememberToken();
            $table->foreignId('department_id')->constrained();
            $table->foreignId('position_id')->constrained();
            $table->text('photo')->nullable();

            $table->text('username_index')->nullable()->index();
            $table->text('last_name_index')->nullable()->index();
            $table->text('first_name_index')->nullable()->index();
            $table->text('middle_name_index')->nullable()->index();

            $table->unsignedBigInteger('batch')->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('last_modified_by')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->foreign('last_modified_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignUuid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
