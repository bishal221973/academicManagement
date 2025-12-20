<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AcademySetupController;
use App\Http\Controllers\AdmissionformController;
use App\Http\Controllers\AdmissionSectionController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CallLogController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\HostelFeatureController;
use App\Http\Controllers\HostelStudentController;
use App\Http\Controllers\IcardController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\MailFormatController;
use App\Http\Controllers\MailSettingController;
use App\Http\Controllers\PaymentModeController;
use App\Http\Controllers\PostalDispatchController;
use App\Http\Controllers\PostalReceiveController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPurchaseController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\VisitorController;
use Database\Seeders\IcardSeeder;

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'sidebar' => 'Dashboard',
        'menu' => 'Dashboard'
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
        Route::put('/change-status/{academicYear}', [AcademicYearController::class, 'status'])->name('academic.status');
    });

    Route::prefix('taxes')->group(function () {
        Route::get('/', [TaxController::class, 'index'])->name('tax.index');
        Route::get('/all', [TaxController::class, 'all'])->name('tax.all');
        Route::post('/store', [TaxController::class, 'store'])->name('tax.store');
        Route::get('/edit/{tax}', [TaxController::class, 'edit'])->name('tax.edit');
        Route::put('/update/{tax}', [TaxController::class, 'update'])->name('tax.update');
        Route::put('/status/{tax}', [TaxController::class, 'status'])->name('tax.status');
        Route::delete('/delete/{tax}', [TaxController::class, 'delete'])->name('tax.delete');
        Route::put('/change-status/{tax}', [TaxController::class, 'status'])->name('tax.status');
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
    Route::prefix('mail-setup')->group(function () {
        Route::get('/', [MailSettingController::class, 'index'])->name('mail.setup.index');
        Route::post('/store', [MailSettingController::class, 'store'])->name('mail.setup.store');
        Route::post('/send-test-mail', [MailSettingController::class, 'sendTestMail'])->name('mail.setup.sendTestMail');
    });

    Route::prefix('mail-format')->group(function () {
        Route::get('/', [MailFormatController::class, 'index'])->name('mail.format.index');
        Route::post('/store', [MailFormatController::class, 'store'])->name('mail.format.store');
        Route::post('/send-test-mail', [MailFormatController::class, 'sendTestMail'])->name('mail.format.sendTestMail');
    });

    Route::prefix('payment-mode')->group(function () {
        Route::get('/', [PaymentModeController::class, 'index'])->name('paymentMode.index');
        Route::get('/all', [PaymentModeController::class, 'all'])->name('paymentMode.all');
        Route::post('/store', [PaymentModeController::class, 'store'])->name('paymentMode.store');
        Route::get('/edit/{paymentMode}', [PaymentModeController::class, 'edit'])->name('paymentMode.edit');
        Route::put('/update/{paymentMode}', [PaymentModeController::class, 'update'])->name('paymentMode.update');
        Route::put('/status/{paymentMode}', [PaymentModeController::class, 'status'])->name('paymentMode.status');
        Route::delete('/delete/{paymentMode}', [PaymentModeController::class, 'delete'])->name('paymentMode.delete');
    });
});


