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
    {Schema::create('package_foods', function (Blueprint $table) {
    $table->id();
    $table->foreignId('package_id')->constrained()->onDelete('cascade');
    $table->foreignId('food_id')->constrained()->onDelete('cascade');
    $table->integer('quantity')->default(1); // number of times this menu is included
    $table->decimal('total_price',10,2)->default(0); // price * quantity
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_foods');
    }
};
