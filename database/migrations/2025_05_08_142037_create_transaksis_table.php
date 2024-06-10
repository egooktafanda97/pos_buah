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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedInteger('toko_id');
            $table->unsignedBigInteger('kasir_id');
            $table->unsignedBigInteger('user_id');
            $table->string('invoice');
            $table->date('tanggal');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->integer('diskon')->default(0);
            $table->integer('total_belanja');
            $table->integer('total_bayar');
            $table->integer('kembalian')->nullable();
            $table->unsignedInteger('payment_type_id');
            $table->integer('pph')->default(0);
            $table->unsignedInteger('status_id')->default(1);
            $table->timestamps();

            $table->foreign('toko_id')->references('id')->on('toko')->onDelete('cascade');
            $table->foreign('kasir_id')->references('id')->on('kasir')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
