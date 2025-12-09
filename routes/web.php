<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\{DashboardController,
GuruController,
SiswaController,
KelasController,
MapelController,
PembelajaranController,
EkskulController,
InfoSekolahController,
CetakController};
use App\Http\Controllers\{AdminTugasController,   
AdminUlanganController,
AdminSTSController,
AdminSASController,
AdminSATController,
AdminRaporController,
AdminCetakController};
use App\Http\Controllers\InputNilaiGuruController;
use App\Http\Controllers\InputNilaiWaliController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// === Auth ===
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function() {

    // Admin dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Guru dashboard
    Route::get('/guru/dashboard', [DashboardController::class, 'indexGuru'])->name('dashboard.guru');

    // Wali Kelas dashboard
    Route::get('/wali/dashboard', [DashboardController::class, 'indexWali'])->name('dashboard.wali');
});


// === Halaman Admin ===
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/info_sekolah', [InfoSekolahController::class, 'infoSekolah'])->name('dashboard.info_sekolah');
Route::post('/dashboard/info_sekolah/update', [InfoSekolahController::class, 'update_info_sekolah'])->name('dashboard.info_sekolah.update');

// === Halaman Data Kelas ===
Route::prefix('dashboard')->group(function () {
    Route::get('/data_kelas', [KelasController::class, 'index'])->name('dashboard.data_kelas');
    Route::post('/data_kelas/store', [KelasController::class, 'store'])->name('dashboard.data_kelas.store'); // ⬅️ Tambahkan ini
    Route::put('/data_kelas/{id_kelas}', [KelasController::class, 'update'])->name('dashboard.data_kelas.update');
    Route::delete('/data_kelas/{id_kelas}', [KelasController::class, 'destroy'])->name('dashboard.data_kelas.destroy');
    Route::get('data_kelas/{id_kelas}/export', [KelasController::class, 'exportKelas'])->name('dashboard.data_kelas.export.kelas');

    // anggota kelas
    Route::get('/data_kelas/{id_kelas}/anggota', [KelasController::class, 'anggota'])->name('dashboard.data_kelas.anggota');
    Route::post('/data_kelas/{id_kelas}/anggota', [KelasController::class, 'tambahAnggota'])->name('dashboard.data_kelas.anggota.tambah');
    Route::delete('/anggota/{id_siswa}/hapus', [KelasController::class, 'hapusAnggota'])->name('dashboard.data_kelas.anggota.hapus');

    //export
    Route::get('data_kelas/export/pdf', [KelasController::class, 'exportPdf'])->name('dashboard.data_kelas.export.pdf');
    Route::get('data_kelas/export/csv', [KelasController::class, 'exportCsv'])->name('dashboard.data_kelas.export.csv');
});


Route::get('dashboard/data_guru', [GuruController::class, 'dataGuru'])->name('dashboard.data_guru');
Route::post('dashboard/data_guru', [GuruController::class, 'store'])->name('dashboard.data_guru.store');
Route::get('dashboard/data_guru/{id_guru}', [GuruController::class, 'show'])->name('dashboard.data_guru.show');
Route::put('dashboard/data_guru/{id_guru}', [GuruController::class, 'update'])->name('dashboard.data_guru.update');
Route::delete('dashboard/data_guru/{id_guru}', [GuruController::class, 'destroy'])->name('dashboard.data_guru.destroy');
Route::get('dashboard/data_guru/export/pdf', [GuruController::class, 'exportPdf'])->name('dashboard.data_guru.export.pdf');
Route::get('dashboard/data_guru/export/csv', [GuruController::class, 'exportCsv'])->name('dashboard.data_guru.export.csv');
Route::post('dashboard/data_guru/import/csv', [GuruController::class, 'importCsv'])->name('dashboard.data_guru.import');


