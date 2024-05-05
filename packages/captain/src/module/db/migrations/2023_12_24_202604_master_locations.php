<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * master geografis
     */
    public function up()
    {
        Schema::create('masters_province', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30);
            $table->timestamps();
        });

        Schema::create('masters_district', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('masters_province_id');
            $table->string('name', 30);
            $table->timestamps();

            $table->foreign('masters_province_id')->references('id')->on('masters_province')->onDelete('cascade');
        });

        Schema::create('masters_subdistrict', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('masters_district_id');
            $table->string('name', 30);
            $table->text('ibukota_kecamatan')->nullable();
            $table->timestamps();

            $table->foreign('masters_district_id')->references('id')->on('masters_district')->onDelete('cascade');
        });

        Schema::create('masters_village', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('masters_subdistrict_id');
            $table->string('name', 40)->nullable();
            $table->text('ibukota_desa')->nullable();
            $table->text('sebutan_desa')->nullable();
            $table->timestamps();

            $table->foreign('masters_subdistrict_id')->references('id')->on('masters_subdistrict')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masters_village');
        Schema::dropIfExists('masters_subdistrict');
        Schema::dropIfExists('masters_district');
        Schema::dropIfExists('masters_province');
    }
};
