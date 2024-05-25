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
        Schema::create('jenis_satuans', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedInteger('toko_id');
            $table->string('nama');
            $table->timestamps();

            $table->foreign('toko_id')->references('id')->on('toko');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_satuans');
    }
};
