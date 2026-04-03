<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route::middleware('auth')->group(function () {
    //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/edit-profile', 'index')->name('profile_edit');
        Route::post('/profile-update/{id}', 'pro_update')->name('profile_update');
        Route::post('/password-update/{id}', 'password_reset')->name('pass_update');
    });

    // ............................................users module............................................
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('users.create');
    Route::post('user/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/user/show/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('user/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::delete('/user/restore/{id}', [UserController::class, 'restore'])->name('users.restore');

    // ............................................role module............................................
    Route::resource('roles', RoleController::class);

    Route::resource('transactions', TransactionController::class);
});

require __DIR__ . '/auth.php';
