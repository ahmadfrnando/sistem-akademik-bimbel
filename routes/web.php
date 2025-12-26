<?php

use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\CetakController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Guru\JadwalController as GuruJadwalController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\KelolaGuruKelasController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\AjaxLoadController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Kepsek\DashboardController as KepsekDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guru\SiswaController as GuruSiswaController;
use App\Http\Controllers\Guru\KelolaPembelajaranController;
use App\Http\Controllers\Admin\KelolaSiswaKelasController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Siswa\LaporanController as SiswaLaporanController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Siswa\NilaiController as SiswaNilaiController;
use App\Http\Controllers\Admin\PembelajaranController;
use App\Http\Controllers\Guru\PembelajaranController as GuruPembelajaranController;
use App\Http\Controllers\Guru\TugasController as GuruTugasController;
use App\Http\Controllers\Admin\TugasController as AdminTugasController;
use App\Http\Controllers\Guru\PertanyaanController as GuruPertanyaanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Guru\UserController as GuruUserController;
use App\Http\Controllers\Siswa\UserController as SiswaUserController;
use App\Http\Controllers\Siswa\JawabanPilihanGandaSiswaController;
use App\Http\Controllers\Siswa\TugasController;
use App\Http\Controllers\Siswa\TugasController as SiswaTugasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Siswa\PembelajaranController as SiswaPembelajaranController;


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

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::get('/', [AuthController::class, 'showLoginForm'])->name('home');
Route::post('/', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/pengaturan-akun', [AuthController::class, 'edit'])->name('pengaturan-akun.edit');
Route::put('/pengaturan-akun', [AuthController::class, 'update'])->name('pengaturan-akun.update');
Route::get('/search-guru', [AjaxLoadController::class, 'getGuru'])->name('search.guru');
Route::get('/search-siswa', [AjaxLoadController::class, 'getSiswa'])->name('search.siswa');
Route::get('/search-jadwal-pembelajaran', [AjaxLoadController::class, 'getJadwalPembelajaran'])->name('search.jadwal.pembelajaran');
// Route::get('/tests-import', [GuruDashboardController::class, 'import']);
Route::get('admin/siswa/cetak', [LaporanController::class, 'cetakSiswa'])->name('admin.siswa.cetak');
Route::get('admin/nilai/cetak/{semester}', [LaporanController::class, 'cetakNilai'])->name('admin.nilai.cetak');
Route::get('siswa/nilai/cetak/{semester}', [SiswaLaporanController::class, 'cetakNilai'])->name('siswa.nilai.cetak');

Route::middleware(['auth', 'role:1'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::post('/jadwal/destroy', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    //pembelajaran
    Route::get('/pembelajaran', [PembelajaranController::class, 'index'])->name('pembelajaran.index');

    Route::resource('/siswa', SiswaController::class);
    //guru
    Route::resource('/guru', GuruController::class);
    // untuk pengaturan akun admin
    Route::resource('/user', UserController::class);
    // untuk akun guru dan siswa
    Route::get('/edit-akun/{id}', [AkunController::class, 'edit'])->name('akun.edit');
    Route::put('/ubah-akun/{id}', [AkunController::class, 'updateAkun'])->name('akun.update');
    Route::put('/ubah-password/{id}', [AkunController::class, 'updatePassword'])->name('password.update');

    // tugas
    Route::get('/tugas', [AdminTugasController::class, 'index'])->name('tugas.index');
    Route::get('/tugas/{id}', [AdminTugasController::class, 'show'])->name('tugas.show');
    Route::get('/tugas/{id}/submissions', [AdminTugasController::class, 'submissions'])->name('tugas.submissions');
    Route::get('/tugas/{tugas}/submissions/{siswa}/show', [AdminTugasController::class, 'submissionsShow'])->name('tugas.submissions.show');

    // kelola nilai
    Route::resource('/nilai', NilaiController::class);
});
Route::middleware(['auth', 'role:2'])->name('guru.')->prefix('guru')->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
    Route::get('/user/edit-username', [GuruUserController::class, 'editUsername'])->name('user.edit-username');
    Route::put('/user/update-username', [GuruUserController::class, 'updateUsername'])->name('user.update-username');
    Route::get('/user/edit-password', [GuruUserController::class, 'editPassword'])->name('user.edit-password');
    Route::put('/user/update-password', [GuruUserController::class, 'updatePassword'])->name('user.update-password');
    Route::resource('/siswa', GuruSiswaController::class);
    // pembelajaran
    Route::get('/pembelajaran', [GuruPembelajaranController::class, 'index'])->name('pembelajaran.index');
    Route::get('/pembelajaran/edit', [GuruPembelajaranController::class, 'edit'])->name('pembelajaran.edit');
    Route::post('/pembelajaran/store', [GuruPembelajaranController::class, 'store'])->name('pembelajaran.store');
    Route::post('/pembelajaran/destroy', [GuruPembelajaranController::class, 'destroy'])->name('pembelajaran.destroy');
    // tugas
    Route::get('/tugas', [GuruTugasController::class, 'index'])->name('tugas.index');
    Route::get('/tugas/{id}', [GuruTugasController::class, 'show'])->name('tugas.show');
    Route::get('/tugas/{id}/submissions', [GuruTugasController::class, 'submissions'])->name('tugas.submissions');
    Route::get('/tugas/{tugas}/submissions/{siswa}/show', [GuruTugasController::class, 'submissionsShow'])->name('tugas.submissions.show');
    Route::get('/tugas/edit', [GuruTugasController::class, 'edit'])->name('tugas.edit');
    Route::post('/tugas/store', [GuruTugasController::class, 'store'])->name('tugas.store');
    Route::post('/tugas/destroy', [GuruTugasController::class, 'destroy'])->name('tugas.destroy');
    Route::post('/tugas/send', [GuruTugasController::class, 'send'])->name('tugas.send');
    Route::post('/tugas/import', [GuruTugasController::class, 'import'])->name('tugas.import');
    Route::get('/tugas/template', [GuruTugasController::class, 'template'])->name('tugas.template');

    // pertanyaan
    Route::get('/pertanyaan', [GuruPertanyaanController::class, 'index'])->name('pertanyaan.index');
    Route::post('/pertanyaan', [GuruPertanyaanController::class, 'store'])->name('pertanyaan.store');
    Route::post('/pertanyaan/destroy', [GuruPertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');
    // jadwal
    Route::get('/jadwal', [GuruJadwalController::class, 'index'])->name('jadwal.index');
});
Route::middleware(['auth', 'role:3'])->name('siswa.')->prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/user/edit-username', [SiswaUserController::class, 'editUsername'])->name('user.edit-username');
    Route::put('/user/update-username', [SiswaUserController::class, 'updateUsername'])->name('user.update-username');
    Route::get('/user/edit-password', [SiswaUserController::class, 'editPassword'])->name('user.edit-password');
    Route::put('/user/update-password', [SiswaUserController::class, 'updatePassword'])->name('user.update-password');

    // tugas
    Route::get('/tugas', [SiswaTugasController::class, 'index'])->name('tugas.index');
    Route::get('/tugas/{tugas}/show', [SiswaTugasController::class, 'show'])->name('tugas.show');
    Route::get('/tugas/{tugas}/submissions/{siswa}', [SiswaTugasController::class, 'submissions'])->name('tugas.show.submissions');
    // jawaban
    Route::post('/jawaban-pg/store', [JawabanPilihanGandaSiswaController::class, 'store'])->name('jawaban-pg.store');

    //pembelajaran
    Route::resource('/pembelajaran', SiswaPembelajaranController::class);

    // nilai
    Route::resource('/nilai', SiswaNilaiController::class)->only(['index', 'show']);
});
Route::middleware(['auth', 'role:4'])->name('kepsek.')->prefix('kepsek')->group(function () {
    Route::get('/dashboard', [KepsekDashboardController::class, 'index'])->name('dashboard');
});

Route::get('/test', function () {
    $data = \App\Models\Tugas::with('jadwal')->findOrFail(2);

    return response()->json([
        'success' => true,
        'data'    => $data,
        'jadwal'  => $data->jadwal
    ]);
});
