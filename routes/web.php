<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth('web')->check() || auth('admin')->check()) {
        return redirect()->route('tasks.index');
    }

    return view('welcome');
})->name('home');

Route::middleware('guest:web,admin')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
    Route::get('/user/login', [UserAuthController::class, 'showLogin'])->name('user.login');
    Route::post('/login', [UserAuthController::class, 'login'])->name('user.login.submit');
    Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
    Route::get('/user/register', [UserAuthController::class, 'showRegister'])->name('user.register');
    Route::post('/register', [UserAuthController::class, 'register'])->name('user.register.submit');

    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::get('/admin/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
    Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');
});

Route::middleware('auth:web,admin')->group(function () {
    Route::resource('tasks', TaskController::class)->except(['show']);

    Route::post('/logout', [UserAuthController::class, 'logout'])
        ->middleware('auth:web')
        ->name('user.logout');

    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
        ->middleware('auth:admin')
        ->name('admin.logout');
});
