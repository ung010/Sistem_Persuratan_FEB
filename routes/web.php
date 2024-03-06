<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegistrasiController;
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
    return redirect('/users');
});

Route::middleware('auth')->group(function () {
    route::get('/users', [UsersController::class, 'users']);
    Route::get('/logout', [LoginController::class, 'logout']);
    route::get('/mahasiswa', [UsersController::class, 'mahasiswa'])->name('mahasiswa.index')->
    middleware('UserAkses:mahasiswa');
    route::get('/mahasiswa/my_account', [MahasiswaController::class, 'account'])->name('mahasiswa.account')->
    middleware('UserAkses:mahasiswa');
    

    route::get('/admin', [UsersController::class, 'admin'])->name('admin.index')->middleware('UserAkses:admin');
    route::get('/admin/akun_user', [AdminController::class, 'user'])->name('admin.mahasiswa')->middleware('UserAkses:admin');
    route::post('/admin/akun_user/delete/{id}', [RegisterController::class, 'delete'])->name('mahasiswa.delete')->middleware('UserAkses:admin');


    route::get('/supervisor', [UsersController::class, 'supervisor'])->name('supervisor.index')->
    middleware('UserAkses:supervisor');
    
    
    route::get('/wakildekan', [UsersController::class, 'wadek'])->name('wadek.index')->
    middleware('UserAkses:wakildekan');


});



// route::get('/', [LoginController::class, 'index'])->name('auth.index');
// route::post('/', [LoginController::class, 'login'])->name('auth.login');
// route::get('/register', [RegisterController::class, 'register'])->name('auth.register');
// Route::post('/register/create', [RegisterController::class, 'create'])->name('register.create');
