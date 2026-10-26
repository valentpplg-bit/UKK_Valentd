<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::middleware('guest')->group(function () {
	Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
	Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
	Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
	Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
	->middleware('auth')->name('logout');

Route::middleware(['auth', 'user'])->group(function () {
	Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
	Route::get('/user/catalog', [UserController::class, 'catalog'])->name('user.catalog');
	Route::get('/user/book/{buku}', [UserController::class, 'showBook'])->name('user.book.show');
	Route::post('/user/book/{buku}/borrow', [UserController::class, 'borrow'])->name('user.book.borrow');
	Route::get('/user/loans', [UserController::class, 'loans'])->name('user.loans');
	Route::get('/user/returns', [UserController::class, 'returns'])->name('user.returns');
	Route::get('/user/history', [UserController::class, 'history'])->name('user.history');
	Route::post('/user/loan/{transaksi}/return', [UserController::class, 'returnBook'])->name('user.loan.return');
	Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
	Route::get('/user/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
	Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
});

Route::middleware(['auth', 'admin'])->group(function () {
	Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

	Route::resource('buku', BukuController::class);

	Route::resource('anggota', AnggotaController::class);

	Route::resource('transaksi', TransaksiController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
	Route::post('transaksi/{transaksi}/kembalikan', [TransaksiController::class, 'returnBook'])
		->name('transaksi.return');

	Route::get('report', [ReportController::class, 'index'])->name('report.index');
});