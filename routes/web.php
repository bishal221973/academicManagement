<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SidebarController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
    return redirect()->route('login');
})->name('root');

// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin-login', [LoginController::class, 'adminLogin'])->name('admin.login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('fetch-sidebar',[SidebarController::class,'index'])->name('fetch.sidebar');
    Route::middleware('web')
        ->prefix('admin')
        ->group(__DIR__ . '/admin.php');
});



