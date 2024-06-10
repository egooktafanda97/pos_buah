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
        Schema::create('config_toko', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('toko_id');
            $table->foreign('toko_id')->references('id')->on('toko');
            $table->string('key');
            $table->string('value');
            $table->string('type')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_tokos');
    }
};
