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
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->string('id_pelanggan_pln')->default(0)->after('nama');
            $table->string('tunggakan')->default(0)->after('id_pelanggan_pln');
            $table->string('tarip')->nullable('')->after('tunggakan');
            $table->integer('daya')->default(0)->after('tarip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fasilitas', function (Blueprint $table) {
            //
        });
    }
};
