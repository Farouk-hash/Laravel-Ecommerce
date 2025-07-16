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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billing_addresses_id')->references('id')->on('billing_addresses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('carts_id')->references('id')->on('carts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('status',['pending','shipped','paid','cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
