<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    //
    protected $table = 'table_galeri';

    protected $fillable = [
      'id_photo',
      'img_dir',
      'created_at',
      'updated_at',
    ];
}
