<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class PeminjamanModel extends Model
{
    //
    protected $table = 'table_peminjaman';
    public $timestamps = false;

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
      'created_at',
      'keterangan_admin'
    ];
}
