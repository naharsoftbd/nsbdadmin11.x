<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\RoleController;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\ProfileController;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users',[UserController::class,'index'])->name('users');
    Route::get('/users/create',[UserController::class,'create'])->name('users.create');
    Route::post('/users/create',[UserController::class,'store']);
    Route::get('/users/{id}/edit',[UserController::class,'edit'])->name('users.edit');
    Route::post('/users/{id}',[UserController::class,'update'])->name('users.update');
    Route::delete('/users/{id}/delete',[UserController::class,'destroy'])->name('users.delete');

    Route::get('/roles',[RoleController::class,'index'])->name('roles.index');
    Route::get('/roles/create',[RoleController::class,'create'])->name('roles.create');
    Route::post('/roles/create',[RoleController::class,'store']);
    Route::get('/roles/{id}/edit',[RoleController::class,'edit'])->name('roles.edit');
    Route::post('/roles/{id}',[RoleController::class,'update'])->name('roles.update');
    Route::delete('/roles/{id}/delete',[RoleController::class,'destroy'])->name('roles.delete');

    Route::get('/menus',[MenuController::class,'index'])->name('menus.index');
    Route::get('/menus/create',[MenuController::class,'create'])->name('menus.create');
    Route::post('/menus/create',[MenuController::class,'store']);
    Route::get('/menus/{id}/edit',[MenuController::class,'edit'])->name('menus.edit');
    Route::post('/menus/{id}',[MenuController::class,'update'])->name('menus.update');
    Route::delete('/menus/{id}/delete',[MenuController::class,'destroy'])->name('menus.delete');
    Route::get('/childmenus/{id}/edit',[MenuController::class,'childMenuEdit'])->name('childmenus.edit');
    Route::post('/childmenus/{id}',[MenuController::class,'updateChildMenu'])->name('childmenus.update');
});
