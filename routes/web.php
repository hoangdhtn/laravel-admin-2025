<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('/users/destroy-multiple', [\App\Http\Controllers\Admin\UserController::class, 'destroyMultiple'])->name('users.destroy-multiple');
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::post('/settings/two-factor', [SettingsController::class, 'toggleTwoFactor'])->name('settings.two-factor');
    Route::post('/settings/logout-others', [SettingsController::class, 'logoutOtherDevices'])->name('settings.logout-others');
    Route::post('/settings/account-status', [SettingsController::class, 'updateAccountStatus'])->name('settings.account-status');
    Route::post('/settings/password-policy', [SettingsController::class, 'updatePasswordPolicy'])->name('settings.password-policy');
    Route::post('/settings/branding', [SettingsController::class, 'updateBranding'])->name('settings.branding');

    // Profile
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [\App\Http\Controllers\Admin\ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile/avatar', [\App\Http\Controllers\Admin\ProfileController::class, 'removeAvatar'])->name('profile.avatar.remove');
});
