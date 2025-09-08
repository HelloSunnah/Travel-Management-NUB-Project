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
    $table->string('title');
    $table->foreignId('destination_id')->constrained()->onDelete('cascade');
    $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
    $table->foreignId('room_id')->constrained('hotel_rooms')->onDelete('cascade');
    $table->integer('nights')->default(1);
    $table->decimal('hotel_total_price',10,2)->default(0);
    $table->date('start_date');
    $table->date('end_date');
    $table->decimal('base_price',10,2)->default(0);
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
