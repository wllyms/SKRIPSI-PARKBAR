<?php

use Carbon\Carbon;
use App\Models\Userr;
use App\Models\LaporanPengunjung;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\staffController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\TuserController;
use App\Http\Controllers\UserrController;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\SlotParkirController;
use App\Http\Controllers\SubJabatanController;
use App\Http\Controllers\JenisPegawaiController;
use App\Http\Controllers\ParkirPegawaiController;
use App\Http\Controllers\DynamicFeedbackController;
use App\Http\Controllers\LaporanKepuasanController;
use App\Http\Controllers\LaporanPengunjungController;
use App\Http\Controllers\StaffController as ControllersStaffController;



// LOGIN & LOGOT
Route::get('/login', [SesiController::class, 'index'])->name('login');
Route::post('/login', [SesiController::class, 'login']);
Route::post('/logout', [SesiController::class, 'logout'])->name('logout');




Route::middleware(['role:super_admin,admin'])->group(function () {

    Route::get('/beranda', [ParkirController::class, 'dashboard'])->name('beranda');

    // BERANDA
    Route::get('/parkir', [ParkirController::class, 'tampilkanKendaraanTerparkir']);


    // PEGAWAI
    Route::get('/pegawai', [PegawaiController::class, 'tampil'])->name('manajemen-pegawai.tampil');
    Route::post('/pegawai/submit/', [PegawaiController::class, 'submit'])->name('manajemen-pegawai.submit');
    Route::put('/pegawai/update/{id}', [PegawaiController::class, 'update'])->name('manajemen-pegawai.update');
    Route::delete('/pegawai/delete/{id}', [PegawaiController::class, 'delete'])->name('manajemen-pegawai.delete');


    // PARKIR
    Route::get('/parkirbiasa', [ParkirController::class, 'tampil'])->name('manajemen-parkir.tampil');
    Route::post('/parkir/submit', [ParkirController::class, 'submit'])->name('manajemen-parkir.submit');
    Route::put('/parkir/keluar/{id}', [ParkirController::class, 'keluar'])->name('manajemen-parkir.keluar');
    Route::delete('/parkir/delete/{id}', [ParkirController::class, 'delete'])->name('manajemen-parkir.delete');


    // DENDA
    Route::get('/denda', [DendaController::class, 'tampil'])->name('manajemen-denda.tampil');
    Route::post('/denda/bayar/{id}', [DendaController::class, 'bayar'])->name('manajemen-denda.bayar');
    // Route::put('/parkir/keluar/{id}', [ParkirController::class, 'keluar'])->name('manajemen-parkir.keluar');
    // Route::delete('/parkir/delete/{id}', [ParkirController::class, 'delete'])->name('manajemen-parkir.delete');


    //PENGADUAN PENGUNJUNG
    Route::get('/pengunjung', [LaporanPengunjungController::class, 'tampil'])->name('manajemen-pengaduan.tampil');
    Route::post('/pengunjung/submit/', [LaporanPengunjungController::class, 'submit'])->name('manajemen-pengaduan.submit');
    Route::put('/pengunjung/update/{id}', [LaporanPengunjungController::class, 'update'])->name('manajemen-pengaduan.update');
    Route::delete('/laporan-pengunjung/{id}', [LaporanPengunjungController::class, 'delete'])->name('manajemen-pengaduan.delete');;


    // SCAN PARKIR BIASA
    Route::post('/proses-scan-keluar', [ParkirController::class, 'prosesScanKeluar'])->name('proses.scan.keluar');
    Route::get('/parkir-keluar', [ParkirController::class, 'scanKeluar'])->name('manajemen-parkir.scan-keluar');


    // CETAK STRUK PARKIR
    Route::get('/cetak-struk/{id}', [ParkirController::class, 'cetakStruk'])->name('parkir.cetak-struk');


    // SCAN PEGAWAI 
    Route::get('/scan-pegawai', [ParkirPegawaiController::class, 'tampil'])->name('scanpegawai.tampil');
    Route::post('/process-scan-pegawai', [ParkirPegawaiController::class, 'submit'])->name('process.scanpegawai');


    // CETAK STRUK PARKIR DAN ID CARD PEGAWAI
    Route::get('/parkir/cetak-pdf/{id}', [ParkirController::class, 'cetakParkir'])->name('manajemen-parkir.cetak-parkir');
    Route::get('/pegawai/cetak-pdf{id}', [PegawaiController::class, 'cetakPegawai'])->name('manajemen-pegawai.detailpegawai');


    // LAPORAN DAN CETAK PARKIR
    Route::get('/laporan-parkir', [ParkirController::class, 'laporan'])->name('laporan.parkir');
    Route::get('/laporan/parkir/cetak', [ParkirController::class, 'cetakLaporan'])->name('laporan.parkir.cetak');


    // LAPORAN DAN CETAK PEGAWAI
    Route::get('/laporan-pegawai', [PegawaiController::class, 'laporan'])->name('laporan.pegawai');
    Route::get('/laporan-pegawai/cetak', [PegawaiController::class, 'cetakLaporan'])->name('laporan.pegawai.cetak');
    Route::get('/laporan/pegawai/detail/{id}', [PegawaiController::class, 'showDetail'])->name('laporan.detailpegawai.show');
    Route::get('/laporan/pegawai/detail/cetak/{id}', [PegawaiController::class, 'cetakDetailPegawai'])->name('laporan.detailpegawai.cetak');


    // LAPORAN DAN CETAK PENDAPATAN
    Route::get('/laporan-pendapatan', [ParkirController::class, 'laporanPendapatan'])->name('laporan.pendapatan');
    Route::get('/laporan-pendapatan/cetak', [ParkirController::class, 'cetakPendapatan'])->name('laporan.pendapatan.cetak');


    // LAPORAN DAN CETAK PARKIR-PEGAWAI
    Route::get('/laporan-parkirpegawai', [ParkirPegawaiController::class, 'laporan'])->name('laporan.parkirpegawai');
    Route::get('/laporan/pegawai/cetak', [ParkirPegawaiController::class, 'cetakLaporan'])->name('laporan.parkirpegawai.cetak');


    // LAPORAN PENGADUAN
    Route::get('/laporan-pengaduan', [LaporanPengunjungController::class, 'laporan'])->name('laporan.pengaduan');
    Route::get('/laporan/pengaduan/cetak', [LaporanPengunjungController::class, 'cetak'])->name('laporan.pengaduan.cetak');


    // LAPORAN SLOT PARKIR
    Route::get('/laporan-slotparkir', [SlotParkirController::class, 'laporanSlot'])->name('laporan.slot');
    Route::get('/laporan/slot-parkir/pdf', [SlotParkirController::class, 'cetakPDF'])->name('laporan.slot.pdf');

    // LAPORAN DENDA
    Route::get('/laporan-denda', [DendaController::class, 'laporanDenda'])->name('laporan.denda');
    Route::get('/laporan/denda/cetak', [DendaController::class, 'cetak'])->name('laporan.denda.cetak');

    // RIWAYAT PEGAWAI
    Route::get('/pegawai/{id}/riwayat/create', [PegawaiController::class, 'formRiwayat'])->name('pegawai.riwayat.create');
    Route::post('/pegawai/{id}/riwayat', [PegawaiController::class, 'TambahRiwayat'])->name('pegawai.riwayat.store');

    Route::get('/feedback/v2/{kode_parkir}', [DynamicFeedbackController::class, 'tampilkanForm'])->name('feedback.dynamic.show');
    Route::get('/kepuasan/cetak', [LaporanKepuasanController::class, 'cetakPDF'])->name('laporan.kepuasan.cetak');
});


