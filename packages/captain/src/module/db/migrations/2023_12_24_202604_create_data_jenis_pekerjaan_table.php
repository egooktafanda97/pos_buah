<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * master jenis pekerjaan
         */
        Schema::create('masters_occupation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('kategory', 100)->nullable();
            $table->string('code', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('masters_occupation');
    }
};
