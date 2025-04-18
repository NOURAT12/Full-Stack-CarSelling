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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'website_name');
            $table->string(column: 'website_image');
            $table->string(column: 'logo');
            $table->string(column: 'facebook');
            $table->string(column: 'instgram');
            $table->string(column: 'whatsapp');
            $table->string(column: 'phone');
            $table->string(column: 'mobile');
            $table->json(column: 'titles');
            $table->json(column: 'images');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
