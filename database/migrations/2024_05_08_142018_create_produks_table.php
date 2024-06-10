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
        Schema::create('rak', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger('toko_id');
            $table->integer('nomor');
            $table->string('nama');
            $table->integer('kapasitas');
            $table->timestamps();
            $table->foreign('toko_id')->references('id')->on('toko');
        });
        Schema::create('produks', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedInteger('toko_id');
            $table->unsignedBigInteger("user_id");
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->default('default.jpg');
            $table->unsignedBigInteger('jenis_produk_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('barcode', 100)->nullable();
            $table->integer('diskon')->nullable()->default(0);
            $table->unsignedInteger('rak_id')->nullable();
            $table->unsignedBigInteger('satuan_jual_terkecil_id');
            $table->foreign('satuan_jual_terkecil_id')->references('id')->on('jenis_satuans');
            $table->unsignedInteger('status_id');
            $table->foreign('status_id')->references('id')->on('status');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jenis_produk_id')->references('id')->on('jenis_produks')->onDelete('cascade');
            $table->foreign('toko_id')->references('id')->on('toko')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
        Schema::dropIfExists('rak');
    }
};
