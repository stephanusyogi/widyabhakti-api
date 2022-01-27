<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Fasilitas;

class FasilitasController extends Controller
{
    //
    public function fasilitas(){
        $fasilitas = Fasilitas::get();
        $fasilitas = json_decode($fasilitas, true);
        return response([
            'success' => true,
            'message' => 'List Semua Fasilitas Umum',
            'data' => $fasilitas
        ], 200);
    }

    public function fasilitasSave(Request $request){
        // Validate Data
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'img_dir' => 'required',
        ],
            [
                'nama.required' => 'Masukkan Nama Fasilitas !',
                'img_dir.required' => 'Masukkan Direktori Gambar !',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
        }else{
            $fasilitas = new Fasilitas();
            $fasilitas->nama = $request->input('nama');
            $fasilitas->img_dir = $request->input('img_dir');
            $fasilitas->save();

            if($fasilitas){
                return response()->json([
                    'success' => true,
                    'message' => 'Fasilitas Berhasil Ter-Upload !'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Fasilitas Gagal Ter-Upload !',
                ], 200);
            }
        }
    }

    public function fasilitasDelete($id)
    {
        $fasilitas = Fasilitas::where('id_fasilitas',$id);
        $fasilitas->delete();

        if ($fasilitas) {
            return response()->json([
                'success' => true,
                'message' => 'Fasilitas Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Fasilitas Gagal Dihapus!',
            ], 400);
        }

    }
}
