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

        // Booking details
      Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Link to package
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');

            // Optional: if user logged in
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Customer info
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');

            // Booking details
            $table->date('booking_date');
            $table->unsignedInteger('adults')->default(1);
            $table->unsignedInteger('children')->default(0);

            $table->decimal('total_price', 12, 2)->default(0);
            $table->text('note')->nullable();

            // Status
            $table->enum('status', ['pending', 'approved', 'cancelled'])->default('pending');

            $table->timestamps();
    });
}

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
