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

// No Auth Token 
// -------------------------

// Halaman Beranda
Route::get("beritaberanda",'User\BeritaController@beritaberanda');

Route::get("beritauser",'User\BeritaController@beritauser');

Route::get("detailberita/{id}",'User\BeritaController@detailberita');

Route::get("ruanganberanda",'User\RuanganController@ruangan');

Route::get("detailruangan/{id}",'User\RuanganController@detailruangan');

Route::get("fasilitasuser",'User\FasilitasUserController@fasilitasuser');

Route::get("galeriuser",'User\GaleriUserController@galeriuser');

Route::get("ruanganpeminjaman",'User\PeminjamanUserController@ruanganpeminjaman');

Route::post("checkpeminjaman",'User\PeminjamanUserController@checkpeminjaman');

Route::post("peminjamanuser", 'User\PeminjamanUserController@peminjamanStore');

// Auth Token User
Route::middleware('auth:api')->group(function () {

    // Flow Peminjaman
    Route::post("dataforform",'User\PeminjamanUserController@dataforform');

    Route::post("validasiwaktu",'User\PeminjamanUserController@validasiwaktu');


    // Halaman profil

    Route::post("datapeminjamanuser", 'User\ProfilController@datapeminjamanuser');

    Route::post("peminjamanuser/edit", 'User\PeminjamanUserController@peminjamanEdit');

    Route::delete("peminjamanuser/{id}", 'User\PeminjamanUserController@peminjamanDelete');

    // Halaman Beranda

});


// Auth Token Admin
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

    Route::get("ruanganById/{id}",'CMS\RuanganController@ruanganById');

    Route::post("ruangan", 'CMS\RuanganController@ruanganSave');

    Route::post("ruangan/update", 'CMS\RuanganController@ruanganUpdate');

    Route::delete("ruangan/{id}", 'CMS\RuanganController@ruanganDelete');

    // Peminjaman EndPoint API

    Route::get("peminjaman",'CMS\PeminjamanController@peminjaman');

    Route::get("peminjamanapproved",'CMS\PeminjamanController@peminjamanapproved');

    Route::get("peminjamanpending",'CMS\PeminjamanController@peminjamanpending');
    
    Route::get("peminjamanrejected",'CMS\PeminjamanController@peminjamanrejected');

    Route::get("peminjamanById/{id}",'CMS\PeminjamanController@peminjamanById');

    Route::post("peminjaman", 'CMS\PeminjamanController@peminjamanSave');

    Route::post("peminjaman/update", 'CMS\PeminjamanController@peminjamanUpdate');

    Route::delete("peminjaman/{id}", 'CMS\PeminjamanController@peminjamanDelete');

    // Galeri Endpoint API

    Route::get("galericms",'CMS\GaleriController@galeri');

    Route::post("galericms", 'CMS\GaleriController@galeriSave');

    Route::delete("galericms/{id}", 'CMS\GaleriController@galeriDelete');

    // Fasilitas Umum Endpoint API

    Route::get("fasilitas",'CMS\FasilitasController@fasilitas');

    Route::post("fasilitas", 'CMS\FasilitasController@fasilitasSave');

    Route::delete("fasilitas/{id}", 'CMS\FasilitasController@fasilitasDelete');
});
