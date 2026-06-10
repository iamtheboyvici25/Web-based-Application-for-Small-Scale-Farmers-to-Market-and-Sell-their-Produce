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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            
            // This links the listing directly to the farmer who posted it
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Listing Details
            $table->string('title'); // e.g., "Fresh Organic Tomatoes"
            $table->text('description'); // e.g., "Picked this morning..."
            $table->decimal('price', 8, 2); // Allows prices up to 999,999.99
            $table->integer('quantity'); // e.g., 50
            $table->string('unit')->default('kg'); // e.g., "kg", "bunches", "sacks"
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
