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
        Schema::create('perbaikan_selesai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kerusakan');
            $table->foreignId('id_user');
            $table->string('foto_sebelum');
            $table->string('foto_proses');
            $table->string('foto_selesai');
            $table->string('keterangan')->default('-');
            $table->timestamps();

            $table->foreign('id_kerusakan')->references('id')->on('kerusakan');
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
        Schema::dropIfExists('perbaikan_selesai');
    }
};
