<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMS\PeminjamanModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Peminjaman;

class PeminjamanUserController extends Controller
{
    // Untuk Option di Fitur Check Availeble Ruangan
    public function ruanganpeminjaman(){
        $dataruangan = DB::table('table_ruangan')
        ->select('table_ruangan.id_ruangan','table_ruangan.nama','table_ruangan.lantai')
        ->orderBy('table_ruangan.lantai')
        ->get();
        $dataruangan_result = json_decode($dataruangan, true);
        if($dataruangan_result){
            foreach($dataruangan as $todo) {
                $ruangan['id_ruangan'] = $todo->id_ruangan;
                $ruangan['nama_ruangan'] = $todo->nama;
                $ruangan['lantai'] = $todo->lantai;
            
                $data_id_ruangan[] = $ruangan;
            }
            return response([
                'success' => true,
                'message' => 'Data ID Ruangan',
                'data' => $data_id_ruangan
            ], 200);
        }else{
            return response([
                'success'=>false,
                'status'=>'Data Kosong',
                'message' => 'Data Kosong'
            ]);
        }
    }

    // Untuk Check Availabilty Ruangan
    public function checkpeminjaman(Request $request){
        $datepeminjaman = $request->input('datepeminjaman');
        $ruanganpeminjaman = $request->input('ruanganpeminjaman');
        $validator = Validator::make($request->all(),[
            'datepeminjaman' => 'required',
            'ruanganpeminjaman' => 'required',
        ],
            [
                'datepeminjaman.required' => 'Masukkan Jadwal Ruangan !',
                'ruanganpeminjaman.required' => 'Masukkan Ruangan !',
            ]
        );
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
            
        }else{
            $peminjaman = DB::table('table_peminjaman')
            ->where('table_peminjaman.jadwal', $datepeminjaman)
            ->where('table_peminjaman.id_ruangan', $ruanganpeminjaman)
            ->leftjoin('table_ruangan', 'table_peminjaman.id_ruangan', '=', 'table_ruangan.id_ruangan')
            ->select('table_peminjaman.jadwal' ,'table_peminjaman.id_ruangan' ,'table_peminjaman.waktu_mulai' ,'table_peminjaman.waktu_selesai' , 'table_ruangan.thumbnail')
            ->orderBy('waktu_mulai', 'ASC')
            ->get();
            $peminjaman_result = json_decode($peminjaman, true);
            // Mengambil data waktu yang sudah terjadwal di table peminjaman
            if($peminjaman_result){
                foreach($peminjaman as $todo) {
                    $ruangan['id_ruangan'] = $todo->id_ruangan;
                    $ruangan['thumbnail'] = $todo->thumbnail;
                    $data_waktu['waktu_mulai'] = $todo->waktu_mulai;
                    $data_waktu['waktu_selesai'] = $todo->waktu_selesai;
                
                    $data_ruangan[] = $ruangan;
                    $waktu_terpakai[] = $data_waktu;
                }
                return response([
                    'success' => true,
                    'status' => 'dateandruangan',
                    'message' => 'Data Jadwal Penggunaan Ruangan',
                    'data' => [
                        'data_ruangan' => $data_ruangan[0],
                        'jadwal_terpakai' => $waktu_terpakai,
                    ]
                ], 200);
            }else{
                // Apabila tidak ada waktu yang telah terjadwal maka ambil dari tabel ruangan sesuai tanggal dan ruangan
                $ruangan_res = DB::table('table_ruangan')
                ->where('table_ruangan.id_ruangan', $ruanganpeminjaman)
                ->select('table_ruangan.id_ruangan' , 'table_ruangan.thumbnail')
                ->get();
                $ruangan_result = json_decode($ruangan_res, true);
                if($ruangan_result){
                    foreach($ruangan_res as $todo) {
                        $ruangan['id_ruangan'] = $todo->id_ruangan;
                        $ruangan['thumbnail'] = $todo->thumbnail;
                    
                        $data_ruangan[] = $ruangan;
                    }
                    return response([
                        'success' => true,
                        'status' => 'onlyruangan',
                        'message' => 'Data Ruangan',
                        'data' => $data_ruangan[0]
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
    }

    // Untuk Get data Ruangan setelah memilih ruangan saat check availablity
    public function dataforform(Request $request){
        $id_ruangan = $request->input('id_ruangan');
        $validator = Validator::make($request->all(),[
            'id_ruangan' => 'required',
        ],
            [
                'id_ruangan.required' => 'Masukkan ID Ruangan !',
            ]
        );
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
            
        }else{
            $dataruangan = DB::table('table_img_ruangan')
            ->where('table_ruangan.id_ruangan', $id_ruangan)
            ->leftjoin('table_ruangan', 'table_img_ruangan.id_ruangan', '=', 'table_ruangan.id_ruangan')
            ->leftjoin('table_admin', 'table_admin.id', '=', 'table_ruangan.id_admin')
            ->select('table_ruangan.*', DB::raw('group_concat(table_img_ruangan.img_dir) as img_source'))
            ->groupBy('table_ruangan.id_ruangan')
            ->get();
            $dataruangan_result = json_decode($dataruangan, true);
            if($dataruangan_result){
                foreach($dataruangan as $todo) {
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
                
                    $data_id_ruangan[] = $output;
                }
                return response([
                    'success' => true,
                    'message' => 'Data ID Ruangan',
                    'data' => $data_id_ruangan
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

    // Validasi Waktu
    public function validasiwaktu(Request $request){
        $waktu_mulai = $request->input('waktu_mulai');
        $waktu_selesai = $request->input('waktu_selesai');
        $id_ruangan = $request->input('id_ruangan');
        $datepeminjaman = $request->input('datepeminjaman');
        $validator = Validator::make($request->all(),[
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'datepeminjaman' => 'required',
            'id_ruangan' => 'required',
        ],
            [
                'waktu_mulai.required' => 'Masukkan Waktu Mulai !',
                'waktu_selesai.required' => 'Masukkan Waktu Selesai !',
                'datepeminjaman.required' => 'Masukkan Tanggal Peminjaman !',
                'id_ruangan.required' => 'Masukkan Ruangan !',
            ]
        );
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
            
        }else{
            // Ambil data di tabel peminjaman sesuai tanggal dan waktu
            $peminjaman = DB::table('table_peminjaman')
            ->where('table_peminjaman.id_ruangan', $id_ruangan)
            ->where('table_peminjaman.waktu_mulai', $waktu_mulai)
            ->orWhere('table_peminjaman.waktu_selesai', $waktu_selesai)
            ->where('table_peminjaman.jadwal', $datepeminjaman)
            // ->leftjoin('table_ruangan', 'table_peminjaman.id_ruangan', '=', 'table_ruangan.id_ruangan')
            ->select('table_peminjaman.jadwal' ,'table_peminjaman.waktu_mulai' ,'table_peminjaman.waktu_selesai' )
            ->orderBy('waktu_mulai', 'ASC')
            ->get();
            $peminjaman_result = json_decode($peminjaman, true);
            if($peminjaman_result){
                foreach($peminjaman as $todo) {
                    // $data_waktu['nama_ruangan'] = $todo->nama;
                    $data_waktu['jadwal'] = $todo->jadwal;
                    $data_waktu['waktu_mulai'] = $todo->waktu_mulai;
                    $data_waktu['waktu_selesai'] = $todo->waktu_selesai;
                
                    $waktu_terpakai[] = $data_waktu;
                }
                return response([
                    'success' => true,
                    'message' => 'Data Jadwal Penggunaan Ruangan',
                    'data' => $waktu_terpakai
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Data Kosong !',
                ]);
            }
        }
    }

    // Proses Peminjaman 
    public function peminjamanStore(Request $request){
        // Validate Data
        $validator = Validator::make($request->all(),[
            'nama_kegiatan' => 'required',
            'nama_peminjam' => 'required',
            'nohp' => 'required',
            'pemilik_kegiatan' => 'required',
            'jadwal' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'id_ruangan' => 'required',
            'jumlah_orang' => 'required',
            'deskripsi_kegiatan' => 'required',
        ],
            [
                'nama_kegiatan.required' => 'Masukkan Nama Kegiatan !',
                'nama_peminjam.required' => 'Masukkan Nama Peminjam Kegiatan !',
                'nohp.required' => 'Masukkan No HP Peminjam !',
                'pemilik_kegiatan.required' => 'Masukkan Pemilik Kegiatan !',
                'jadwal.required' => 'Masukkan Jadwal Kegiatan !',
                'waktu_mulai.required' => 'Masukkan Waktu Kegiatan !',
                'waktu_selesai.required' => 'Masukkan Waktu Kegiatan !',
                'id_ruangan.required' => 'Masukkan Id Ruangan !',
                'jumlah_orang.required' => 'Masukkan Jumlah Kegiatan !',
                'deskripsi_kegiatan.required' => 'Masukkan Deskripsi Kegiatan !',
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
            $peminjaman->nama_kegiatan = $request->input('nama_kegiatan');
            $peminjaman->nama_peminjam = $request->input('nama_peminjam');
            $peminjaman->nohp = $request->input('nohp');
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
                    'message' => 'Peminjaman Berhasil Di Ajukan !'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman Gagal Di Ajukan !',
                ], 200);
            }
        }
    }

    public function peminjamanEdit(Request $request){
        // Validate Data
        $validator = Validator::make($request->all(),[
            'id_user' => 'required',
            'nama_kegiatan' => 'required',
            'pemilik_kegiatan' => 'required',
            'jadwal' => 'required',
            'waktu' => 'required',
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
                'waktu.required' => 'Masukkan Waktu Kegiatan !',
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
                'waktu' => $request->input('waktu'),
                'id_user' => $request->input('id_user'),
                'id_ruangan' => $request->input('id_ruangan'),
                'jumlah_orang' => $request->input('jumlah_orang'),
                'deskripsi_kegiatan' => $request->input('deskripsi_kegiatan'),
                'keterangan_tambahan' => $request->input('keterangan_tambahan')
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
}




