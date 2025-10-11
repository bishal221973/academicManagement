<?php
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard',[
        'sidebar'=>'Dashboard'
    ]);
})->name('dashboard');
Route::get('test', function () {
    return "Email not verified";
})->name('verification.notice');
Route::get('/configuration',[ConfigurationController::class, 'configuration'])->name('configuration');
Route::get('/configuration-api',[ConfigurationController::class, 'configurationApi'])->name('configuration.api');
Route::post('/configuration-update',[ConfigurationController::class, 'configurationUpdate'])->name('configuration.update');
Route::get('/sidebar-management', [ConfigurationController::class,'Sidebar'])->name('config.sidebar');
Route::post('/sidebar-management-update', [ConfigurationController::class,'SidebarManagement'])->name('update.sidebar');


Route::prefix('course-management')->group(function () {
    Route::get('/',[CourseController::class,'index'])->name('course.index');
    Route::get('/api/get-course',[CourseController::class,'getCourse'])->name('course.getCourse');
    Route::post('/store', [CourseController::class,'store'])->name('course.store');
    Route::put('/status/{course}', [CourseController::class,'updateStatus'])->name('course.update.status');
    Route::get('/edit/{course}', [CourseController::class,'edit'])->name('course.edit');
    Route::put('/update/{course}', [CourseController::class,'update'])->name('course.update');
    Route::delete('/delete/{id}', [CourseController::class,'destroy'])->name('course.delete');
});


Route::prefix('section-management')->group(function () {
    Route::get('/',[SectionController::class,'index'])->name('section.index');
    Route::post('/store', [SectionController::class,'store'])->name('section.store');
    Route::put('/status/{section}', [SectionController::class,'updateStatus'])->name('section.update.status');
    Route::get('/edit/{section}', [SectionController::class,'edit'])->name('section.edit');
    Route::put('/update/{section}', [SectionController::class,'update'])->name('section.update');
    Route::delete('/delete/{id}', [SectionController::class,'destroy'])->name('section.delete');
});

Route::prefix('group-management')->group(function () {
    Route::get('/',[GroupController::class,'index'])->name('group.index');
    Route::post('/store', [GroupController::class,'store'])->name('group.store');
    Route::put('/status/{group}', [GroupController::class,'updateStatus'])->name('group.update.status');
    Route::get('/edit/{group}', [GroupController::class,'edit'])->name('group.edit');
    Route::put('/update/{group}', [GroupController::class,'update'])->name('group.update');
    Route::delete('/delete/{id}', [GroupController::class,'destroy'])->name('group.delete');
});

Route::prefix('subject-management')->group(function () {
    Route::get('/',[SubjectController::class,'index'])->name('subject.index');
    Route::post('/store', [SubjectController::class,'store'])->name('subject.store');
    Route::put('/status/{subject}', [SubjectController::class,'updateStatus'])->name('subject.update.status');
    Route::get('/edit/{subject}', [SubjectController::class,'edit'])->name('subject.edit');
    Route::put('/update/{subject}', [SubjectController::class,'update'])->name('subject.update');
    Route::delete('/delete/{id}', [SubjectController::class,'destroy'])->name('subject.delete');
});

Route::prefix('student-management')->group(function () {
    Route::get('/',[StudentController::class,'index'])->name('student.index');
    Route::post('/store', [StudentController::class,'store'])->name('student.store');
    Route::put('/status/{student}', [StudentController::class,'updateStatus'])->name('student.update.status');
    Route::get('/edit/{student}', [StudentController::class,'edit'])->name('student.edit');
    Route::put('/update/{student}', [StudentController::class,'update'])->name('student.update');
    Route::delete('/delete/{id}', [StudentController::class,'destroy'])->name('student.delete');
});