Route::prefix('student-management')->group(function () {
    Route::prefix('student')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('student.index');
        Route::get('/all', [StudentController::class, 'all'])->name('student.all');
        Route::get('/roll-number/{courseId}', [StudentController::class, 'rollReg'])->name('student.rollNum');
        Route::get('/find', [StudentController::class, 'find'])->name('student.find');
        Route::get('/hostel/all', [StudentController::class, 'hostelAll'])->name('student.all.hostel');
        Route::post('/store', [StudentController::class, 'store'])->name('student.store');
        Route::put('/status/{student}', [StudentController::class, 'updateStatus'])->name('student.update.status');
        Route::get('/edit/{student}', [StudentController::class, 'edit'])->name('student.edit');
        Route::get('/show/{studentId}', [StudentController::class, 'show'])->name('student.show');
        Route::put('/update/{student}', [StudentController::class, 'update'])->name('student.update');
        Route::delete('/delete/{id}', [StudentController::class, 'destroy'])->name('student.delete');
        Route::post('/upload-citizenship-card/{id}', [StudentController::class, 'uploadCitizenship'])->name('student.upload.citizenship');

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
        Route::get('/find/{id}', [CourseController::class, 'findCourse'])->name('course.find');
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
        Route::get('/view/{hostel}', [HostelController::class, 'show'])->name('hostel.show');
        Route::post('/store', [HostelController::class, 'store'])->name('hostel.store');
        Route::put('/status/{hostel}', [HostelController::class, 'updateStatus'])->name('hostel.update.status');
        Route::get('/edit/{hostel}', [HostelController::class, 'edit'])->name('hostel.edit');
        Route::put('/update/{hostel}', [HostelController::class, 'update'])->name('hostel.update');
        Route::delete('/delete/{id}', [HostelController::class, 'destroy'])->name('hostel.delete');
    });

    Route::prefix('room-management')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('room.index');
        Route::get('/all', [RoomController::class, 'all'])->name('room.all');
        Route::get('/find', [RoomController::class, 'find'])->name('room.find');
        Route::get('/show/{roomId}', [RoomController::class, 'show'])->name('room.show');
        Route::post('/store', [RoomController::class, 'store'])->name('room.store');
        Route::put('/status/{room}', [RoomController::class, 'updateStatus'])->name('room.update.status');
        Route::get('/edit/{room}', [RoomController::class, 'edit'])->name('room.edit');
        Route::put('/update/{room}', [RoomController::class, 'update'])->name('room.update');
        Route::delete('/delete/{id}', [RoomController::class, 'destroy'])->name('room.delete');
    });

    Route::prefix('booking-management')->group(function () {
        Route::get('/', [HostelStudentController::class, 'index'])->name('hostelStudent.index');
        Route::post('/store', [HostelStudentController::class, 'store'])->name('hostelStudent.store');
        Route::put('/status/{hostelStudent}', [HostelStudentController::class, 'updateStatus'])->name('hostelStudent.update.status');
        Route::get('/edit/{hostelStudent}', [HostelStudentController::class, 'edit'])->name('hostelStudent.edit');
        Route::get('/show/{hostelStudent}', [HostelStudentController::class, 'show'])->name('hostelStudent.show');
        Route::put('/update/{hostelStudent}', [HostelStudentController::class, 'update'])->name('hostelStudent.update');
        Route::delete('/delete/{id}', [HostelStudentController::class, 'destroy'])->name('hostelStudent.delete');
    });
    Route::prefix('hostel-facilities')->group(function () {
        Route::get('/', [HostelFeatureController::class, 'index'])->name('hostelFeature.index');
        Route::post('/store', [HostelFeatureController::class, 'store'])->name('hostelFeature.store');
        Route::put('/status/{hostelFeature}', [HostelFeatureController::class, 'updateStatus'])->name('hostelFeature.update.status');
        Route::get('/edit/{hostelFeature}', [HostelFeatureController::class, 'edit'])->name('hostelFeature.edit');
        Route::get('/show/{hostelFeature}', [HostelFeatureController::class, 'show'])->name('hostelFeature.show');
        Route::put('/update/{hostelFeature}', [HostelFeatureController::class, 'update'])->name('hostelFeature.update');
        Route::delete('/delete/{id}', [HostelFeatureController::class, 'destroy'])->name('hostelFeature.delete');
    });
});

Route::prefix('library-management')->group(function () {
    Route::get('/', [LibraryController::class, 'index'])->name('library.index');
    Route::post('/store', [LibraryController::class, 'store'])->name('library.store');
    Route::put('/status/{library}', [LibraryController::class, 'updateStatus'])->name('library.update.status');
    Route::get('/edit/{library}', [LibraryController::class, 'edit'])->name('library.edit');
    Route::put('/update/{library}', [LibraryController::class, 'update'])->name('library.update');
    Route::delete('/delete/{id}', [LibraryController::class, 'destroy'])->name('library.delete');
});

