<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * master kariyawan
     */
    public function up(): void
    {
        Schema::create('position_employees', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger('employees_id')->comment('Kariyawan');
            $table->foreign('employees_id')->references('id')->on('employees');

            $table->unsignedInteger('masters_posisitions_id')->comment('Posisi Jabatan (bisa kosong)');
            $table->foreign('masters_posisitions_id')->references('id')->on('masters_posisitions');

            $table->date("start_date");
            $table->date("end_date");

            $table->unsignedInteger('masters_status_id')->nullable()->comment('Status');
            $table->foreign('masters_status_id')->references('id')->on('masters_status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('position_employees');
    }
};
