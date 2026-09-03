<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE book_copies
            MODIFY COLUMN status
            ENUM('available', 'borrowed', 'damaged')
            NOT NULL
            DEFAULT 'available'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE book_copies
            MODIFY COLUMN status
            ENUM('available', 'borrowed')
            NOT NULL
            DEFAULT 'available'
        ");
    }
};