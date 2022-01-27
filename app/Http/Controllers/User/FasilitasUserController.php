<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Fasilitas;

class FasilitasUserController extends Controller
{
    //
    public function fasilitasuser(){
        $fasilitas = Fasilitas::get();
        $fasilitas = json_decode($fasilitas, true);
        return response([
            'success' => true,
            'message' => 'List Semua Fasilitas Umum',
            'data' => $fasilitas
        ], 200);
    }

}
