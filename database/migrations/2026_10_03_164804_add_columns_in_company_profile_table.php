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
        Schema::table('company_profile', function (Blueprint $table) {
            $table->string('non_vat_tin', 50)->nullable()->after('company_reg_no');
            $table->string('min', 50)->nullable()->after('non_vat_tin');
            $table->string('sn', 50)->nullable()->after('min');
            $table->string('accreditation_no', 50)->nullable()->after('sn');
            $table->date('accreditation_date_issued')->nullable()->after('accreditation_no');
            $table->string('ptu_no', 50)->nullable()->after('accreditation_date_issued');
            $table->date('ptu_date_issued')->nullable()->after('ptu_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_profile', function (Blueprint $table) {
            $table->dropColumn([
                'non_vat_tin',
                'min',
                'sn',
                'accreditation_no',
                'accreditation_date_issued',
                'ptu_no',
                'ptu_date_issued',
            ]);
        });
    }
};
