<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\CMS\AdminModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Admin;
use JWTAuth;

class AdminController extends Controller
{
    //

    public function admin(){
        // die(var_dump('test'));
        $admin = Admin::get();
        $admin = json_decode($admin, true);
        return response([
            'success' => true,
            'message' => 'List Semua Admin',
            'data' => $admin
        ], 200);
        // return auth('admin')->user();
    }

    public function adminByID($id){
        return response()->json(Admin::where('id',$id)->first(), 200);
    }

    public function adminSave(Request $request){
        // Validate Data
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'status' => 'required'
        ],
            [
                'name.required' => 'Masukkan Nama Admin !',
                'username.required' => 'Masukkan Username Admin !',
                'password.required' => 'Masukkan Password Admin !',
                'status.required' => 'Masukkan Status Admin !'
            ]
        );

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
        }else{
            $admin = Admin::create([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'password' => bcrypt($request->input('password')),
                'status' => $request->input('status')
            ]);

            if($admin){
                return response()->json([
                    'success' => true,
                    'message' => 'Admin Berhasil Disimpan !'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Admin Gagal Disimpan !',
                ], 401);
            }
        }
    }

    public function adminUpdate(Request $request){
        // Validate Data
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'username' => 'required',
            'status' => 'required'
        ],
            [
                'name.required' => 'Masukkan Nama Admin !',
                'username.required' => 'Masukkan Username Admin !',
                'status.required' => 'Masukkan Status Admin !'
            ]
        );
        

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Field Kosong',
                'data' => $validator->errors()
            ], 401);
            
        }else{
            $admin = Admin::where('id', $request->input('id'))->update([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'password' => bcrypt($request->input('password')),
                'status' => $request->input('status') 
            ]);

            if($admin){
                return response()->json([
                    'success' => true,
                    'message' => 'Admin Berhasil Di Update !'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Admin Gagal Di Update !',
                ], 401);
            }
        }
    }

    public function adminDelete($id)
    {
        $admin = Admin::where('id',$id);
        $admin->delete();

        if ($admin) {
            return response()->json([
                'success' => true,
                'message' => 'Admin Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Admin Gagal Dihapus!',
            ], 400);
        }

    }
}
