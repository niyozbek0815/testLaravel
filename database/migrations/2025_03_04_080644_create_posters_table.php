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
        Schema::create('posters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('region_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 16, 2);
            $table->integer('rooms')->default(0);
            $table->integer('bathrooms')->default(0);
            $table->integer('area')->default(0);
            $table->unsignedBigInteger('views')->default(0);
            $table->string('type')->default('sale');
            $table->boolean('furnished')->default(false);
            $table->boolean('garage')->default(value: false);
            $table->boolean('status')->default(value: true);
            $table->boolean('negotiable')->default(false);
            $table->string('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Posters');
    }
};