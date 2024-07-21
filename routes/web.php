<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AksesController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ManajerController;
use App\Http\Controllers\NonController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\SupervisorController;
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
    return redirect('/error_register');
});

Route::middleware('auth')->group(function () {
    route::get('/users', [UsersController::class, 'users']);
    Route::get('/logout', [LoginController::class, 'logout']);
    
    
    // Route Non Mahasiswa & Non Alumni
    route::get('/error_register', [UsersController::class, 'home']);

    route::get('/non_mhw', [NonController::class, 'home_non_mhw'])->name('non_mhw.home')->
    middleware('UserAkses:non_mahasiswa');
    Route::get('/non_mhw/my_account/{id}', [NonController::class, 'edit_non_mhw'])->name('non_mhw.edit')->
    middleware('UserAkses:non_mahasiswa');
    Route::post('/non_mhw/my_account/update/{id}', [NonController::class, 'account_non_mhw'])->name('non_mhw.account_non_mhw')->
    middleware('UserAkses:non_mahasiswa');

    route::get('/non_alum', [NonController::class, 'home_non_alum'])->name('non_alum.home')->
    middleware('UserAkses:non_alumni');
    Route::get('/non_alum/my_account/{id}', [NonController::class, 'edit_non_alum'])->name('non_alum.edit')->
    middleware('UserAkses:non_alumni');
    Route::post('/non_alum/my_account/update/{id}', [NonController::class, 'account_non_alum'])->name('non_alum.account_non_alum')->
    middleware('UserAkses:non_alumni');

    // Route Mahasiswa
    route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index')->
    middleware('UserAkses:mahasiswa');
    Route::get('/mahasiswa/my_account/{id}', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit')->
    middleware('UserAkses:mahasiswa');
    Route::post('/mahasiswa/my_account/update/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update')->
    middleware('UserAkses:mahasiswa');

    // Route ALumni
    route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index')->
    middleware('UserAkses:alumni');
    Route::get('/alumni/my_account/{id}', [AlumniController::class, 'edit'])->name('alumni.edit')->
    middleware('UserAkses:alumni');
    Route::post('/alumni/my_account/update/{id}', [AlumniController::class, 'update'])->name('alumni.update')->
    middleware('UserAkses:alumni');
    

    // Route Admin
    route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware('UserAkses:admin');
    
    route::get('/admin/user', [AdminController::class, 'user'])->name('admin.user')->middleware('UserAkses:admin');
    route::post('/admin/user/delete/{id}', [AdminController::class, 'delete_user'])->name('admin.delete')->middleware('UserAkses:admin');
    Route::get('/admin/user/search', [AdminController::class, 'search_user'])->name('admin.user.search')->middleware('UserAkses:admin');
    Route::get('/admin/user/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit')->
    middleware('UserAkses:admin');
    Route::post('/admin/user/update/{id}', [AdminController::class, 'update'])->name('admin.update')->
    middleware('UserAkses:admin');

    route::get('/admin/verif_user', [AdminController::class, 'verif_user'])->name('admin.verifikasi')->middleware('UserAkses:admin');
    Route::get('/admin/verif_user/search', [AdminController::class, 'search_verif'])->name('admin.verif.search')->middleware('UserAkses:admin');
    Route::get('/admin/verif_user/cekdata/{id}', [AdminController::class, 'cekdata_mhw'])->name('admin.cekdata')->middleware('UserAkses:admin');
    Route::post('/admin/verif_user/cekdata/catatan/{id}',  [AdminController::class, 'catatan'])->name('admin.catatan')->middleware('UserAkses:admin');
    Route::post('/admin/verif_user/cekdata/verifikasi/{id}', [AdminController::class, 'verifikasi'])->name('admin.verifikasi.user')->middleware('UserAkses:admin');


    // Route::post('/admin/mahasiswa/Approve/{id}', [AdminController::class, 'aksesApprove'])->name('admin.aksesApprove')->middleware('UserAkses:admin');
    // Route::post('/admin/mahasiswa/nonApprove/{id}', [AdminController::class, 'nonApprove'])->name('admin.nonApprove')->middleware('UserAkses:admin');
    // Route::post('/admin/mahasiswa/bulkNonApprove', [AdminController::class, 'bulkNonApprove'])->name('admin.bulkNonApprove')->middleware('UserAkses:admin');
    // Route::post('/admin/mahasiswa/bulkApprove', [AdminController::class, 'bulkApprove'])->name('admin.bulkApprove')->middleware('UserAkses:admin');
    // Route::post('/admin/mahasiswa/nonApproveAll', [AdminController::class, 'nonApproveAll'])->name('admin.nonApproveAll')->middleware('UserAkses:admin');
    // Route::post('/admin/mahasiswa/ApproveAll', [AdminController::class, 'ApproveAll'])->name('admin.ApproveAll')->middleware('UserAkses:admin');



    route::get('/supervisor_akd', [SupervisorController::class, 'index_akd'])->name('supervisor_akd.index')->
    middleware('UserAkses:supervisor_akd');
    route::get('/supervisor_akd/manage_admin', [SupervisorController::class, 'manage_admin_akd'])->name('supervisor_akd.manage_admin')->
    middleware('UserAkses:supervisor_akd');
    route::post('/supervisor_akd/manage_admin/delete/{id}', [SupervisorController::class, 'delete_admin_akd'])->name('supervisor_akd.delete')
    ->middleware('UserAkses:supervisor_akd');
    Route::post('/supervisor_akd/manage_admin/create', [SupervisorController::class, 'create_akd'])->name('supervisor_akd.create_akd')
    ->middleware('UserAkses:supervisor_akd');
    Route::post('/supervisor_akd/manage_admin/edit/{id}',  [SupervisorController::class, 'edit_akd'])->name('supervisor_akd.edit_akd')
    ->middleware('UserAkses:supervisor_akd');


    route::get('/supervisor_sd', [SupervisorController::class, 'index_sd'])->name('supervisor_sd.index')->
    middleware('UserAkses:supervisor_sd');
    route::get('/supervisor_sd/manage_admin', [SupervisorController::class, 'manage_admin_sd'])->name('supervisor_sd.manage_admin')->
    middleware('UserAkses:supervisor_sd');
    route::post('/supervisor_sd/manage_admin/delete/{id}', [SupervisorController::class, 'delete_admin_sd'])->name('supervisor_sd.delete')
    ->middleware('UserAkses:supervisor_sd');
    Route::post('/supervisor_sd/manage_admin/create', [SupervisorController::class, 'create_sd'])->name('supervisor_sd.create_sd')
    ->middleware('UserAkses:supervisor_sd');
    Route::post('/supervisor_sd/manage_admin/edit/{id}',  [SupervisorController::class, 'edit_sd'])->name('supervisor_sd.edit_sd')
    ->middleware('UserAkses:supervisor_sd');
    
    route::get('/manajer', [ManajerController::class, 'index'])->name('manajer.index')->
    middleware('UserAkses:manajer');
    route::get('/manajer/manage_spv', [ManajerController::class, 'manage_spv'])->name('manajer.manage_spv')->
    middleware('UserAkses:manajer');
    Route::post('/manajer/manage_spv/edit/{id}',  [ManajerController::class, 'edit_spv'])->name('manajer.edit_spv')
    ->middleware('UserAkses:manajer');
    Route::get('/manajer/account/{id}', [ManajerController::class, 'edit_account'])->name('manajer.edit_account')->
    middleware('UserAkses:manajer');
    Route::post('/manajer/account/update/{id}', [ManajerController::class, 'update_account'])->name('manajer.update_account')->
    middleware('UserAkses:manajer');

    route::get('/SuratKetMahasiswa', [SuratKetMhw::class, 'index'])->name('SKM.index')->middleware('UserAkses:admin');
    Route::get('/SuratKetMahasiswa/Create', [SuratKetMhw::class, 'create'])->name('SKM.create')->middleware('UserAkses:admin');
    Route::post('/SuratKetMahasiswa/Store', [SuratKetMhw::class,'store'])->name('SKM.store')->middleware('UserAkses:admin');
});



// route::get('/', [LoginController::class, 'index'])->name('auth.index');
// route::post('/', [LoginController::class, 'login'])->name('auth.login');
// route::get('/register', [RegisterController::class, 'register'])->name('auth.register');
// Route::post('/register/create', [RegisterController::class, 'create'])->name('register.create');
