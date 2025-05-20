<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;
use App\Models\Course;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing page (public)
Route::get('/', function () {
    $courses = \App\Models\Course::whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->get();
    return view('landing', compact('courses'));
});
// Attendance Check-In Routes (public)
Route::get('/attendance/{course}', [AttendanceController::class, 'showCheckInForm'])
    ->name('attendance.checkin.form');

Route::post('/attendance/{course}', [AttendanceController::class, 'submitCheckIn'])
    ->name('attendance.checkin.submit');

// Route to set/update the magic word for today's attendance session (public)
Route::post('/attendance/set-magic-word/{course}', [AttendanceController::class, 'setMagicWord'])
    ->name('attendance.setMagicWord');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard (requires login)
    Route::get('/dashboard', function () {
        $courses = Course::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();
        return view('dashboard', compact('courses'));
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Course routes (for administrative course management)
    Route::resource('courses', CourseController::class)->only([

        'create', 'store', 'index', 'all', 'edit', 'update', 'destroy'

    ]);

    // Student management routes (for administrative student management)
    Route::resource('students', StudentController::class)->only([
        'index', 'create', 'store', 'edit', 'update'
    ]);

Route::get('/attendance-records', [AttendanceController::class, 'recordsIndex'])
    ->name('attendance.records.index');

Route::get('/attendance-history/{course}', [AttendanceController::class, 'history'])
    ->name('attendance.history');

// List active courses for alerts (you might make this public or auth-protected)
Route::get('/attendance-alerts', [AttendanceController::class, 'alertsIndex'])
    ->name('attendance.alerts.index');

// For a specific course, show students meeting alert criteria.
Route::get('/attendance-alerts/{course}', [AttendanceController::class, 'alertsForCourse'])
    ->name('attendance.alerts.course');

// Attendance reports show counts for all students in a course.
Route::get('/attendance-report', [AttendanceController::class, 'reportIndex'])
    ->name('attendance.report.index');

Route::get('/attendance-report/{course}', [AttendanceController::class, 'reportForCourse'])
    ->name('attendance.report.course');


Route::get('/course/{course}/students', [StudentController::class, 'showForCourse'])
    ->name('students.showForCourse');


Route::get('/students/{course}/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::patch('/students/{course}/{student}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{course}/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
Route::post('/course/{course}/students', [StudentController::class, 'store'])->name('students.store');

    Route::get('/courses/all', [CourseController::class, 'all'])
         ->name('courses.all');

    // Custom route to list trashed courses for restore.
    Route::get('/courses/trashed', [CourseController::class, 'trashed'])
         ->name('courses.trashed');

    // Route to restore a course.
    Route::post('/courses/{trashed_course}/restore', [CourseController::class, 'restore'])
         ->name('courses.restore');

});

require __DIR__.'/auth.php';
