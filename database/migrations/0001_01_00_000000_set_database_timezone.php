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
        // Get the current database name dynamically
        $databaseName = DB::connection()->getDatabaseName();

        // Force PostgreSQL to use Asia/Manila for this database
        DB::statement("ALTER ROLE CURRENT_USER SET timezone TO 'Asia/Manila';");
        DB::statement("ALTER DATABASE \"{$databaseName}\" SET timezone TO 'Asia/Manila';");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
