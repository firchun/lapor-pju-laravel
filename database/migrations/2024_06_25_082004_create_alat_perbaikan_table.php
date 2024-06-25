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
        Schema::create('alat_perbaikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kerusakan');
            $table->foreignId('id_perbaikan');
            $table->string('nama_alat');
            $table->integer('jumlah')->default(1);
            $table->boolean('diganti')->default(0);
            $table->timestamps();

            $table->foreign('id_kerusakan')->references('id')->on('kerusakan');
            $table->foreign('id_perbaikan')->references('id')->on('perbaikan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alat_perbaikan');
    }
};
