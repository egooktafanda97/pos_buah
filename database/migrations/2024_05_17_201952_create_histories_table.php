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
        Schema::create('histories', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('toko_id');
            $table->unsignedBigInteger('produk_id');
            $table->unsignedBigInteger('jenis_satuan_id');
            $table->integer('harga');
            $table->integer('jumlah');
            $table->integer('total');
            $table->enum('tipe', ["masuk", "keluar"]); // 'masuk' atau 'keluar'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
