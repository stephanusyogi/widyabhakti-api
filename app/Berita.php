<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    //
    protected $table = 'table_berita';

    protected $fillable = [
      'id_berita',
      'id_admin',
      'title',
      'excerpt',
      'content',
      'img_dir',
      'created_at',
      'updated_at',
    ];
}
