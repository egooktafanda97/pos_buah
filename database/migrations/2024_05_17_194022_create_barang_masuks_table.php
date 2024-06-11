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

        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("kode");
            $table->unsignedInteger('toko_id');
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("produks_id");
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->integer('harga_beli');
            $table->unsignedBigInteger('satuan_beli_id');
            $table->integer('jumlah_selebelumnya');
            $table->integer('jumlah_barang_masuk');
            // $table->integer('jumlah');
            $table->integer('jumlah_barang_keluar')->default(0);
            $table->unsignedInteger('status_id')->default(1);
            $table->foreign('status_id')->references('id')->on('status');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('produks_id')->references('id')->on('produks')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('satuan_beli_id')->references('id')->on('jenis_satuans')->onDelete('cascade');
            $table->foreign('toko_id')->references('id')->on('toko')->onDelete('cascade');
        });

        Schema::create('konversisatuan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('toko_id');
            $table->unsignedBigInteger('produks_id');
            $table->unsignedBigInteger('satuan_id');
            $table->unsignedBigInteger('satuan_konversi_id');
            $table->integer('nilai_konversi');
            $table->unsignedInteger('status_id')->default(1);
            $table->timestamps();

            $table->foreign('produks_id')->references('id')->on('produks')->onDelete('cascade');
            $table->foreign('satuan_id')->references('id')->on('jenis_satuans')->onDelete('cascade');
            $table->foreign('satuan_konversi_id')->references('id')->on('jenis_satuans')->onDelete('cascade');
            $table->foreign('toko_id')->references('id')->on('toko')->onDelete('cascade');
        });

        Schema::create('log_barang_masuk', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("kode");
            $table->unsignedInteger('toko_id');
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("produks_id");
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->integer('harga_beli');
            $table->unsignedBigInteger('satuan_beli_id');
            $table->integer('jumlah_selebelumnya');
            $table->integer('jumlah_barang_masuk');
            // $table->integer('jumlah');
            $table->integer('jumlah_barang_keluar')->default(0);
            $table->integer('stok_sisa');
            $table->unsignedBigInteger('satuan_stok_id');
            $table->unsignedInteger('status_id')->default(1);
            $table->foreign('status_id')->references('id')->on('status');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('produks_id')->references('id')->on('produks')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('satuan_beli_id')->references('id')->on('jenis_satuans')->onDelete('cascade');
            $table->foreign('toko_id')->references('id')->on('toko')->onDelete('cascade');
        });

        Schema::create('stoks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('toko_id');
            $table->unsignedBigInteger('produks_id');
            $table->integer('jumlah')->default(0);
            $table->integer('jumlah_sebelumnya');
            $table->unsignedBigInteger('satuan_id');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Adding foreign key constraints
            $table->foreign('produks_id')->references('id')->on('produks')->onDelete('cascade');
            $table->foreign('toko_id')->references('id')->on('toko');
            $table->foreign('satuan_id')->references('id')->on('jenis_satuans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
        Schema::dropIfExists('barang_masuk');
        Schema::dropIfExists('konversisatuan');
        Schema::dropIfExists('log_barang_masuk');
        Schema::dropIfExists('stoks');
    }
};
