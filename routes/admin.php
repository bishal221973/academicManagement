<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AcademySetupController;
use App\Http\Controllers\AdmissionformController;
use App\Http\Controllers\AdmissionSectionController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\IcardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TransferController;
use Database\Seeders\IcardSeeder;

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'sidebar' => 'Dashboard'
    ]);
})->name('dashboard');
Route::get('test', function () {
    return "Email not verified";
})->name('verification.notice');












Route::prefix('configuration')->group(function () {

    Route::prefix('system-setup')->group(function () {
        Route::get('/', [ConfigurationController::class, 'configuration'])->name('configuration');
        Route::get('/configuration-api', [ConfigurationController::class, 'configurationApi'])->name('configuration.api');
        Route::post('/configuration-update', [ConfigurationController::class, 'configurationUpdate'])->name('configuration.update');
        Route::get('/sidebar-management', [ConfigurationController::class, 'Sidebar'])->name('config.sidebar');
        Route::post('/sidebar-management-update', [ConfigurationController::class, 'SidebarManagement'])->name('update.sidebar');
    });

    Route::get('id-card', [IcardController::class, 'index'])->name('icard.index');
    Route::get('id-card-default', [IcardController::class, 'default'])->name('icard.default');
    Route::put('id-card-update/{id}', [IcardController::class, 'update'])->name('icard.update');

    Route::prefix('academic-year')->group(function () {
        Route::get('/', [AcademicYearController::class, 'index'])->name('academic.year');
        Route::post('/store', [AcademicYearController::class, 'store'])->name('academic.store');
        Route::get('/edit/{academicYear}', [AcademicYearController::class, 'edit'])->name('academic.edit');
        Route::put('/update/{academicYear}', [AcademicYearController::class, 'update'])->name('academic.update');
        Route::delete('/delete/{academicYear}', [AcademicYearController::class, 'delete'])->name('academic.delete');
    });

    Route::prefix('academic-setup')->group(function () {
        Route::get('/', [AcademySetupController::class, 'index'])->name('academy-setup');
        Route::post('/store', [AcademySetupController::class, 'store'])->name('academy-setup.store');
        Route::get('/get-logo', [AcademySetupController::class, 'getLogo'])->name('academy-setup.getLogo');
        Route::post('/get-reorder', [AcademySetupController::class, 'reOrder'])->name('admission-form.reorder');

        Route::prefix('manage-section')->group(function () {
            Route::post('/', [AdmissionSectionController::class, 'save'])->name('admission-section.save');
            Route::put('/update/{id}', [AdmissionSectionController::class, 'update'])->name('admission-section.update');
            Route::delete('delete/{id}', [AdmissionSectionController::class, 'destroy'])->name('admission-section.destroy');
            Route::put('status/{id}', [AdmissionSectionController::class, 'status'])->name('admission-section.status');
        });
    });
});


Route::prefix('student-management')->group(function () {
    Route::prefix('student')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('student.index');
        Route::get('/all', [StudentController::class, 'all'])->name('student.all');
        Route::post('/store', [StudentController::class, 'store'])->name('student.store');
        Route::put('/status/{student}', [StudentController::class, 'updateStatus'])->name('student.update.status');
        Route::get('/edit/{student}', [StudentController::class, 'edit'])->name('student.edit');
        Route::put('/update/{student}', [StudentController::class, 'update'])->name('student.update');
        Route::delete('/delete/{id}', [StudentController::class, 'destroy'])->name('student.delete');

        Route::prefix('promotion')->group(function () {
            Route::get('/', [StudentController::class, 'promotion'])->name('student.promotion.index');
        });
        Route::prefix('id-card')->group(function () {
            Route::get('/', [StudentController::class, 'icard'])->name('student.icard.index');
        });
        Route::prefix('import-students')->group(function () {
            Route::get('/', [StudentController::class, 'import'])->name('student.import.index');
            Route::get('/format', [StudentController::class, 'importFormat'])->name('student.import.format');
            Route::post('/import', [StudentController::class, 'importStudent'])->name('student.import.student');
        });
        Route::prefix('student-transfer')->group(function () {
            Route::get('/', [TransferController::class, 'index'])->name('student.transfer.index');
            Route::post('/transfer', [TransferController::class, 'transfer'])->name('student.transfer.format');
        });

        Route::prefix('admission-form')->group(function () {
            Route::get('/', [AdmissionformController::class, 'index'])->name('admission-form.index');
            Route::get('/resize/{id}', [AdmissionformController::class, 'resize'])->name('admission-form.resize');
        });
    });
});