// === Halaman Data Siswa ===
Route::get('dashboard/data_siswa', [SiswaController::class, 'dataSiswa'])->name('dashboard.data_siswa');
Route::post('dashboard/data_siswa', [SiswaController::class, 'store'])->name('dashboard.data_siswa.store');
Route::get('dashboard/data_siswa/{id_siswa}/edit', [SiswaController::class, 'edit'])->name('dashboard.data_siswa.edit');
Route::get('dashboard/data_siswa/{id_siswa}', [SiswaController::class, 'show'])->name('dashboard.data_siswa.show');
Route::put('dashboard/data_siswa/{id_siswa}', [SiswaController::class, 'update'])->name('dashboard.data_siswa.update');
Route::delete('dashboard/data_siswa/{id_siswa}', [SiswaController::class, 'destroy'])->name('dashboard.data_siswa.destroy');
Route::get('dashboard/data_siswa/{id_siswa}/export', [SiswaController::class, 'export'])->name('dashboard.data_siswa.export');
Route::get('dashboard/data_siswa/export/pdf', [SiswaController::class, 'exportPdf'])->name('dashboard.data_siswa.export.pdf');
Route::get('dashboard/data_siswa/export/csv', [SiswaController::class, 'exportCsv'])->name('dashboard.data_siswa.export.csv');
Route::post('dashboard/data_siswa/import/csv', [SiswaController::class, 'importCsv'])->name('dashboard.data_siswa.import.csv');



// === Halaman Data Mapel ===
Route::get('dashboard/data_mapel', [MapelController::class, 'dataMapel'])->name('dashboard.data_mapel');
Route::post('/dashboard/data_mapel/store', [MapelController::class, 'store'])->name('dashboard.data_mapel.store');
Route::put('/dashboard/data_mapel/update/{id_mapel}', [MapelController::class, 'update'])->name('dashboard.data_mapel.update');
Route::delete('/dashboard/data_mapel/delete/{id_mapel}', [MapelController::class, 'destroy'])->name('dashboard.data_mapel.delete');
//export
Route::get('/dashboard/data_mapel/export/pdf', [MapelController::class, 'exportPdf'])->name('dashboard.data_mapel.export.pdf');
Route::get('/dashboard/data_mapel/export/csv', [MapelController::class, 'exportCsv'])->name('dashboard.data_mapel.export.csv');

// === Halaman Data Pembelajaran ===
Route::get('dashboard/data_pembelajaran', [PembelajaranController::class, 'dataPembelajaran'])->name('dashboard.data_pembelajaran');
Route::post('/dashboard/data_pembelajaran/store', [PembelajaranController::class, 'store'])->name('dashboard.data_pembelajaran.store');
Route::put('/dashboard/data_pembelajaran/update/{id_pembelajaran}', [PembelajaranController::class, 'update'])->name('dashboard.data_pembelajaran.update');
Route::delete('/dashboard/data_pembelajaran/delete/{id_pembelajaran}', [PembelajaranController::class, 'destroy'])->name('dashboard.data_pembelajaran.delete');
//export
Route::get('/dashboard/data_pembelajaran/export/pdf', [PembelajaranController::class, 'exportPdf'])->name('dashboard.data_pembelajaran.export.pdf');
Route::get('/dashboard/data_pembelajaran/export/csv', [PembelajaranController::class, 'exportCsv'])->name('dashboard.data_pembelajaran.export.csv');


// === Halaman Data Ekskul ===
//CRUD Ekskul
Route::get('dashboard/data_ekskul', [EkskulController::class, 'dataEkskul'])->name('dashboard.data_ekskul');
Route::post('/dashboard/data_ekskul/store', [EkskulController::class, 'storeEkskul'])->name('dashboard.data_ekskul.storeEkskul');
Route::put('/dashboard/data_ekskul/update/{id_ekskul}', [EkskulController::class, 'updateEkskul'])->name('dashboard.data_ekskul.updateEkskul');
Route::delete('/dashboard/data_ekskul/delete/{id_ekskul}', [EkskulController::class, 'destroyEKskul'])->name('dashboard.data_ekskul.destroyEkskul');
//CRUD Siswa Ekskul
Route::post('dashboard/ekskul_siswa/store', [EkskulController::class, 'storeSiswaEkskul'])->name('dashboard.ekskul_siswa.storeEkskulSiswa');
Route::post('dashboard/ekskul_siswa/update/{id_ekskul_siswa}', [EkskulController::class, 'updateSiswaEkskul'])->name('dashboard.ekskul_siswa.updateEkskulSiswa');
Route::delete('dashboard/ekskul_siswa/delete/{id_ekskul_siswa}', [EkskulController::class, 'destroySiswaEkskul'])->name('dashboard.ekskul_siswa.destroyEkskulSiswa');
//export
Route::get('/dashboard/data_ekskul/export/pdf', [EkskulController::class, 'exportPdf'])->name('dashboard.data_ekskul.export.pdf');
Route::get('/dashboard/data_ekskul/export/csv', [EkskulController::class, 'exportCsv'])->name('dashboard.data_ekskul.export.csv');

