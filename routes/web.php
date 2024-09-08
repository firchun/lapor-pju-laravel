<?php

use App\Http\Controllers\BoxControlController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\KerusakanController;
use App\Http\Controllers\laporanController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PemantauanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\BoxControl;
use App\Models\Fasilitas;
use App\Models\Kerusakan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $data = [
        'title' => 'Home',
    ];
    return view('pages.index', $data);
});
Route::get('/maps', function () {
    $data = [
        'title' => 'Peta sebaran PJU',
        'fasilitas' => Fasilitas::paginate(8)
    ];
    return view('pages.maps', $data);
});
Route::get('/kontak', function () {
    $data = [
        'title' => 'Kontak',
    ];
    return view('pages.kontak', $data);
});
Route::get('/laporan_user', function () {
    $data = [
        'title' => 'Data Laporan',
        'kerusakan' => Kerusakan::paginate(6)
    ];
    return view('pages.laporan', $data);
});
Route::get('/lapor-kerusakan/{code}', function ($code) {
    $data = [
        'title' => 'Buat Laporan Kerusakan',
        'fasilitas' => Fasilitas::where('code', $code)->first(),
    ];
    return view('pages.lapor_kerusakan', $data);
});
Route::post('/kerusakan/store',  [KerusakanController::class, 'store'])->name('kerusakan.store');
Route::get('/fasilitas/getall', [FasilitasController::class, 'getall'])->name('fasilitas.getall');
Auth::routes(['register' => false, 'reset' => false]);
Route::middleware(['auth:web'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/grafik', [App\Http\Controllers\HomeController::class, 'grafik'])->name('grafik');

    //akun managemen
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //customers managemen
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::post('/customers/store',  [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/edit/{id}',  [CustomerController::class, 'edit'])->name('customers.edit');
    Route::delete('/customers/delete/{id}',  [CustomerController::class, 'destroy'])->name('customers.delete');
    Route::get('/customers-datatable', [CustomerController::class, 'getCustomersDataTable']);
    Route::get('/pemeliharaan-datatable', [BoxControlController::class, 'getPemeliharaanDataTable']);
    Route::get('/pemantauan-datatable', [PemantauanController::class, 'getPemantauanDataTable']);
    Route::get('/laporan/pemantauan', [laporanController::class, 'pemantauan'])->name('laporan.pemantauan');
    Route::get('/laporan/print-pemantauan', [laporanController::class, 'print_pemantauan'])->name('laporan.print_pemantaun');
    Route::get('/laporan/print-pemeliharaan', [laporanController::class, 'print_pemeliharaan'])->name('laporan.print_pemeliharaan');
});
Route::middleware(['auth:web', 'role:Admin'])->group(function () {
    //box control managemen
    Route::get('/box-control', [BoxControlController::class, 'index'])->name('box-control');
    Route::post('/box-control/store',  [BoxControlController::class, 'store'])->name('box-control.store');
    Route::post('/box-control/update',  [BoxControlController::class, 'update'])->name('box-control.update');
    Route::get('/box-control/edit/{id}',  [BoxControlController::class, 'edit'])->name('box-control.edit');
    Route::get('/box-control/print/{id}',  [BoxControlController::class, 'print'])->name('box-control.print');
    Route::delete('/box-control/delete/{id}',  [BoxControlController::class, 'destroy'])->name('box-control.delete');
    Route::get('/box-control-datatable', [BoxControlController::class, 'getBoxControlDataTable']);
    //mitra managemen
    Route::get('/mitra', [MitraController::class, 'index'])->name('mitra');
    Route::post('/mitra/store',  [MitraController::class, 'store'])->name('mitra.store');
    Route::post('/mitra/update',  [MitraController::class, 'update'])->name('mitra.update');
    Route::get('/mitra/edit/{id}',  [MitraController::class, 'edit'])->name('mitra.edit');
    Route::delete('/mitra/delete/{id}',  [MitraController::class, 'destroy'])->name('mitra.delete');
    Route::get('/mitra-datatable', [MitraController::class, 'getMitraDataTable']);
    //fasilitas managemen
    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas');
    Route::post('/fasilitas/store',  [FasilitasController::class, 'store'])->name('fasilitas.store');
    Route::post('/fasilitas/update',  [FasilitasController::class, 'update'])->name('fasilitas.update');
    Route::get('/fasilitas/edit/{id}',  [FasilitasController::class, 'edit'])->name('fasilitas.edit');
    Route::get('/fasilitas/print/{id}',  [FasilitasController::class, 'print'])->name('fasilitas.print');
    Route::delete('/fasilitas/delete/{id}',  [FasilitasController::class, 'destroy'])->name('fasilitas.delete');
    Route::get('/fasilitas-datatable', [FasilitasController::class, 'getFasilitasDataTable']);
    //laporan managemen
    Route::get('/laporan/pemeliharaan', [laporanController::class, 'pemeliharaan'])->name('laporan.pemeliharaan');
    Route::get('/laporan/teknisi', [laporanController::class, 'teknisi'])->name('laporan.teknisi');
    Route::get('/laporan/perbaikan', [laporanController::class, 'perbaikan'])->name('laporan.perbaikan');
    Route::get('/laporan-teknisi-datatable', [laporanController::class, 'getTeknisiDataTable']);
    Route::get('/laporan-kerusakan-datatable', [KerusakanController::class, 'getKerusakanDataTable']);
    Route::get('/laporan/detail-laporan/{id}', [laporanController::class, 'detail_laporan'])->name('laporan.detail-laporan');
    Route::get('/laporan/print-teknisi', [laporanController::class, 'print_teknisi'])->name('laporan.print-teknisi');
    //user managemen
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/teknisi', [UserController::class, 'teknisi'])->name('users.teknisi');
    Route::get('/users/admin', [UserController::class, 'admin'])->name('users.admin');
    Route::post('/users/store',  [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}',  [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/users/delete/{id}',  [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/users-datatable/{role}', [UserController::class, 'getUsersDataTable']);
});
Route::middleware(['auth:web', 'role:Teknisi'])->group(function () {
    //pemeliharaan managemen
    Route::get('/pemantauan', [PemantauanController::class, 'index'])->name('pemantauan');
    Route::post('/pemantauan/store', [PemantauanController::class, 'store'])->name('pemantauan.store');
    //pemeliharaan managemen
    Route::post('/pemeliharaan/store', [BoxControlController::class, 'store_pemeliharaan'])->name('pemeliharaan.store');
    //kerusakan managemen
    Route::get('/kerusakan', [KerusakanController::class, 'index'])->name('kerusakan');
    Route::get('/kerusakan/input', [KerusakanController::class, 'input'])->name('kerusakan.input');
    // Route::post('/kerusakan/store',  [KerusakanController::class, 'store'])->name('kerusakan.store');
    Route::get('/kerusakan/update',  [KerusakanController::class, 'update'])->name('kerusakan.update');
    Route::post('/kerusakan/perbaikan',  [KerusakanController::class, 'perbaikan'])->name('kerusakan.perbaikan');
    Route::post('/kerusakan/selesai',  [KerusakanController::class, 'selesai'])->name('kerusakan.selesai');
    Route::get('/kerusakan/update-status',  [KerusakanController::class, 'updateStatus'])->name('kerusakan.update-status');
    Route::get('/kerusakan/detail/{id}',  [KerusakanController::class, 'show'])->name('kerusakan.detail');
    Route::get('/kerusakan/terima/{id}',  [KerusakanController::class, 'terima'])->name('kerusakan.terima');
    Route::get('/kerusakan/tolak/{id}',  [KerusakanController::class, 'tolak'])->name('kerusakan.tolak');
    Route::get('/kerusakan-datatable', [KerusakanController::class, 'getKerusakanDataTable']);
    //laporan managemen
    Route::get('/laporan/pemeliharaan-teknisi', [laporanController::class, 'pemeliharaan_teknisi'])->name('laporan.pemeliharaan-teknisi');
    Route::get('/laporan/perbaikan-teknisi', [laporanController::class, 'perbaikan_teknisi'])->name('laporan.perbaikan-teknisi');
    Route::get('/laporan/datatable-perbaikan-teknisi', [laporanController::class, 'getPerbaikanTeknisiDataTable']);
    Route::get('/laporan/akhir-teknisi', [laporanController::class, 'akhir_teknisi'])->name('laporan.akhir-teknisi');
    Route::get('/laporan/datatable-akhir-teknisi', [laporanController::class, 'getAkhirTeknisiDataTable']);
});