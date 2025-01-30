<?php

use App\Models\Userr;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\staffController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\TuserController;
use App\Http\Controllers\UserrController;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\JenisPegawaiController;
use App\Http\Controllers\ParkirPegawaiController;
use App\Http\Controllers\StaffController as ControllersStaffController;

Route::get('/beranda', function () {
    return view('beranda');
});


// LOGIN & LOGOT
Route::get('/login', [SesiController::class, 'index'])->name('login');
Route::post('/login', [SesiController::class, 'login']);
Route::post('/logout', [SesiController::class, 'logout'])->name('logout');

// KATEGORI
Route::get('/kategori', [KategoriController::class, 'tampil'])->name('manajemen-kategori.tampil');
Route::post('/kategori/submit/', [KategoriController::class, 'submit'])->name('manajemen-kategori.submit');
Route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('manajemen-kategori.update');
Route::delete('/kategori/delete/{id}', [KategoriController::class, 'delete'])->name('manajemen-kategori.delete');

// STAFF
Route::get('/staff', [staffController::class, 'tampil'])->name('manajemen-staff.tampil');
Route::post('/staff/submit', [staffController::class, 'submit'])->name('manajemen-staff.submit');
Route::put('/staff/update/{id}', [staffController::class, 'update'])->name('manajemen-staff.update');
Route::delete('/staff/delete/{id}', [staffController::class, 'delete'])->name('manajemen-staff.delete');

// JENIS PEGAWAI
Route::get('/jenispegawai', [JenisPegawaiController::class, 'tampil'])->name('manajemen-JenisPegawai.tampil');
Route::post('/jenispegawai/submit', [JenisPegawaiController::class, 'submit'])->name('manajemen-JenisPegawai.submit');
Route::put('/jenispegawai/jenispegawai/{id}', [JenisPegawaiController::class, 'update'])->name('manajemen-JenisPegawai.update');
Route::delete('/jenispegawai/delete/{id}', [JenisPegawaiController::class, 'delete'])->name('manajemen-JenisPegawai.delete');

// USER
Route::get('/user', [TuserController::class, 'tampil'])->name('manajemen-user.tampil');
Route::post('/user/submit', [TuserController::class, 'submit'])->name('manajemen-user.submit');
Route::put('/user/update/{id}', [TuserController::class, 'update'])->name('manajemen-user.update');
Route::delete('/user/delete/{id}', [TuserController::class, 'delete'])->name('manajemen-user.delete');

// TARIF
Route::get('/tarif', [TarifController::class, 'tampil'])->name('manajemen-tarif.tampil');
Route::post('/tarif/submit/', [TarifController::class, 'submit'])->name('manajemen-tarif.submit');
Route::put('/tarif/update/{id}', [TarifController::class, 'update'])->name('manajemen-tarif.update');
Route::delete('/tarif/delete/{id}', [TarifController::class, 'delete'])->name('manajemen-tarif.delete');

// PEGAWAI
Route::get('/pegawai', [PegawaiController::class, 'tampil'])->name('manajemen-pegawai.tampil');
Route::post('/pegawai/submit/', [PegawaiController::class, 'submit'])->name('manajemen-pegawai.submit');
Route::put('/pegawai/update/{id}', [PegawaiController::class, 'update'])->name('manajemen-pegawai.update');
Route::delete('/pegawai/delete/{id}', [PegawaiController::class, 'delete'])->name('manajemen-pegawai.delete');

// PARKIR
Route::get('/parkir', [ParkirController::class, 'tampil'])->name('manajemen-parkir.tampil');
Route::post('/parkir/submit', [ParkirController::class, 'submit'])->name('manajemen-parkir.submit');
Route::put('/parkir/keluar/{id}', [ParkirController::class, 'keluar'])->name('manajemen-parkir.keluar');
Route::delete('/parkir/delete/{id}', [ParkirController::class, 'delete'])->name('manajemen-parkir.delete');


// SCAN PARKIR BIASA
Route::post('/process-scan-keluar', [ParkirController::class, 'processScanKeluar'])->name('process.scan.keluar');
Route::get('/parkir-keluar', [ParkirController::class, 'scanKeluar'])->name('manajemen-parkir.scan-keluar');


// SCAN PEGAWAI 
Route::get('/scan-pegawai', [ParkirPegawaiController::class, 'tampil'])->name('scanpegawai.tampil');
Route::post('/process-scan-pegawai', [ParkirPegawaiController::class, 'submit'])->name('process.scanpegawai');


// CETAK STRUK PARKIR DAN ID CARD PEGAWAI
Route::get('/parkir/cetak-pdf/{id}', [ParkirController::class, 'cetakParkir'])->name('manajemen-parkir.cetak-parkir');
Route::get('/pegawai/cetak-pdf{id}', [PegawaiController::class, 'cetakPegawai'])->name('manajemen-pegawai.detailpegawai');


// LAPORAN DAN CETAK PARKIR
Route::get('/laporanparkir', [ParkirController::class, 'laporan'])->name('laporan.parkir');
Route::get('/laporan/parkir/cetak', [ParkirController::class, 'cetakLaporan'])->name('laporan.parkir.cetak');


// LAPORAN DAN CETAK PEGAWAI
Route::get('/laporan/pegawai', [PegawaiController::class, 'laporan'])->name('laporan.pegawai');
Route::get('/laporan-pegawai/cetak', [PegawaiController::class, 'cetakLaporan'])->name('laporan.pegawai.cetak');
Route::get('/laporan-detailpegawai/cetak{id}', [PegawaiController::class, 'cetakDetailPegawai'])->name('laporan.detailpegawai.cetak');


// LAPORAN DAN CETAK PENDAPATAN
Route::get('/laporan-pendapatan', [ParkirController::class, 'laporanPendapatan'])->name('laporan.pendapatan');
Route::get('/laporan-pendapatan/cetak', [ParkirController::class, 'cetakPendapatan'])->name('laporan.pendapatan.cetak');


// LAPORAN DAN CETAK PARKIR-PEGAWAI
Route::get('/laporan/parkirpegawai', [ParkirPegawaiController::class, 'laporan'])->name('laporan.parkirpegawai');
Route::get('/laporan/pegawai/cetak', [ParkirPegawaiController::class, 'cetakLaporan'])->name('laporan.parkirpegawai.cetak');


// BERANDA
Route::get('/parkir', [ParkirController::class, 'tampilkanKendaraanTerparkir']);
