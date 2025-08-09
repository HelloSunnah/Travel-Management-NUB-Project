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
Schema::create('cache', function (Blueprint $table) {
    $table->string('key', 191)->primary(); // Limit key length to 191 characters
    $table->mediumText('value');
    $table->integer('expiration');
});


   Schema::create('cache_locks', function (Blueprint $table) {
    $table->string('key', 191)->primary();  // Limit 'key' to 191 characters
    $table->string('owner');
    $table->integer('expiration');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
