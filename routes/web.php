<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth', 'check.approved'])->group(function () {
    
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware(['check.role:user'])->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/pengajuan/create', [UserController::class, 'createPengajuan'])->name('pengajuan.create');
        Route::post('/pengajuan/store', [UserController::class, 'storePengajuan'])->name('pengajuan.store');
        Route::get('/pengajuan/{id}', [UserController::class, 'showPengajuan'])->name('pengajuan.show');
    });

  
Route::middleware(['check.role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/pending-users', [AdminController::class, 'pendingUsers'])->name('pending-users');
        Route::post('/approve-user/{id}', [AdminController::class, 'approveUser'])->name('approve-user');
        Route::post('/reject-user/{id}', [AdminController::class, 'rejectUser'])->name('reject-user');
        Route::get('/user/{id}', [AdminController::class, 'showUserDetail'])->name('user.detail');
        
        Route::get('/pengajuan-surat', [AdminController::class, 'pengajuanSurat'])->name('pengajuan-surat');
        Route::post('/pengajuan/{id}/process', [AdminController::class, 'processPengajuan'])->name('pengajuan.process');
        Route::post('/pengajuan/{id}/complete', [AdminController::class, 'completePengajuan'])->name('pengajuan.complete');
        Route::post('/pengajuan/{id}/reject', [AdminController::class, 'rejectPengajuan'])->name('pengajuan.reject');
        Route::get('/pengajuan/{id}', [AdminController::class, 'showPengajuanDetail'])->name('pengajuan.detail');
    });


});