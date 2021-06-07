<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMS\PeminjamanModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Peminjaman;

class ProfilController extends Controller
{
    // Untuk Get Data Peminjaman by id user
    public function datapeminjamanuser(Request $request){
        $id_user = $request->input('id_user');
        $validator = Validator::make($request->all(),[
            'id_user' => 'required',
        ],
            [
                'id_user.required' => 'Masukkan ID User !',
            ]
        );
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
            
        }else{
            $datapeminjaman = DB::table('table_peminjaman')
            ->where('table_peminjaman.id_user', $id_user)
            ->leftjoin('table_ruangan', 'table_peminjaman.id_ruangan', '=', 'table_ruangan.id_ruangan')
            ->select('table_peminjaman.*', 'table_ruangan.thumbnail')
            ->get();
            $datapeminjaman_result = json_decode($datapeminjaman, true);
            if($datapeminjaman_result){
                return response([
                    'success' => true,
                    'message' => 'Data ID Ruangan',
                    'data' => $datapeminjaman
                ], 200);
            }else{
                return response([
                    'success'=>false,
                    'message'=>'Data Kosong'
                ]);
            }
        }
    }

}




