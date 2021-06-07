<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class ImgBeritaModel extends Model
{
    //
    protected $table = 'table_img_berita';
    public $timestamps = false;

    protected $fillable = [
      'id_img_berita',
      'id_berita',
      'alt_img',
      'img_dir'
    ];
}
