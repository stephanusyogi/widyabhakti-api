<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\CMS\BeritaModel;
use App\Models\CMS\ImgBeritaModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Berita;

class BeritaController extends Controller
{
    //
    public function berita(){
        $berita = DB::table('table_berita')
        ->leftjoin('table_admin', 'table_admin.id', '=', 'table_berita.id_admin')
        ->select('table_berita.*', 'table_admin.name as nama_admin')
        ->get();
        $berita = json_decode($berita, true);
        return response([
            'success' => true,
            'message' => 'List Semua Berita',
            'data' => $berita
        ], 200);
    }

    public function beritaByID($id){
        return response()->json(Berita::where('id_berita',$id)->first(), 200);
    }

    public function beritaSave(Request $request){
        // Validate Data
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'excerpt' => 'required',
            'id_admin' => 'required',
            'content' => 'required',
            'img_dir' => 'required'
        ],
            [
                'title.required' => 'Masukkan Title Berita !',
                'excerpt.required' => 'Masukkan Deskrip Singkat !',
                'id_admin.required' => 'Masukkan Id Admin !',
                'content.required' => 'Masukkan Konten Berita !',
                'img_dir.required' => 'Masukkan Direktori Image Berita !'
            ]
        );

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
        }else{
            $berita = new Berita();
            $berita->title = $request->input('title');
            $berita->excerpt = $request->input('excerpt');
            $berita->id_admin = $request->input('id_admin');
            $berita->content = $request->input('content');
            $berita->img_dir = $request->input('img_dir');
            $berita->save();

            if($berita){
                return response()->json([
                    'success' => true,
                    'message' => 'Berita Berhasil Ter-Publish !'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Berita Gagal Ter-Publish !',
                ], 401);
            }
        }
    }

    public function beritaUpdate(Request $request){
        // Validate Data
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'excerpt' => 'required',
            'id_admin' => 'required',
            'content' => 'required',
            'img_dir' => 'required'
        ],
            [
                'title.required' => 'Masukkan Title Berita !',
                'excerpt.required' => 'Masukkan Deskrip Singkat !',
                'id_admin.required' => 'Masukkan Id Admin !',
                'content.required' => 'Masukkan Konten Berita !',
                'img_dir.required' => 'Masukkan Direktori Image Berita !'
            ]
        );
        

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
            
        }else{
            $berita = Berita::where('id_berita', $request->input('id_berita'))->update([
                'title' => $request->input('title'),
                'excerpt' => $request->input('excerpt'),
                'id_admin' => $request->input('id_admin'),
                'content' => $request->input('content'),
                'img_dir' => $request->input('img_dir')
            ]);

            if($berita){
                return response()->json([
                    'success' => true,
                    'message' => 'Berita Berhasil Ter-Update !'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Berita Gagal Update !',
                ], 401);
            }
        }
    }

    public function beritaDelete($id)
    {
        $berita = Berita::where('id_berita',$id);
        $berita->delete();

        if ($berita) {
            return response()->json([
                'success' => true,
                'message' => 'Berita Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Berita Gagal Dihapus!',
            ], 400);
        }

    }
}
