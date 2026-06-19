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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            
            // The item being discussed
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            
            // The person sending the message
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            
            // The person receiving the message (the farmer/seller)
            $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
            
            // The actual message content
            $table->text('message');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
