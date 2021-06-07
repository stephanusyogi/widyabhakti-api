<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    //
    protected $table = 'table_ruangan';

    protected $fillable = [
      'id_ruangan',
      'nama',
      'thumbnail',
      'kapasitas',
      'luas',
      'deskripsi',
      'id_admin',
      'created_at',
      'updated_at',
    ];
}