Route::prefix('inventory-management')->group(function () {
    Route::prefix('store')->group(function () {
        Route::get('/', [StoreController::class, 'index'])->name('store.index');
        Route::post('/store', [StoreController::class, 'store'])->name('store.store');
        Route::put('/status/{store}', [StoreController::class, 'updateStatus'])->name('store.update.status');
        Route::get('/edit/{store}', [StoreController::class, 'edit'])->name('store.edit');
        Route::put('/update/{store}', [StoreController::class, 'update'])->name('store.update');
        Route::delete('/delete/{id}', [StoreController::class, 'destroy'])->name('store.delete');
    });

    Route::prefix('product-category')->group(function () {
        Route::get('/', [ProductCategoryController::class, 'index'])->name('productCategory.index');
        Route::post('/productCategory', [ProductCategoryController::class, 'store'])->name('productCategory.store');
        Route::put('/status/{productCategory}', [ProductCategoryController::class, 'updateStatus'])->name('productCategory.update.status');
        Route::get('/edit/{productCategory}', [ProductCategoryController::class, 'edit'])->name('productCategory.edit');
        Route::put('/update/{productCategory}', [ProductCategoryController::class, 'update'])->name('productCategory.update');
        Route::delete('/delete/{id}', [ProductCategoryController::class, 'destroy'])->name('productCategory.delete');
        Route::get('/api/get-product-category', [ProductCategoryController::class, 'getCategory'])->name('product.category.get.all');
    });

    Route::prefix('unit')->group(function () {
        Route::get('/', [UnitController::class, 'index'])->name('unit.index');
        Route::post('/unit', [UnitController::class, 'store'])->name('unit.store');
        Route::put('/status/{unit}', [UnitController::class, 'updateStatus'])->name('unit.update.status');
        Route::get('/edit/{unit}', [UnitController::class, 'edit'])->name('unit.edit');
        Route::put('/update/{unit}', [UnitController::class, 'update'])->name('unit.update');
        Route::delete('/delete/{id}', [UnitController::class, 'destroy'])->name('unit.delete');
        Route::get('/api/get-product', [UnitController::class, 'getUnit'])->name('unit.get.all');
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');
        Route::put('/status/{product}', [ProductController::class, 'updateStatus'])->name('product.update.status');
        Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/update/{product}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');
        Route::get('/api/get-product', [ProductController::class, 'getProduct'])->name('product.get.all');
    });
    Route::prefix('supplier')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');
        Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
        Route::put('/status/{supplier}', [SupplierController::class, 'updateStatus'])->name('supplier.update.status');
        Route::get('/edit/{supplier}', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::put('/update/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.delete');
        Route::get('/api/get-supplier', [SupplierController::class, 'getSupplier'])->name('supplier.get.all');
    });

    Route::prefix('purchase')->group(function () {
        Route::get('/', [ProductPurchaseController::class, 'index'])->name('productPurchase.index');
        Route::post('/productPurchase', [ProductPurchaseController::class, 'store'])->name('productPurchase.store');
        Route::put('/status/{productPurchase}', [ProductPurchaseController::class, 'updateStatus'])->name('productPurchase.update.status');
        Route::get('/edit/{productPurchase}', [ProductPurchaseController::class, 'edit'])->name('productPurchase.edit');
        Route::put('/update/{productPurchase}', [ProductPurchaseController::class, 'update'])->name('productPurchase.update');
        Route::delete('/delete/{id}', [ProductPurchaseController::class, 'destroy'])->name('productPurchase.delete');
    });
    Route::get('/stock-manager', [ProductController::class, 'stockManager'])->name('stock.manager');

    Route::prefix('sell')->group(function () {
        Route::get('/', [SellController::class, 'index'])->name('sell.index');
        Route::post('/sell', [SellController::class, 'store'])->name('sell.store');
        Route::put('/status/{sell}', [SellController::class, 'updateStatus'])->name('sell.update.status');
        Route::get('/edit/{sell}', [SellController::class, 'edit'])->name('sell.edit');
        Route::put('/update/{sell}', [SellController::class, 'update'])->name('sell.update');
        Route::delete('/delete/{id}', [SellController::class, 'destroy'])->name('sell.delete');
    });
});

