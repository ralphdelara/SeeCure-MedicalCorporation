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
        Schema::create('laboratory_test_field_data', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('laboratory_id')->constrained('laboratory', 'id')->cascadeOnDelete();
            $table->foreignUuid('laboratory_test_data_id')->constrained('laboratory_test_data', 'id');
            $table->foreignId('laboratory_test_field_id')->constrained();
            $table->unsignedInteger('order_no')->autoIncrement();
            $table->text('value')->nullable();
            $table->foreignUuid('created_by')->constrained('users', 'id');
            $table->foreignUuid('last_modified_by')->nullable()->constrained('users', 'id');
            $table->timestamps();
        });

        

        $driver = Schema::getConnection()->getDriverName();

        switch ($driver) {
            case 'mysql':
            case 'mariadb':
                DB::statement('ALTER TABLE laboratory_test_field_data AUTO_INCREMENT = 1;');
                break;
            case 'pgsql':
                // Alters the implicit sequence created by Laravel for auto-incrementing fields
                DB::statement('ALTER SEQUENCE laboratory_test_field_data_order_no_seq RESTART WITH 1;');
                break;
            case 'sqlsrv':
                // In SQL Server, we set it to 0 so the next automatic insertion hits 1
                DB::statement('DBCC CHECKIDENT (laboratory_test_field_data, RESEED, 0);');
                break;
            default:
                // For SQLite (often used for lightweight local test suites),
                // altering the starting auto-increment value mid-migration requires
                // manually manipulating the internal sqlite_sequence system table.
                // Typically, it is safest to skip this line during quick local SQLite testing.
                break;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratory_test_field_data');
    }
};
