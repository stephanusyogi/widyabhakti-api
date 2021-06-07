<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use JWTAuthException;
use Config;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Admin;

class AuthAdminController extends Controller
{
    public function __construct()
        {
            $this->middleware('auth:admin', ['except' => ['login', 'logout']]);
        }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // $admin = Admin::create([
        //     'name' => $request->name,
        //     'username' => $request->username,
        //     'password' => bcrypt($request->password),
        //     'status' => $request->status,
        // ]);

        $credentials = request(['username', 'password']);

        if (! $token = auth('admin')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = json_decode(auth('admin')->user(), true);
        // die(var_dump($user));
        return response([
            'success' => true,
            'message' => 'Login Berhasil',
            'data' => [
                'userdata' => $user,
                'token' => $token
            ]
        ], 200);
    }

    public function logout()
    {
        // die(var_dump("test"));
        auth('admin')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
