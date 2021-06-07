<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_admin', function (Blueprint $table) {
            $table->increments('id_admin');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('status',['primary','secondary']);
            $table->timestamps();
        });

        Schema::create('table_user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('organisasi');
            $table->string('nohp');
            $table->timestamps();
        });

        Schema::create('table_peminjaman', function (Blueprint $table) {
            $table->increments('id_peminjaman');
            $table->integer('id_user');
            $table->string('nama_kegiatan');
            $table->string('jadwal');
            $table->string('waktu');
            $table->integer('id_ruangan');
            $table->string('jumlah_orang');
            $table->string('deskripsi_kegiatan');
            $table->integer('id_admin');
            $table->enum('status',['approved','rejected']);
            $table->string('keterangan_admin');
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
        Schema::dropIfExists('table_admin');
        Schema::dropIfExists('table_user');
        Schema::dropIfExists('table_peminjaman');
    }
}
