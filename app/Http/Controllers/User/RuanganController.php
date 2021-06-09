<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMS\PeminjamanModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Ruangan;

class RuanganController extends Controller
{
    // Untuk Get Data Halaman Beranda (Thumbnail Ruangan)
    public function ruangan(){
        $dataruangan = DB::table('table_ruangan')
        ->select('table_ruangan.id_ruangan', 'table_ruangan.nama', 'table_ruangan.thumbnail')
        ->get();
        $dataruangan_result = json_decode($dataruangan, true);
        if($dataruangan_result){
            return response([
                'success' => true,
                'message' => 'Data Ruangan Thumbnail Beranda',
                'data' => $dataruangan
            ], 200);
        }else{
            return response([
                'success'=>false,
                'message'=>'Data Kosong'
            ]);
        }
    }

    // Detail Ruangan
    public function detailruangan($id){
        $ruangan = DB::table('table_img_ruangan')
        ->leftjoin('table_ruangan', 'table_img_ruangan.id_ruangan', '=', 'table_ruangan.id_ruangan')
        ->leftjoin('table_admin', 'table_admin.id', '=', 'table_ruangan.id_admin')
        ->where('table_ruangan.id_ruangan', $id)
        ->select('table_ruangan.*', DB::raw('group_concat(table_img_ruangan.img_dir) as img_source'))
        ->groupBy('table_ruangan.id_ruangan')
        ->get();
        $ruangan_result = json_decode($ruangan, true);
        if($ruangan_result){
            foreach($ruangan as $todo) {
                $output['id_ruangan'] = $todo->id_ruangan;
                $output['nama'] = $todo->nama;
                $output['thumbnail'] = $todo->thumbnail;
                $output['kapasitas'] = $todo->kapasitas;
                $output['lantai'] = $todo->lantai;
                $output['luas'] = $todo->luas;
                $output['deskripsi'] = $todo->deskripsi;
                $output['id_admin'] = $todo->id_admin;
                $output['created_at'] = $todo->created_at;
                $output['updated_at'] = $todo->updated_at;
                $srcs = explode(",", $todo->img_source);
                // die(var_dump($srcs));
                foreach($srcs as $src) {
                    $output['photos'][]['src'] = $src;
                }
                $outputs[] = $output;
            }
            return response([
                'success' => true,
                'message' => 'List Detail Ruangan',
                'data' => $outputs
            ], 200);
        }else{
            return response([
                'success'=>false,
                'status'=>'Data Kosong',
                'message' => 'Data Kosong'
            ]);
        }
    }

}




