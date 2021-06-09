<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Galeri;

class GaleriUserController extends Controller
{
    //
    public function galeriuser(){
        $galeri = Galeri::get();
        $galeri = json_decode($galeri, true);
        return response([
            'success' => true,
            'message' => 'List Semua Galeri dan Foto',
            'data' => $galeri
        ], 200);
    }
}
