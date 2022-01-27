<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMS\PeminjamanModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Peminjaman;

class PeminjamanController extends Controller
{
    //
    public function peminjaman(){
        // die(var_dump('test'));
        $peminjaman = DB::table('table_peminjaman')
        ->leftjoin('table_ruangan', 'table_peminjaman.id_ruangan', '=', 'table_ruangan.id_ruangan')
        ->leftjoin('table_admin', 'table_peminjaman.id_admin', '=', 'table_admin.id')
        ->leftjoin('table_user', 'table_peminjaman.id_user', '=', 'table_user.id')
        ->select('table_peminjaman.*' , 'table_user.name as nama_user', 'table_admin.name as nama_admin', 'table_ruangan.nama as nama_ruangan', 'table_ruangan.thumbnail')
        ->groupBy('table_peminjaman.id_peminjaman')
        ->get();
        $peminjaman_result = json_decode($peminjaman, true);
        if($peminjaman_result){
            foreach($peminjaman as $todo) {
                $output['id_peminjaman'] = $todo->id_peminjaman;
                $output['id_user'] = $todo->id_user;
                $output['nama_user'] = $todo->nama_user;
                $output['nama_kegiatan'] = $todo->nama_kegiatan;
                $output['pemilik_kegiatan'] = $todo->pemilik_kegiatan;
                $output['jadwal'] = $todo->jadwal;
                $output['waktu_mulai'] = $todo->waktu_mulai;
                $output['waktu_selesai'] = $todo->waktu_selesai;
                $output['id_ruangan'] = $todo->id_ruangan;
                $output['nama_ruangan'] = $todo->nama_ruangan;
                $output['jumlah_orang'] = $todo->jumlah_orang;
                $output['deskripsi_kegiatan'] = $todo->deskripsi_kegiatan;
                $output['keterangan_tambahan'] = $todo->keterangan_tambahan;
                $output['rutin'] = $todo->rutin;
                $output['id_admin'] = $todo->id_admin;
                $output['nama_admin'] = $todo->nama_admin;
                $output['status'] = $todo->status;
                $output['pesan_admin'] = $todo->pesan_admin;
                $output['created_at'] = $todo->created_at;
                $output['updated_at'] = $todo->updated_at;
            
                $outputs[] = $output;
            }
            return response([
                'success' => true,
                'message' => 'List Semua Peminjaman',
                'data' => $outputs
            ], 200);
        }else{
            return response([
                'success'=>false,
                'status'=>'Data Kosong',
                'message'=> 'Data Kosong'
            ]);
        }
    }

