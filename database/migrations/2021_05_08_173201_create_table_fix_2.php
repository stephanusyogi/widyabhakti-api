<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFix2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_berita', function (Blueprint $table) {
            $table->increments('id_berita');
            $table->string('title');
            $table->string('excerpt');
            $table->text('content');
            $table->text('img_dir');
            $table->timestamps();
        });

        Schema::create('table_ruangan', function (Blueprint $table) {
            $table->increments('id_ruangan');
            $table->string('nama');
            $table->string('kapasitas');
            $table->string('luas');
            $table->text('deskripsi');
            $table->integer('id_admin');
            $table->timestamps();
        });

        Schema::create('table_img_ruangan', function (Blueprint $table) {
            $table->increments('id_img_ruangan');
            $table->integer('id_ruangan');
            $table->string('img_dir');
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
        Schema::dropIfExists('table_berita');
        Schema::dropIfExists('table_ruangan');
        Schema::dropIfExists('table_img_ruangan');
    }
}
