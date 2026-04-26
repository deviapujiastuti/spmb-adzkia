<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/program-studi', function () {
    return view('prodi');
});

Route::get('/berita', function () {
    return view('berita');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/login-admin', function () { 
    return view('login-admin');
});

Route::get('/admin', function () {
    return view('admin.dashboard'); 
});

Route::get('/admin/pendaftar', function () { 
    return view('admin.pendaftar'); 
});

Route::get('/admin/validasi', function () { 
    return view('admin.validasi-index'); 
});

Route::get('/admin/validasi-pembayaran', function () { 
    return view('admin.validasi-pembayaran');
});

Route::get('/admin/validasi-daftar-ulang', function () { 
    return view('admin.validasi-daftar-ulang'); 
});

Route::get('/admin/pengumuman', function () {
    return view('admin.pengumuman');
});

Route::get('/admin/prodi', function () {
    return view('admin.prodi');
});

Route::get('/admin/berita', function () {
    return view('admin.berita');
});

Route::get('/admin/berita/create', function () { 
    return view('admin.berita-create'); 
});

Route::get('/admin/faq', function () {
    return view('admin.faq');
});

Route::get('/admin/settings', function () {
    return view('admin.settings');
});


Route::get('/rekomendasi/mulai', function () { 
    return view('user.rekomendasi-start'); 
}); 

Route::get('/rekomendasi/kuesioner', function () { 
    return view('user.kuesioner'); 
});
Route::get('/rekomendasi/hasil', function () { 
    return view('user.hasil-rekomendasi'); 
});

Route::get('/register', function () {
    return view('user.register');
});

Route::get('/pembayaran', function () {
    return view('user.pembayaran');
});
Route::get('/validasi-pembayaran', function () {
    return view('user.validasi-pembayaran');
});

Route::get('/biodata', function () {
    return view('user.formulir');
});

Route::get('/konfirmasi-data', function () {
    return view('user.konfirmasi-data');
});

Route::get('/validasi-akhir', function () {
    return view('user.validasi-akhir');
});

Route::get('/sukses', function () {
    return view('user.sukses');
});