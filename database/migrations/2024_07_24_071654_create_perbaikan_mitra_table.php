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
        Schema::create('perbaikan_mitra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kerusakan');
            $table->foreignId('id_mitra');
            $table->text('alat_diganti');
            $table->integer('biaya')->default(0);
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
        Schema::dropIfExists('perbaikan_mitra');
    }
};
