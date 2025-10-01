<?php
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigurationController;

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard',[
        'sidebar'=>'Dashboard'
    ]);
})->name('dashboard');
Route::get('test', function () {
    return "Email not verified";
})->name('verification.notice');
Route::get('/configuration',[ConfigurationController::class, 'configuration'])->name('configuration');
Route::get('/sidebar-management', [ConfigurationController::class,'Sidebar'])->name('config.sidebar');
