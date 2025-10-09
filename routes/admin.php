<?php
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\CourseController;

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard',[
        'sidebar'=>'Dashboard'
    ]);
})->name('dashboard');
Route::get('test', function () {
    return "Email not verified";
})->name('verification.notice');
Route::get('/configuration',[ConfigurationController::class, 'configuration'])->name('configuration');
Route::post('/configuration-update',[ConfigurationController::class, 'configurationUpdate'])->name('configuration.update');
Route::get('/sidebar-management', [ConfigurationController::class,'Sidebar'])->name('config.sidebar');
Route::post('/sidebar-management-update', [ConfigurationController::class,'SidebarManagement'])->name('update.sidebar');


Route::prefix('course-management')->group(function () {
    Route::get('/',[CourseController::class,'index'])->name('course.index');
    Route::post('/store', [CourseController::class,'store'])->name('course.store');
    Route::put('/status/{course}', [CourseController::class,'updateStatus'])->name('course.update.status');
    Route::get('/edit/{course}', [CourseController::class,'edit'])->name('course.edit');
    Route::put('/update/{course}', [CourseController::class,'update'])->name('course.update');
    Route::delete('/delete/{id}', [CourseController::class,'destroy'])->name('course.delete');
});