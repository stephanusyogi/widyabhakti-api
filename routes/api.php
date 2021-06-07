<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



// Auth Admin EndPoint API
Route::namespace('CMS')->group(function(){

    Route::post('loginadmin', 'AuthAdminController@login');

    Route::post('logoutadmin', 'AuthAdminController@logout');
});

// Auth User EndPoint API
Route::namespace('User')->group(function(){

    Route::post("loginuser",'AuthUserController@login');

    Route::post('logoutuser', 'AuthUserController@logout');
    
    Route::post('registeruser', 'AuthUserController@register');

});

Route::middleware('auth:api')->group(function () {

    // Flow Peminjaman

    Route::get("ruanganpeminjaman",'User\PeminjamanUserController@ruanganpeminjaman');

    Route::post("dataforform",'User\PeminjamanUserController@dataforform');
    
    Route::post("checkpeminjaman",'User\PeminjamanUserController@checkpeminjaman');

    Route::post("validasiwaktu",'User\PeminjamanUserController@validasiwaktu');

    Route::post("peminjamanuser", 'User\PeminjamanUserController@peminjamanStore');

    // Halaman profil

    Route::post("datapeminjamanuser", 'User\ProfilController@datapeminjamanuser');

    Route::post("peminjamanuser/edit", 'User\PeminjamanUserController@peminjamanEdit');

    Route::delete("peminjamanuser/{id}", 'User\PeminjamanUserController@peminjamanDelete');
});


Route::middleware('auth:admin')->group(function () {

    // Admin EndPoint API
    Route::get("admin",'CMS\AdminController@admin');

    Route::get("admin/{id}",'CMS\AdminController@adminByID');

    Route::post("admin", 'CMS\AdminController@adminSave');

    Route::post("admin/update", 'CMS\AdminController@adminUpdate');

    Route::delete("admin/{id}", 'CMS\AdminController@adminDelete');

    // User EndPoint API
    Route::get("user",'CMS\UserController@user');

    Route::get("user/{id}",'CMS\UserController@userByID');

    Route::post("user", 'CMS\UserController@userSave');

    Route::post("user/update", 'CMS\UserController@userUpdate');

    Route::delete("user/{id}", 'CMS\UserController@userDelete');

    // Berita EndPoint API
    Route::get("berita",'CMS\BeritaController@berita');

    Route::get("berita/{id}",'CMS\BeritaController@beritaByID');

    Route::post("berita", 'CMS\BeritaController@beritaSave');

    Route::post("berita/update", 'CMS\BeritaController@beritaUpdate');

    Route::delete("berita/{id}", 'CMS\BeritaController@beritaDelete');

    // Ruangan EndPoint API
    Route::get("ruangan",'CMS\RuanganController@ruangan');

    Route::post("ruangan", 'CMS\RuanganController@ruanganSave');

    Route::post("ruangan/update", 'CMS\RuanganController@ruanganUpdate');

    Route::delete("ruangan/{id}", 'CMS\RuanganController@ruanganDelete');

    // Peminjaman EndPoint API

    Route::get("peminjaman",'CMS\PeminjamanController@peminjaman');

    Route::get("peminjamanrutin",'CMS\PeminjamanController@peminjamanrutin');

    Route::post("peminjaman", 'CMS\PeminjamanController@peminjamanSave');

    Route::post("peminjaman/update", 'CMS\PeminjamanController@peminjamanUpdate');

    Route::delete("peminjaman/{id}", 'CMS\PeminjamanController@peminjamanDelete');
});
