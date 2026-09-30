<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add the new columns to the patients table (they will naturally be NULL for all existing rows)
        Schema::table('patients', function (Blueprint $table) {
            $table->string('old_patient_id')->after('id')->nullable();
            $table->unsignedBigInteger('control_no')->after('old_patient_id')->nullable();
        });

        // Create the PostgreSQL function and trigger for incoming future inserts
        DB::unprepared('
            CREATE OR REPLACE FUNCTION set_next_control_no()
            RETURNS TRIGGER AS $$
            BEGIN
                -- If control_no is not provided, find the max and add 1
                -- If all existing rows are NULL, MAX(control_no) returns NULL, so COALESCE sets it to 0 + 1 = 1
                IF NEW.control_no IS NULL THEN
                    NEW.control_no := COALESCE((SELECT MAX(control_no) FROM patients), 0) + 1;
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;

            CREATE TRIGGER trigger_set_control_no
            BEFORE INSERT ON patients
            FOR EACH ROW
            EXECUTE FUNCTION set_next_control_no();
        ');
    }

    public function down(): void
    {
        // Drop the trigger and function first
        DB::unprepared('DROP TRIGGER IF EXISTS trigger_set_control_no ON patients;');
        DB::unprepared('DROP FUNCTION IF EXISTS set_next_control_no();');

        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['old_patient_id', 'control_no']);
        });
    }
};