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
        Schema::create('stok_detail', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger("stok_id");
            $table->unsignedInteger('toko_id');
            $table->unsignedBigInteger('produks_id');
            $table->integer('jumlah')->default(0);
            $table->integer('jumlah_sebelumnya');
            $table->unsignedBigInteger('satuan_id');
            $table->enum('tipe', ["masuk", "keluar"]);
            $table->timestamps();

            $table->foreign('produks_id')->references('id')->on('produks')->onDelete('cascade');
            $table->foreign('toko_id')->references('id')->on('toko');
            $table->foreign('satuan_id')->references('id')->on('jenis_satuans');
            $table->foreign('stok_id')->references('id')->on('stoks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_detail');
    }
};
