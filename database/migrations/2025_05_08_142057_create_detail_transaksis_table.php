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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedInteger('toko_id');
            $table->unsignedBigInteger('kasir_id');
            $table->unsignedBigInteger('user_id');
            $table->string('invoice');
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('produks_id');
            $table->unsignedBigInteger('harga_id');
            $table->unsignedBigInteger('satuan_id');
            $table->integer('jumlah');
            $table->integer('total');
            $table->integer('diskon')->default(0);
            $table->unsignedInteger('status_id')->default(1);
            $table->timestamps();

            $table->foreign('transaksi_id')->references('id')->on('transaksi')->onDelete('cascade');
            $table->foreign('produks_id')->references('id')->on('produks')->onDelete('cascade');
            $table->foreign('satuan_id')->references('id')->on('jenis_satuans');
            $table->foreign('harga_id')->references('id')->on('harga');
            $table->foreign('kasir_id')->references('id')->on('kasir')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('toko_id')->references('id')->on('toko')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
