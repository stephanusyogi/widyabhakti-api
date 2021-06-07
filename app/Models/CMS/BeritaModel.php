<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class BeritaModel extends Model
{
    //
    protected $table = 'table_berita';
    public $timestamps = false;

    protected $fillable = [
      'id_berita',
      'title',
      'publish_date',
      'excerpt',
      'id_admin',
      'content',
      'created_at'
    ];
}