    public function peminjamanrutin(){
        // die(var_dump('test'));
        $peminjaman = DB::table('table_peminjaman')
        ->leftjoin('table_ruangan', 'table_peminjaman.id_ruangan', '=', 'table_ruangan.id_ruangan')
        ->leftjoin('table_admin', 'table_peminjaman.id_admin', '=', 'table_admin.id')
        ->leftjoin('table_user', 'table_peminjaman.id_user', '=', 'table_user.id')
        ->select('table_peminjaman.*' , 'table_user.name as nama_user', 'table_user.nohp as nomor_user', 'table_admin.name as nama_admin', 'table_ruangan.nama as nama_ruangan', 'table_ruangan.lantai as lantai_ruangan', 'table_ruangan.thumbnail')
        ->groupBy('table_peminjaman.id_peminjaman')
        ->where('rutin',1)
        ->get();
        $peminjaman_result = json_decode($peminjaman, true);
        if($peminjaman_result){
            foreach($peminjaman as $todo) {
                $output['id_peminjaman'] = $todo->id_peminjaman;
                $output['id_user'] = $todo->id_user;
                $output['nama_user'] = $todo->nama_user;
                $output['nomor_user'] = $todo->nomor_user;
                $output['nama_kegiatan'] = $todo->nama_kegiatan;
                $output['pemilik_kegiatan'] = $todo->pemilik_kegiatan;
                $output['jadwal'] = $todo->jadwal;
                $output['waktu_mulai'] = $todo->waktu_mulai;
                $output['waktu_selesai'] = $todo->waktu_selesai;
                $output['id_ruangan'] = $todo->id_ruangan;
                $output['nama_ruangan'] = $todo->nama_ruangan;
                $output['lantai_ruangan'] = $todo->lantai_ruangan;
                $output['jumlah_orang'] = $todo->jumlah_orang;
                $output['deskripsi_kegiatan'] = $todo->deskripsi_kegiatan;
                $output['keterangan_tambahan'] = $todo->keterangan_tambahan;
                $output['rutin'] = $todo->rutin;
                $output['id_admin'] = $todo->id_admin;
                $output['nama_admin'] = $todo->nama_admin;
                $output['status'] = $todo->status;
                $output['pesan_admin'] = $todo->pesan_admin;
                $output['created_at'] = $todo->created_at;
                $output['updated_at'] = $todo->updated_at;
            
                $outputs[] = $output;
            }
            return response([
                'success' => true,
                'message' => 'List Semua Peminjaman',
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

    public function peminjamanSave(Request $request){
        // Validate Data
        $validator = Validator::make($request->all(),[
            'id_user' => 'required',
            'nama_kegiatan' => 'required',
            'pemilik_kegiatan' => 'required',
            'jadwal' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'id_ruangan' => 'required',
            'jumlah_orang' => 'required',
            'deskripsi_kegiatan' => 'required',
            'keterangan_tambahan' => 'required'
        ],
            [
                'id_user.required' => 'Masukkan Id User !',
                'nama_kegiatan.required' => 'Masukkan Nama Kegiatan !',
                'pemilik_kegiatan.required' => 'Masukkan Pemilik Kegiatan !',
                'jadwal.required' => 'Masukkan Jadwal Kegiatan !',
                'waktu_mulai.required' => 'Masukkan Waktu Mulai Kegiatan !',
                'waktu_selesai.required' => 'Masukkan Waktu Selesai Kegiatan !',
                'id_ruangan.required' => 'Masukkan Id Ruangan !',
                'jumlah_orang.required' => 'Masukkan Jumlah Kegiatan !',
                'deskripsi_kegiatan.required' => 'Masukkan Deskripsi Kegiatan !',
                'keterangan_tambahan.required' => 'Masukkan Keterangan Kegiatan !'
            ]
        );

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
        }else{
            $peminjaman = new Peminjaman();
            $peminjaman->id_user = $request->input('id_user');
            $peminjaman->nama_kegiatan = $request->input('nama_kegiatan');
            $peminjaman->pemilik_kegiatan = $request->input('pemilik_kegiatan');
            $peminjaman->jadwal = $request->input('jadwal');
            $peminjaman->waktu_mulai = $request->input('waktu_mulai');
            $peminjaman->waktu_selesai = $request->input('waktu_selesai');
            $peminjaman->id_ruangan = $request->input('id_ruangan');
            $peminjaman->jumlah_orang = $request->input('jumlah_orang');
            $peminjaman->deskripsi_kegiatan = $request->input('deskripsi_kegiatan');
            $peminjaman->keterangan_tambahan = $request->input('keterangan_tambahan');
            $peminjaman->save();

            if($peminjaman){
                return response()->json([
                    'success' => true,
                    'message' => 'Peminjaman Berhasil Di Simpan !'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman Gagal Disimpan !',
                ], 401);
            }
        }
    }

    public function peminjamanUpdate(Request $request){
        // Validate Data
        $validator = Validator::make($request->all(),[
            'id_user' => 'required',
            'nama_kegiatan' => 'required',
            'pemilik_kegiatan' => 'required',
            'jadwal' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'id_ruangan' => 'required',
            'jumlah_orang' => 'required',
            'deskripsi_kegiatan' => 'required',
            'keterangan_tambahan' => 'required',
        ],
            [
                'id_user.required' => 'Masukkan Id User !',
                'nama_kegiatan.required' => 'Masukkan Nama Kegiatan !',
                'pemilik_kegiatan.required' => 'Masukkan Pemilik Kegiatan !',
                'jadwal.required' => 'Masukkan Jadwal Kegiatan !',
                'waktu_mulai.required' => 'Masukkan Waktu Kegiatan !',
                'waktu_selesai.required' => 'Masukkan Waktu Kegiatan !',
                'id_ruangan.required' => 'Masukkan Id Ruangan !',
                'jumlah_orang.required' => 'Masukkan Jumlah Kegiatan !',
                'deskripsi_kegiatan.required' => 'Masukkan Deskripsi Kegiatan !',
                'keterangan_tambahan.required' => 'Masukkan Keterangan Kegiatan !',
            ]
        );
        

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
            
        }else{
            $peminjaman = Peminjaman::where('id_peminjaman', $request->input('id_peminjaman'))->update([
                'nama_kegiatan' => $request->input('nama_kegiatan'),
                'pemilik_kegiatan' => $request->input('pemilik_kegiatan'),
                'jadwal' => $request->input('jadwal'),
                'waktu_mulai' => $request->input('waktu_mulai'),
                'waktu_selesai' => $request->input('waktu_selesai'),
                'id_user' => $request->input('id_user'),
                'id_ruangan' => $request->input('id_ruangan'),
                'jumlah_orang' => $request->input('jumlah_orang'),
                'deskripsi_kegiatan' => $request->input('deskripsi_kegiatan'),
                'keterangan_tambahan' => $request->input('keterangan_tambahan'),
                'rutin' => $request->input('rutin'),
                'id_admin' => $request->input('id_admin'),
                'status' => $request->input('status'),
                'pesan_admin' => $request->input('pesan_admin')
            ]);

            if($peminjaman){
                return response()->json([
                    'success' => true,
                    'message' => 'Peminjaman Berhasil Ter-Update !'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman Gagal Update !',
                ], 401);
            }
        }
    }

    public function peminjamanDelete($id)
    {
        $peminjaman = Peminjaman::where('id_peminjaman',$id);
        $peminjaman->delete();

        if ($peminjaman) {
            return response()->json([
                'success' => true,
                'message' => 'Peminjaman Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman Gagal Dihapus!',
            ], 400);
        }

    }

    public function peminjamanById($id){
        // die(var_dump('test'));
        $peminjaman = DB::table('table_peminjaman')
        ->leftjoin('table_ruangan', 'table_peminjaman.id_ruangan', '=', 'table_ruangan.id_ruangan')
        ->leftjoin('table_admin', 'table_peminjaman.id_admin', '=', 'table_admin.id')
        ->leftjoin('table_user', 'table_peminjaman.id_user', '=', 'table_user.id')
        ->where('table_peminjaman.id_peminjaman','=', $id)
        ->select('table_peminjaman.*' , 'table_user.name as nama_user', 'table_admin.name as nama_admin', 'table_ruangan.nama as nama_ruangan', 'table_ruangan.thumbnail')
        ->groupBy('table_peminjaman.id_peminjaman')
        ->get();
        $peminjaman_result = json_decode($peminjaman, true);
        if($peminjaman_result){
            foreach($peminjaman as $todo) {
                $output['id_peminjaman'] = $todo->id_peminjaman;
                $output['id_user'] = $todo->id_user;
                $output['nama_user'] = $todo->nama_user;
                $output['nama_kegiatan'] = $todo->nama_kegiatan;
                $output['pemilik_kegiatan'] = $todo->pemilik_kegiatan;
                $output['jadwal'] = $todo->jadwal;
                $output['waktu_mulai'] = $todo->waktu_mulai;
                $output['waktu_selesai'] = $todo->waktu_selesai;
                $output['id_ruangan'] = $todo->id_ruangan;
                $output['nama_ruangan'] = $todo->nama_ruangan;
                $output['jumlah_orang'] = $todo->jumlah_orang;
                $output['deskripsi_kegiatan'] = $todo->deskripsi_kegiatan;
                $output['keterangan_tambahan'] = $todo->keterangan_tambahan;
                $output['rutin'] = $todo->rutin;
                $output['id_admin'] = $todo->id_admin;
                $output['nama_admin'] = $todo->nama_admin;
                $output['status'] = $todo->status;
                $output['pesan_admin'] = $todo->pesan_admin;
                $output['created_at'] = $todo->created_at;
                $output['updated_at'] = $todo->updated_at;
            
                $outputs[] = $output;
            }
            return response([
                'success' => true,
                'message' => 'Data Peminjaman By Id',
                'data' => $outputs
            ], 200);
        }else{
            return response([
                'success'=>false,
                'status'=>'Data Kosong',
                'message'=> 'Data Kosong'
            ]);
        }
    }
}




