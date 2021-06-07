<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\CMS\UserModel;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserController extends Controller
{
    //
    public function user(){
        $user = User::get();
        $user = json_decode($user, true);
        return response([
            'success' => true,
            'message' => 'List Semua User',
            'data' => $user
        ], 200);
    }

    public function userByID($id){
        return response()->json(User::where('id',$id)->first(), 200);
    }

    public function userSave(Request $request){
        // Validate Data
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'email|required',
            'username' => 'required',
            'password' => 'required',
            'organisasi' => 'required',
            'nohp' => 'required'
        ],
            [
                'name.required' => 'Masukkan Nama User !',
                'email.required' => 'Masukkan Email User !',
                'username.required' => 'Masukkan Username User !',
                'password.required' => 'Masukkan Password User !',
                'organisasi.required' => 'Masukkan Organisasi User !',
                'nohp.required' => 'Masukkan Nomor Handphone User !'
            ]
        );

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
        }else{
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'username' => $request->input('username'),
                'password' => $request->input('password'),
                'organisasi' => $request->input('organisasi'),
                'nohp' => $request->input('nohp')
            ]);

            if($user){
                return response()->json([
                    'success' => true,
                    'message' => 'User Berhasil Disimpan !'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'User Gagal Disimpan !',
                ], 401);
            }
        }
    }

    public function userUpdate(Request $request){
        // Validate Data
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'email|required',
            'username' => 'required',
            'organisasi' => 'required',
            'nohp' => 'required'
        ],
            [
                'name.required' => 'Masukkan Nama User !',
                'email.required' => 'Masukkan Email User !',
                'username.required' => 'Masukkan Username User !',
                'organisasi.required' => 'Masukkan Organisasi User !',
                'nohp.required' => 'Masukkan Nomor Handphone User !'
            ]
        );
        

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
            
        }else{
            $user = User::where('id', $request->input('id'))->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'username' => $request->input('username'),
                'password' => $request->input('password'),
                'organisasi' => $request->input('organisasi'),
                'nohp' => $request->input('nohp') 
            ]);

            if($user){
                return response()->json([
                    'success' => true,
                    'message' => 'User Berhasil Disimpan !'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'User Gagal Disimpan !',
                ], 401);
            }
        }
    }

    public function userDelete($id)
    {
        $user = User::where('id',$id);
        $user->delete();

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User Gagal Dihapus!',
            ], 400);
        }

    }
}
