<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AksesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\SuratKetMhw;
use App\Http\Controllers\SvisorController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WadekController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::get('/login', [LoginController::class, 'index'])->name('auth.login');
    Route::post('/', [LoginController::class, 'login'])->name('auth.login');
    // Route::get('/login_admin', [LoginController::class, 'index2'])->name('login');
    // Route::post('/login_admin', [LoginController::class, 'login2'])->name('auth.login');
    Route::get('/register', [RegisterController::class, 'register']);
    Route::post('/register/create', [RegisterController::class, 'create'])->name('register.create');
});

route::get('/home', function () {
    return redirect('/akses_ditolak');
});

Route::middleware('auth')->group(function () {
    route::get('/users', [UsersController::class, 'users']);
    Route::get('/logout', [LoginController::class, 'logout']);
    route::get('/akses_ditolak', [UsersController::class, 'home'])->
    middleware('UserAkses:-');

    
    route::get('/mahasiswa', [UsersController::class, 'mahasiswa'])->name('mahasiswa.index')->
    middleware('UserAkses:mahasiswa');
    route::get('/mahasiswa/my_account', [MahasiswaController::class, 'account'])->name('mahasiswa.account')->
    middleware('UserAkses:mahasiswa');
    

    // Admin interface
    route::get('/admin', [UsersController::class, 'admin'])->name('admin.index')->middleware('UserAkses:admin');
    route::get('/admin/mahasiswa', [AdminController::class, 'user'])->name('admin.mahasiswa')->middleware('UserAkses:admin');
    route::post('/admin/mahasiswa/delete/{id}', [RegisterController::class, 'delete'])->name('admin.delete')->middleware('UserAkses:admin');
    
    route::get('/admin/mahasiswa/akses', [AdminController::class, 'UsersAkses'])->name('admin.akses')->middleware('UserAkses:admin');
    Route::post('/admin/mahasiswa/Approve/{id}', [AdminController::class, 'aksesApprove'])->name('admin.aksesApprove')->middleware('UserAkses:admin');
    Route::post('/admin/mahasiswa/nonApprove/{id}', [AdminController::class, 'nonApprove'])->name('admin.nonApprove')->middleware('UserAkses:admin');
    Route::post('/admin/mahasiswa/bulkNonApprove', [AdminController::class, 'bulkNonApprove'])->name('admin.bulkNonApprove')->middleware('UserAkses:admin');
    Route::post('/admin/mahasiswa/bulkApprove', [AdminController::class, 'bulkApprove'])->name('admin.bulkApprove')->middleware('UserAkses:admin');
    Route::post('/admin/mahasiswa/nonApproveAll', [AdminController::class, 'nonApproveAll'])->name('admin.nonApproveAll')->middleware('UserAkses:admin');
    Route::post('/admin/mahasiswa/ApproveAll', [AdminController::class, 'ApproveAll'])->name('admin.ApproveAll')->middleware('UserAkses:admin');

    Route::get('/admin/mahasiswa/search', [AdminController::class, 'search'])->name('admin.mahasiswa.search');
    Route::get('/admin/mahasiswa/akses/search', [AdminController::class, 'search1'])->name('admin.akses.search');


    route::get('/supervisor', [UsersController::class, 'supervisor'])->name('supervisor.index')->
    middleware('UserAkses:supervisor');
    
    
    route::get('/wakildekan', [UsersController::class, 'wadek'])->name('wadek.index')->
    middleware('UserAkses:wakildekan');

    route::get('/SuratKetMahasiswa', [SuratKetMhw::class, 'index'])->name('SKM.index')->middleware('UserAkses:admin');
    Route::get('/SuratKetMahasiswa/Create', [SuratKetMhw::class, 'create'])->name('SKM.create')->middleware('UserAkses:admin');
    Route::post('/SuratKetMahasiswa/Store', [SuratKetMhw::class,'store'])->name('SKM.store')->middleware('UserAkses:admin');
});



// route::get('/', [LoginController::class, 'index'])->name('auth.index');
// route::post('/', [LoginController::class, 'login'])->name('auth.login');
// route::get('/register', [RegisterController::class, 'register'])->name('auth.register');
// Route::post('/register/create', [RegisterController::class, 'create'])->name('register.create');
