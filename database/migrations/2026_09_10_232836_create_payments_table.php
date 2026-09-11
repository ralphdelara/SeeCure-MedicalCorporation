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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('receipt_sequence_header', 10);
            $table->unsignedBigInteger('receipt_sequence')->autoIncrement();
            $table->foreignUuid('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('visit_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('cashier_id')->constrained('cashier', 'id')->cascadeOnDelete();

            $table->foreignId('payment_method_id')->nullable()->constrained();
            $table->foreignId('payment_status_id')->constrained();
            $table->text('reference_number')->nullable();

            $table->decimal('total_amount', 12, 2)->nullable();
            $table->decimal('amount_received', 12, 2)->nullable();
            $table->decimal('amount_paid', 12, 2)->nullable();
            $table->decimal('amount_change', 12, 2)->nullable();

            $table->foreignUuid('created_by')->constrained('users', 'id');
            $table->foreignUuid('last_modified_by')->nullable()->constrained('users', 'id');
            $table->timestamps();
        });

        $driver = Schema::getConnection()->getDriverName();

        switch ($driver) {
            case 'mysql':
            case 'mariadb':
                DB::statement('ALTER TABLE payments AUTO_INCREMENT = 10000001;');
                break;
            case 'pgsql':
                // Alters the implicit sequence created by Laravel for auto-incrementing fields
                DB::statement('ALTER SEQUENCE payments_receipt_sequence_seq RESTART WITH 10000001;');
                break;
            case 'sqlsrv':
                // In SQL Server, we set it to 10000000 so the next automatic insertion hits 10000001
                DB::statement('DBCC CHECKIDENT (payments, RESEED, 10000000);');
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
        Schema::dropIfExists('payments');
    }
};
