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
        Schema::create('produk_buahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('harga'); 
            $table->integer('stok');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_buahs');
    }
};
