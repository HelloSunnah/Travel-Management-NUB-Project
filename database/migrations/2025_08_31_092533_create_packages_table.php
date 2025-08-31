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
        Schema::create('packages', function (Blueprint $table) {
    $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('days')->default(0);
            $table->integer('nights')->default(0);
            $table->enum('benefit_type',['fixed','percent'])->default('fixed');
            $table->decimal('benefit_value',10,2)->default(0);
            $table->decimal('total_cost',10,2)->default(0);
            $table->decimal('final_price',10,2)->default(0);
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
