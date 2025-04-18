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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'full_name');
            $table->string(column: 'image');
            $table->string(column: 'ad_url');
            $table->integer(column: 'hit');
            $table->date(column: 'start_date');
            $table->date(column: 'end_date');
            $table->string(column: 'location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
