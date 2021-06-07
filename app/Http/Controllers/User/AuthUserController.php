<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\User;

class AuthUserController extends Controller
{
    public function __construct()
        {
            // $this->middleware('auth:api', ['except' => ['login']]);
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
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);
            // die(var_dump(auth('api')->attempt($credentials)));
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $user = json_decode(auth('api')->user(), true);

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
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'organisasi' => 'required',
            'nohp' => 'required'
        ]);

        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
            'organisasi' => $request->organisasi,
            'nohp' => $request->nohp
        ]);

        return response([
            'success' => true,
            'message' => 'Pendaftaran Berhasil, Silahkan Login',
            'data' => $user
        ], 200);
    }
}
