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
        Schema::create('kerusakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_fasilitas');
            $table->string('nama_pelapor');
            $table->string('no_hp_pelapor');
            $table->text('keterangan');
            $table->string('foto_pelapor');
            $table->string('foto_kerusakan_1');
            $table->string('foto_kerusakan_2')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->timestamps();

            $table->foreign('id_fasilitas')->references('id')->on('fasilitas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kerusakan');
    }
};
