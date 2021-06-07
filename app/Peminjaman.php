<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    //
    protected $table = 'table_peminjaman';

    protected $fillable = [
      'id_peminjaman',
      'id_user',
      'nama_kegiatan',
      'pemilik_kegiatan',
      'jadwal',
      'waktu',
      'id_ruangan',
      'jumlah_orang',
      'deskripsi_kegiatan',
      'keterangan_tambahan',
      'id_admin',
      'status',
      'pesan_admin',
      'created_at',
      'updated_at'
    ];
}
