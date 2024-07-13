<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\KerusakanController;
use App\Http\Controllers\laporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

    //akun managemen
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //customers managemen
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::post('/customers/store',  [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/edit/{id}',  [CustomerController::class, 'edit'])->name('customers.edit');
    Route::delete('/customers/delete/{id}',  [CustomerController::class, 'destroy'])->name('customers.delete');
    Route::get('/customers-datatable', [CustomerController::class, 'getCustomersDataTable']);
});
Route::middleware(['auth:web', 'role:Admin'])->group(function () {
    //fasilitas managemen
    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas');

    Route::post('/fasilitas/store',  [FasilitasController::class, 'store'])->name('fasilitas.store');
    Route::post('/fasilitas/update',  [FasilitasController::class, 'update'])->name('fasilitas.update');
    Route::get('/fasilitas/edit/{id}',  [FasilitasController::class, 'edit'])->name('fasilitas.edit');
    Route::get('/fasilitas/print/{id}',  [FasilitasController::class, 'print'])->name('fasilitas.print');
    Route::delete('/fasilitas/delete/{id}',  [FasilitasController::class, 'destroy'])->name('fasilitas.delete');
    Route::get('/fasilitas-datatable', [FasilitasController::class, 'getFasilitasDataTable']);
    //laporan managemen
    Route::get('/laporan/perbaikan', [laporanController::class, 'perbaikan'])->name('laporan.perbaikan');
    Route::get('/laporan-kerusakan-datatable', [KerusakanController::class, 'getKerusakanDataTable']);
    Route::get('/laporan/detail-laporan/{id}', [laporanController::class, 'detail_laporan'])->name('laporan.detail-laporan');
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
    //kerusakan managemen

    Route::get('/kerusakan', [KerusakanController::class, 'index'])->name('kerusakan');
    // Route::post('/kerusakan/store',  [KerusakanController::class, 'store'])->name('kerusakan.store');
    Route::get('/kerusakan/update',  [KerusakanController::class, 'update'])->name('kerusakan.update');
    Route::post('/kerusakan/perbaikan',  [KerusakanController::class, 'perbaikan'])->name('kerusakan.perbaikan');
    Route::post('/kerusakan/selesai',  [KerusakanController::class, 'selesai'])->name('kerusakan.selesai');
    Route::get('/kerusakan/update-status',  [KerusakanController::class, 'updateStatus'])->name('kerusakan.update-status');
    Route::get('/kerusakan/detail/{id}',  [KerusakanController::class, 'show'])->name('kerusakan.detail');
    Route::get('/kerusakan/terima/{id}',  [KerusakanController::class, 'terima'])->name('kerusakan.terima');
    Route::get('/kerusakan/tolak/{id}',  [KerusakanController::class, 'tolak'])->name('kerusakan.terima');
    Route::get('/kerusakan-datatable', [KerusakanController::class, 'getKerusakanDataTable']);
});
