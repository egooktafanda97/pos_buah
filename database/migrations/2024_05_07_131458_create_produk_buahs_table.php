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
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->string('gambar');
            $table->unsignedBigInteger('jenis_produk_id');
            $table->unsignedBigInteger('supplier_id');
            $table->integer('stok');
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
