<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    //
    protected $table = 'table_fasilitas';

    protected $fillable = [
      'id_fasilitas',
      'nama',
      'img_dir',
      'created_at',
      'updated_at',
    ];
}
