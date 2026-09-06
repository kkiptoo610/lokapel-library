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
        Schema::create('inventory_issues', function (Blueprint $table) {

            $table->id();

            $table->foreignId('inventory_item_id')
                ->constrained('inventory_items')
                ->cascadeOnDelete();

            $table->foreignId('teacher_id')
                ->nullable()
                ->constrained('teachers')
                ->nullOnDelete();

            $table->string('department')
                ->nullable();

            $table->integer('quantity');

            $table->date('issued_date');

            $table->text('remarks')
                ->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_issues');
    }
};