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
        Schema::create('harga', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('toko_id');
            $table->unsignedBigInteger('produks_id');
            $table->integer('harga');
            $table->unsignedBigInteger('jenis_satuan_id');
            $table->unsignedBigInteger('user_update_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_update_id')->references('id')->on('users');
            $table->foreign('toko_id')->references('id')->on('toko');
            $table->foreign('produks_id')->references('id')->on('produks');
            $table->foreign('jenis_satuan_id')->references('id')->on('jenis_satuans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hargas');
    }
};
