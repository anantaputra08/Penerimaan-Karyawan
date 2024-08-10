<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\LokerController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\loginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('root');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('departments', DepartmentController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('lokers', LokerController::class);
    Route::get('/positions/by-department', [LokerController::class, 'getPositionsByDepartment'])->name('positions.byDepartment');
    Route::get('/job-applications', [JobApplicationController::class, 'index'])->name('job_applications.index');
    Route::get('/job-applications/{id}', [JobApplicationController::class, 'show'])->name('job_applications.show');
    Route::put('/job-applications/{id}', [JobApplicationController::class, 'update'])->name('job_applications.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/lokers-opening', [LokerController::class, 'opening'])->name('lokers.opening');
    Route::get('/lokers/{id}', [LokerController::class, 'show'])->name('lokers.show');
    Route::get('/lokers/{id}/apply', [LokerController::class, 'showApplyForm'])->name('lokers.apply.form');
    Route::post('/lokers/{id}/apply', [LokerController::class, 'submitApplication'])->name('lokers.apply.submit');
    Route::get('/my-applications', [JobApplicationController::class, 'myApplications'])->name('job_applications.my');
    Route::get('job_applications/{id}/detail', [JobApplicationController::class, 'detail'])->name('job_applications.detail');
});


// Route::resource('departments', DepartmentController::class);
// Route::resource('positions', PositionController::class);
// Route::resource('lokers', LokerController::class);
// Route::get('/positions/by-department', [LokerController::class, 'getPositionsByDepartment'])->name('positions.byDepartment');

// Route::get('/job-applications', [JobApplicationController::class, 'index'])->name('job_applications.index');
// Route::get('/job-applications/{id}', [JobApplicationController::class, 'show'])->name('job_applications.show');
// Route::put('/job-applications/{id}', [JobApplicationController::class, 'update'])->name('job_applications.update');



// Route::get('/lokers-opening', [LokerController::class, 'opening'])->name('lokers.opening');
// Route::get('/lokers/{id}', [LokerController::class, 'show'])->name('lokers.show');
// Route::get('/lokers/{id}/apply', [LokerController::class, 'showApplyForm'])->name('lokers.apply.form');
// Route::post('/lokers/{id}/apply', [LokerController::class, 'submitApplication'])->name('lokers.apply.submit');
// Route::get('/my-applications', [JobApplicationController::class, 'myApplications'])
//     ->name('job_applications.my')
//     ->middleware('auth');
// Route::get('job_applications/{id}/detail', [JobApplicationController::class, 'detail'])->name('job_applications.detail');







