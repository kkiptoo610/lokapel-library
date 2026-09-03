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
        Schema::table(
            'books',
            function (Blueprint $table) {

                /*
                |--------------------------------------------------------------------------
                | DROP OLD FOREIGN KEY
                |--------------------------------------------------------------------------
                */

                $table
                    ->dropForeign(
                        [
                            'subcategory_id',
                        ]
                    );


                /*
                |--------------------------------------------------------------------------
                | ADD NEW FOREIGN KEY
                |--------------------------------------------------------------------------
                */

                $table
                    ->foreign(
                        'subcategory_id'
                    )
                    ->references(
                        'id'
                    )
                    ->on(
                        'categories'
                    )
                    ->nullOnDelete();

            }
        );
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'books',
            function (Blueprint $table) {

                /*
                |--------------------------------------------------------------------------
                | REMOVE NEW FOREIGN KEY
                |--------------------------------------------------------------------------
                */

                $table
                    ->dropForeign(
                        [
                            'subcategory_id',
                        ]
                    );


                /*
                |--------------------------------------------------------------------------
                | RESTORE OLD FOREIGN KEY
                |--------------------------------------------------------------------------
                */

                $table
                    ->foreign(
                        'subcategory_id'
                    )
                    ->references(
                        'id'
                    )
                    ->on(
                        'subcategories'
                    )
                    ->nullOnDelete();

            }
        );
    }
};