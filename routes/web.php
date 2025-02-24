<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EnrollmentController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // CRUD Routes for all modules
        Route::resource('students', StudentController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('enrollments', EnrollmentController::class);
        Route::resource('grades', GradeController::class);
    });

    // Student routes
    Route::prefix('student')->name('student.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');

        // Grades - Read Only
        Route::get('/grades', [GradeController::class, 'studentIndex'])->name('grades.index');
        
        // Subjects - Read Only
        Route::get('/subjects', [SubjectController::class, 'studentIndex'])->name('subjects.index');
        
        // Enrollment - Read Only
        Route::get('/enrollment', [EnrollmentController::class, 'studentShow'])->name('enrollment.show');
    });

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('admins', AdminController::class);

require __DIR__.'/auth.php';
