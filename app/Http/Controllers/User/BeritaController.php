<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMS\PeminjamanModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Berita;

class BeritaController extends Controller
{
    // Untuk Get Data Halaman Beranda (3 Berita terbaru)
    public function beritaberanda(){
        $databerita = DB::table('table_berita')
        ->orderBy('table_berita.created_at', 'ASC')
        ->select('table_berita.*')
        ->limit(3)
        ->get();
        $databerita_result = json_decode($databerita, true);
        if($databerita_result){
            return response([
                'success' => true,
                'message' => 'Data Berita Terkini Beranda',
                'data' => $databerita
            ], 200);
        }else{
            return response([
                'success'=>false,
                'message'=>'Data Kosong'
            ]);
        }
    }

    // Halaman Berita with pagination
    public function beritauser(){
        $databerita = DB::table('table_berita')->paginate(3);
        $databerita_result = json_decode($databerita, true);
        if($databerita){
            return response([
                'success' => true,
                'message' => 'Data Berita',
                'data' => $databerita
            ], 200);
        }else{
            return response([
                'success'=>false,
                'message'=>'Data Kosong'
            ]);
        }
    }

    // Detail Berita
    public function detailberita($id){
        return response()->json(Berita::where('id_berita',$id)->first(), 200);
    }

}




