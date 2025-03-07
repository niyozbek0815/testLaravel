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
            $table->decimal('price', 16, 2)->nullable();
            $table->enum('type', ['sale', 'rent', 'service', 'exchange'])->default('sale');
            $table->boolean('negotiable')->default(false);
            $table->unsignedBigInteger('views')->default(0);
            $table->boolean('status')->default(true);
            $table->string('images')->nullable(); // JSON shaklida saqlash
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