Route::prefix('academic-management')->group(function () {

    Route::prefix('course-management')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('course.index');
        Route::get('/api/get-course', [CourseController::class, 'getCourse'])->name('course.getCourse');
        Route::post('/store', [CourseController::class, 'store'])->name('course.store');
        Route::put('/status/{course}', [CourseController::class, 'updateStatus'])->name('course.update.status');
        Route::get('/edit/{course}', [CourseController::class, 'edit'])->name('course.edit');
        Route::put('/update/{course}', [CourseController::class, 'update'])->name('course.update');
        Route::delete('/delete/{id}', [CourseController::class, 'destroy'])->name('course.delete');
    });
    Route::prefix('section-management')->group(function () {
        Route::get('/', [SectionController::class, 'index'])->name('section.index');
        Route::get('all', [SectionController::class, 'all'])->name('section.all');
        Route::post('/store', [SectionController::class, 'store'])->name('section.store');
        Route::put('/status/{section}', [SectionController::class, 'updateStatus'])->name('section.update.status');
        Route::get('/edit/{section}', [SectionController::class, 'edit'])->name('section.edit');
        Route::put('/update/{section}', [SectionController::class, 'update'])->name('section.update');
        Route::delete('/delete/{id}', [SectionController::class, 'destroy'])->name('section.delete');
        Route::get('all', [SectionController::class, 'all'])->name('section.all');
    });
    Route::prefix('group-management')->group(function () {
        Route::get('/', [GroupController::class, 'index'])->name('group.index');
        Route::get('all', [GroupController::class, 'all'])->name('group.all');
        Route::post('/store', [GroupController::class, 'store'])->name('group.store');
        Route::put('/status/{group}', [GroupController::class, 'updateStatus'])->name('group.update.status');
        Route::get('/edit/{group}', [GroupController::class, 'edit'])->name('group.edit');
        Route::put('/update/{group}', [GroupController::class, 'update'])->name('group.update');
        Route::delete('/delete/{id}', [GroupController::class, 'destroy'])->name('group.delete');
    });

    Route::prefix('subject-management')->group(function () {
        Route::get('/', [SubjectController::class, 'index'])->name('subject.index');
        Route::post('/store', [SubjectController::class, 'store'])->name('subject.store');
        Route::put('/status/{subject}', [SubjectController::class, 'updateStatus'])->name('subject.update.status');
        Route::get('/edit/{subject}', [SubjectController::class, 'edit'])->name('subject.edit');
        Route::put('/update/{subject}', [SubjectController::class, 'update'])->name('subject.update');
        Route::delete('/delete/{id}', [SubjectController::class, 'destroy'])->name('subject.delete');
    });
});
Route::prefix('hostel-management')->group(function () {
    Route::prefix('hostel')->group(function () {
        Route::get('/', [HostelController::class, 'index'])->name('hostel.index');
        Route::get('/all', [HostelController::class, 'all'])->name('hostel.all');
        Route::post('/store', [HostelController::class, 'store'])->name('hostel.store');
        Route::put('/status/{hostel}', [HostelController::class, 'updateStatus'])->name('hostel.update.status');
        Route::get('/edit/{hostel}', [HostelController::class, 'edit'])->name('hostel.edit');
        Route::put('/update/{hostel}', [HostelController::class, 'update'])->name('hostel.update');
        Route::delete('/delete/{id}', [HostelController::class, 'destroy'])->name('hostel.delete');
    });

    Route::prefix('room-management')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('room.index');
        Route::post('/store', [RoomController::class, 'store'])->name('room.store');
        Route::put('/status/{room}', [RoomController::class, 'updateStatus'])->name('room.update.status');
        Route::get('/edit/{room}', [RoomController::class, 'edit'])->name('room.edit');
        Route::put('/update/{room}', [RoomController::class, 'update'])->name('room.update');
        Route::delete('/delete/{id}', [RoomController::class, 'destroy'])->name('room.delete');
    });
});
