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
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string('species_name');
            $table->string('slug')->unique();
            $table->string('common_name')->nullable();
            $table->string('common_name_th')->nullable();
            $table->string('genus')->nullable();
            $table->string('family')->nullable();
            $table->json('images');  // Storing the array as JSON
            $table->integer('num_images')->default(0);
            $table->integer('num_observations')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
