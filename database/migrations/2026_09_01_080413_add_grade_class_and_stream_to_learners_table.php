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
        /*
         * Only add grade_class if it does not already exist.
         */
        if (!Schema::hasColumn('learners', 'grade_class')) {

            Schema::table('learners', function (Blueprint $table) {

                $table->string('grade_class')
                    ->nullable()
                    ->after('assessment_number');

            });

        }


        /*
         * Only add stream if it does not already exist.
         */
        if (!Schema::hasColumn('learners', 'stream')) {

            Schema::table('learners', function (Blueprint $table) {

                $table->enum('stream', [
                    'East',
                    'West'
                ])
                    ->nullable()
                    ->after('grade_class');

            });

        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('learners', 'grade_class')) {

            Schema::table('learners', function (Blueprint $table) {

                $table->dropColumn('grade_class');

            });

        }


        /*
         * We will not drop stream here because
         * it existed before this migration.
         */
    }
};