Route::middleware(['role:super_admin'])->group(function () {

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


    // JABATAN
    Route::get('/jabatan', [JabatanController::class, 'tampil'])->name('manajemen-jabatan.tampil');
    Route::post('/jabatan/submit', [JabatanController::class, 'submit'])->name('manajemen-jabatan.submit');
    Route::post('/jabatan/update/{id}', [JabatanController::class, 'update'])->name('manajemen-jabatan.update');
    Route::get('/jabatan/delete/{id}', [JabatanController::class, 'delete'])->name('manajemen-jabatan.delete');


    // SUB JABATAN
    Route::get('/sub-jabatan', [SubJabatanController::class, 'tampil'])->name('manajemen-subjabatan.tampil');
    Route::post('/sub-jabatan/submit', [SubJabatanController::class, 'submit'])->name('manajemen-subjabatan.submit');
    Route::post('/sub-jabatan/update/{id}', [SubJabatanController::class, 'update'])->name('manajemen-subjabatan.update');
    Route::get('/sub-jabatan/delete/{id}', [SubJabatanController::class, 'delete'])->name('manajemen-subjabatan.delete');


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


    // SLOT PARKIR
    Route::get('/slot', [SlotParkirController::class, 'tampil'])->name('manajemen-slot.tampil');
    Route::post('/slot/submit', [SlotParkirController::class, 'submit'])->name('manajemen-slot.submit');
    Route::put('/slot/update/{id}', [SlotParkirController::class, 'update'])->name('manajemen-slot.update');
    Route::delete('/slot/delete/{id}', [SlotParkirController::class, 'delete'])->name('manajemen-slot.delete');


    // FEEDBACK

    Route::post('/feedback/v2', [DynamicFeedbackController::class, 'simpanPenilaian'])->name('feedback.dynamic.store');

    // KUESIONER
    Route::get('/kuesioner', [KuesionerController::class, 'tampil'])->name('kuesioner.tampil');
    Route::post('/kuesioner/submit', [KuesionerController::class, 'submit'])->name('kuesioner.submit');
    Route::put('/kuesioner/update/{id}', [KuesionerController::class, 'update'])->name('kuesioner.update');
    Route::delete('/kuesioner/delete/{id}', [KuesionerController::class, 'delete'])->name('kuesioner.delete');

    //LAPORAN KUESIONER
    Route::get('/laporan-kepuasan', [LaporanKepuasanController::class, 'index'])->name('laporan.kepuasan.index');
});