Route::prefix('billing')->group(function () {
    Route::get('/', [BillingController::class, 'index'])->name('billing.index');
    Route::get('/all', [BillingController::class, 'all'])->name('billing.all');
    Route::post('/store', [BillingController::class, 'store'])->name('billing.store');
    Route::get('/edit/{billing}', [BillingController::class, 'edit'])->name('billing.edit');
    Route::put('/update/{billing}', [BillingController::class, 'update'])->name('billing.update');
    Route::put('/status/{billing}', [BillingController::class, 'status'])->name('billing.status');
    Route::delete('/delete/{billing}', [BillingController::class, 'delete'])->name('billing.delete');
});


Route::prefix('front-office')->group(function () {
    Route::prefix('visitor')->group(function () {
        Route::get('/', [VisitorController::class, 'index'])->name('visitor.index');
        Route::post('/store', [VisitorController::class, 'store'])->name('visitor.store');
        Route::get('/edit/{visitor}', [VisitorController::class, 'edit'])->name('visitor.edit');
        Route::put('/update/{visitor}', [VisitorController::class, 'update'])->name('visitor.update');
        Route::put('/status/{visitor}', [VisitorController::class, 'status'])->name('visitor.status');
        Route::delete('/delete/{visitor}', [VisitorController::class, 'delete'])->name('visitor.delete');
    });

    Route::prefix('phone-call-log')->group(function () {
        Route::get('/', [CallLogController::class, 'index'])->name('callLog.index');
        Route::post('/store', [CallLogController::class, 'store'])->name('callLog.store');
        Route::get('/edit/{callLog}', [CallLogController::class, 'edit'])->name('callLog.edit');
        Route::put('/update/{callLog}', [CallLogController::class, 'update'])->name('callLog.update');
        Route::put('/status/{callLog}', [CallLogController::class, 'status'])->name('callLog.status');
        Route::delete('/delete/{callLog}', [CallLogController::class, 'delete'])->name('callLog.delete');
    });

    Route::prefix('postal-dispatch')->group(function () {
        Route::get('/', [PostalDispatchController::class, 'index'])->name('postalDispatch.index');
        Route::post('/store', [PostalDispatchController::class, 'store'])->name('postalDispatch.store');
        Route::get('/edit/{postalDispatch}', [PostalDispatchController::class, 'edit'])->name('postalDispatch.edit');
        Route::put('/update/{postalDispatch}', [PostalDispatchController::class, 'update'])->name('postalDispatch.update');
        Route::put('/status/{postalDispatch}', [PostalDispatchController::class, 'status'])->name('postalDispatch.status');
        Route::delete('/delete/{postalDispatch}', [PostalDispatchController::class, 'delete'])->name('postalDispatch.delete');
    });

    Route::prefix('postal-receive')->group(function () {
        Route::get('/', [PostalReceiveController::class, 'index'])->name('postalReceive.index');
        Route::post('/store', [PostalReceiveController::class, 'store'])->name('postalReceive.store');
        Route::get('/edit/{postalReceive}', [PostalReceiveController::class, 'edit'])->name('postalReceive.edit');
        Route::put('/update/{postalReceive}', [PostalReceiveController::class, 'update'])->name('postalReceive.update');
        Route::put('/status/{postalReceive}', [PostalReceiveController::class, 'status'])->name('postalReceive.status');
        Route::delete('/delete/{postalReceive}', [PostalReceiveController::class, 'delete'])->name('postalReceive.delete');
    });

    Route::prefix('complain')->group(function () {
        Route::get('/', [ComplainController::class, 'index'])->name('complain.index');
        Route::post('/store', [ComplainController::class, 'store'])->name('complain.store');
        Route::get('/edit/{complain}', [ComplainController::class, 'edit'])->name('complain.edit');
        Route::put('/update/{complain}', [ComplainController::class, 'update'])->name('complain.update');
        Route::put('/status/{complain}', [ComplainController::class, 'status'])->name('complain.status');
        Route::delete('/delete/{complain}', [ComplainController::class, 'delete'])->name('complain.delete');
    });
});
