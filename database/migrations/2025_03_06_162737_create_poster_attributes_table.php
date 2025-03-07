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
        Schema::create('poster_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poster_id')->constrained()->onDelete('cascade');
            $table->foreignId('attribute_id')->constrained()->onDelete('cascade');
            $table->string('value');  // Masalan: '3', 'M', 'Petrol'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poster_attributes');
    }
};
