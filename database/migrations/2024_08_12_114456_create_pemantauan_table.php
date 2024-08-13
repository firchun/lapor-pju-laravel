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
        Schema::create('pemantauan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_fasilitas');
            $table->foreignId('id_user');
            $table->string('keterangan');
            $table->timestamps();

            $table->foreign('id_fasilitas')->references('id')->on('fasilitas');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemantauan');
    }
};
