<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class RuanganModel extends Model
{
    //
    protected $table = 'table_ruangan';
    public $timestamps = false;

    protected $fillable = [
      'id_ruangan',
      'nama',
      'kapasitas',
      'luas',
      'deskripsi',
      'id_admin'
    ];
}
