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
    Schema::create('tour_spots', function (Blueprint $table) {
    $table->id();
    $table->string('name');       // Example: Cox's Bazar, Sylhet
    $table->string('location')->nullable(); // Optional: Division/District
    $table->decimal('entry_fee', 10, 2)->default(0); // optional ticket/guide cost
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_spots');
    }
};
