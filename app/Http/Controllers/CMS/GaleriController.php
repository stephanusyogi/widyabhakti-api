<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Galeri;

class GaleriController extends Controller
{
    //
    public function galeri(){
        $galeri = Galeri::get();
        $galeri = json_decode($galeri, true);
        return response([
            'success' => true,
            'message' => 'List Semua Galeri dan Foto',
            'data' => $galeri
        ], 200);
    }

    public function galeriSave(Request $request){
        // Validate Data
        $validator = Validator::make($request->all(),[
            'img_dir' => 'required',
        ],
            [
                'img_dir.required' => 'Masukkan Title Berita !',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
        }else{
            $galeri = new Galeri();
            $galeri->img_dir = $request->input('img_dir');
            $galeri->save();

            if($galeri){
                return response()->json([
                    'success' => true,
                    'message' => 'Foto Berhasil Ter-Upload !'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Foto Gagal Ter-Upload !',
                ], 200);
            }
        }
    }

    public function galeriDelete($id)
    {
        $galeri = Galeri::where('id_photo',$id);
        $galeri->delete();

        if ($galeri) {
            return response()->json([
                'success' => true,
                'message' => 'Foto Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Foto Gagal Dihapus!',
            ], 400);
        }

    }
}