//admin tugas
Route::get('input/tugas', [AdminTugasController::class, 'index'])->name('input.tugas');
Route::get('input/tugas/filter', [AdminTugasController::class, 'filter'])->name('input.tugas.filter');
Route::post('input/tugas/simpan', [AdminTugasController::class, 'simpanSemua'])->name('input.tugas.simpan');
// Export Tugas
Route::get('/input/tugas/export/pdf', [AdminTugasController::class, 'exportPdf'])
    ->name('input.tugas.export.pdf');
Route::get('/input/tugas/export/csv', [AdminTugasController::class, 'exportCsv'])
    ->name('input.tugas.export.csv');

Route::get('input/tugas', [AdminTugasController::class, 'inputTugas'])->name('input.tugas');

Route::get('input/ulangan', [AdminUlanganController::class, 'inputUlangan'])->name('input.ulangan');
Route::get('input/ulangan/simpan', [AdminUlanganController::class, 'simpanUlangan'])->name('input.ulangan.simpan');
Route::post('/input/ulangan/simpan', [AdminUlanganController::class, 'simpanUlangan'])->name('input.ulangan.simpan');



Route::get('input/sts', [AdminSTSController::class, 'inputSTS'])->name('input.sts');
Route::get('input/sas', [AdminSASController::class, 'inputSAS'])->name('input.sas');
Route::get('input/sat', [AdminSATController::class, 'inputSAT'])->name('input.sat');

Route::get('input/rapor', [AdminRaporController::class, 'inputRapor'])->name('input.rapor');
Route::post('/input/rapor/simpan', [AdminRaporController::class, 'simpanRapor'])->name('input.rapor.simpan');
Route::get('/get-siswa/{id_kelas}', [AdminRaporController::class, 'getSiswa']);


Route::get('input/cetak', [AdminCetakController::class, 'cetakNilai'])->name('input.cetak');

// === Halaman Guru ===
// Route::get('guru/dashboard', [DashboardController::class, 'index'])->name('dashboard.guru');

Route::prefix('guru')->name('guru.')->group(function () {
    Route::get('/input/tugas', [InputNilaiGuruController::class, 'inputTugas'])->name('input.tugas');
    Route::get('/input/ulangan', [InputNilaiGuruController::class, 'inputUlangan'])->name('input.ulangan');
    Route::get('/input/sts', [InputNilaiGuruController::class, 'inputSTS'])->name('input.sts');
    Route::get('/input/sas', [InputNilaiGuruController::class, 'inputSAS'])->name('input.sas');
    Route::get('/input/sat', [InputNilaiGuruController::class, 'inputSAT'])->name('input.sat');
});

// === Halaman Wali Kelas ===
// Route::get('wali/dashboard', [DashboardController::class, 'index'])->name('dashboard.wali');

Route::prefix('wali')->name('wali.')->group(function () {
    Route::get('/input/tugas', [InputNilaiWaliController::class, 'inputTugas'])->name('input.tugas');
    Route::get('/input/ulangan', [InputNilaiWaliController::class, 'inputUlangan'])->name('input.ulangan');
    Route::get('/input/sts', [InputNilaiWaliController::class, 'inputSTS'])->name('input.sts');
    Route::get('/input/sas', [InputNilaiWaliController::class, 'inputSAS'])->name('input.sas');
    Route::get('/input/sat', [InputNilaiWaliController::class, 'inputSAT'])->name('input.sat');
    Route::get('input/cetak', [InputNilaiWaliController::class, 'cetakNilai'])->name('input.cetak');
});

Route::prefix('cetak')->controller(CetakController::class)->group(function () {
    Route::get('/rapor', 'rapor')->name('cetak.rapor');
    Route::get('/rapor/pdf', 'raporPdf')->name('cetak.rapor.pdf');
});