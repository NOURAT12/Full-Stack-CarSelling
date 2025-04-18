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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string(column: 'brand');
            $table->string(column: 'model');
            $table->string(column: 'year');
            $table->float(column: 'price');
            $table->json(column: 'carimages');
            $table->string(column: 'description')->nullable();
            $table->string(column: 'sold');
            $table->string(column: 'color');
            $table->string(column: 'city');
            $table->string(column: 'country');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
