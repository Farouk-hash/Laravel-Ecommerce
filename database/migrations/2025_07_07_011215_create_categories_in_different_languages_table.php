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
        Schema::create('categories_in_different_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categories_id')->references('id')->on('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('language_id')->references('id')->on('languages')->cascadeOnUpdate();
            $table->string('name');
            $table->longText('description');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_in_different_languages');
    }
};
