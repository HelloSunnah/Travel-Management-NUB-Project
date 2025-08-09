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
        // Create 'users' table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email', 191)->unique(); // No 'change()', just create the column with 191 characters
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Create 'password_reset_tokens' table
  Schema::create('password_reset_tokens', function (Blueprint $table) {
    $table->string('email', 191)->primary(); // Use 191 characters for the email column
    $table->string('token');
    $table->timestamp('created_at')->nullable();
});

Schema::create('sessions', function (Blueprint $table) {
    $table->string('id', 191)->primary();  // Use 191 characters for the primary key
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->index();
    $table->string('ip_address', 45)->nullable();
    $table->text('user_agent')->nullable();
    $table->longText('payload');
    $table->integer('last_activity')->index();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'users' table
        Schema::dropIfExists('users');

        // Drop the 'password_reset_tokens' table
        Schema::dropIfExists('password_reset_tokens');

        // Drop the 'sessions' table
        Schema::dropIfExists('sessions');
    }
};
