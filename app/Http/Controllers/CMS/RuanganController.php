<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\CMS\RuanganModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Ruangan;

class RuanganController extends Controller
{
    //
    public function ruangan(){
        $ruangan = DB::table('table_img_ruangan')
        ->leftjoin('table_ruangan', 'table_img_ruangan.id_ruangan', '=', 'table_ruangan.id_ruangan')
        ->leftjoin('table_admin', 'table_admin.id', '=', 'table_ruangan.id_admin')
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
                'message' => 'List Semua Ruangan',
                'data' => $outputs
            ], 200);
        }else{
            return response([
                'success'=>false,
                'status'=>'Data Kosong'
            ]);
        }
    }

    // DB::raw('group_concat(table_img_ruangan.img_dir) as img_source')
    // table_img_ruangan.img_dir as img_source

    public function ruanganSave(Request $request){
        // Validate Data
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'kapasitas' => 'required',
            'luas' => 'required',
            'lantai' => 'required',
            'deskripsi' => 'required',
            'id_admin' => 'required',
        ],
            [
                'nama.required' => 'Masukkan Nama Ruangan !',
                'kapasitas.required' => 'Masukkan Kapasitas Ruangan !',
                'luas.required' => 'Masukkan Luas Ruangan !',
                'lantai.required' => 'Masukkan Lantai Ruangan !',
                'deskripsi.required' => 'Masukkan Deskripsi Ruangan !',
                'id_admin.required' => 'Masukkan Id Admin !'
            ]
        );

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
        }else{
            $ruangan = new Ruangan();
            $ruangan->nama = $request->input('nama');
            $ruangan->thumbnail = $request->input('thumbnail');
            $ruangan->kapasitas = $request->input('kapasitas');
            $ruangan->luas = $request->input('luas');
            $ruangan->lantai = $request->input('lantai');
            $ruangan->deskripsi = $request->input('deskripsi');
            $ruangan->id_admin = $request->input('id_admin');
            $ruangan->save();

            if($ruangan){
                return response()->json([
                    'success' => true,
                    'message' => 'Ruangan Berhasil Di Simpan !'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Ruangan Gagal Disimpan !',
                ], 401);
            }
        }
    }

    public function ruanganUpdate(Request $request){
        // Validate Data
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'kapasitas' => 'required',
            'luas' => 'required',
            'lantai' => 'required',
            'deskripsi' => 'required',
            'id_admin' => 'required',
        ],
            [
                'nama.required' => 'Masukkan Nama Ruangan !',
                'kapasitas.required' => 'Masukkan Kapasitas Ruangan !',
                'luas.required' => 'Masukkan Luas Ruangan !',
                'lantai.required' => 'Masukkan Lantai Ruangan !',
                'deskripsi.required' => 'Masukkan Deskripsi Ruangan !',
                'id_admin.required' => 'Masukkan Id Admin !'
            ]
        );
        

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
            
        }else{
            $ruangan = Ruangan::where('id_ruangan', $request->input('id_ruangan'))->update([
                'nama' => $request->input('nama'),
                'kapasitas' => $request->input('kapasitas'),
                'luas' => $request->input('luas'),
                'lantai' => $request->input('lantai'),
                'deskripsi' => $request->input('deskripsi'),
                'id_admin' => $request->input('id_admin')
            ]);

            if($ruangan){
                return response()->json([
                    'success' => true,
                    'message' => 'Ruangan Berhasil Ter-Update !'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Ruangan Gagal Update !',
                ], 401);
            }
        }
    }

    public function ruanganDelete($id)
    {
        $ruangan = Ruangan::where('id_ruangan',$id);
        $ruangan->delete();

        if ($ruangan) {
            return response()->json([
                'success' => true,
                'message' => 'Ruangan Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan Gagal Dihapus!',
            ], 400);
        }

    }
}

