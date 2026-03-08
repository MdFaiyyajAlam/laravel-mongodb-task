<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\AdminPanelController;
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

Route::prefix('admin/panel')->middleware('auth:admin')->group(function () {
    Route::get('/', [AdminPanelController::class, 'dashboard'])->name('admin.panel.dashboard');
    Route::get('/tasks', [AdminPanelController::class, 'tasks'])->name('admin.panel.tasks');
    Route::patch('/tasks/{id}/status', [AdminPanelController::class, 'updateTaskStatus'])->name('admin.panel.tasks.status');
    Route::delete('/tasks/{id}', [AdminPanelController::class, 'destroyTask'])->name('admin.panel.tasks.destroy');

    Route::get('/users', [AdminPanelController::class, 'users'])->name('admin.panel.users');
    Route::delete('/users/{id}', [AdminPanelController::class, 'destroyUser'])->name('admin.panel.users.destroy');

    Route::get('/admins', [AdminPanelController::class, 'admins'])->name('admin.panel.admins');
    Route::delete('/admins/{id}', [AdminPanelController::class, 'destroyAdmin'])->name('admin.panel.admins.destroy');
});
