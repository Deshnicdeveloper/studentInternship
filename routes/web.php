<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Redirect /dashboard based on user role
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('coordinator')) {
        return redirect()->route('coordinator.dashboard');
    } elseif ($user->hasRole('supervisor')) {
        return redirect()->route('supervisor.dashboard');
    } else {
        return redirect()->route('student.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::post('/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');

    Route::resource('companies', App\Http\Controllers\Admin\CompanyController::class);
    Route::post('/companies/{company}/toggle-status', [App\Http\Controllers\Admin\CompanyController::class, 'toggleStatus'])->name('companies.toggle-status');

    Route::resource('internships', App\Http\Controllers\Admin\InternshipController::class);
    Route::post('/internships/{internship}/toggle-status', [App\Http\Controllers\Admin\InternshipController::class, 'toggleStatus'])->name('internships.toggle-status');

    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
});

// Coordinator Routes
Route::middleware(['auth', 'role:coordinator'])->prefix('coordinator')->name('coordinator.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Coordinator\DashboardController::class, 'index'])->name('dashboard');

    // Applications
    Route::get('/applications', [App\Http\Controllers\Coordinator\ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [App\Http\Controllers\Coordinator\ApplicationController::class, 'show'])->name('applications.show');
    Route::post('/applications/{application}/approve', [App\Http\Controllers\Coordinator\ApplicationController::class, 'approve'])->name('applications.approve');
    Route::post('/applications/{application}/reject', [App\Http\Controllers\Coordinator\ApplicationController::class, 'reject'])->name('applications.reject');

    // Placements
    Route::get('/placements', [App\Http\Controllers\Coordinator\PlacementController::class, 'index'])->name('placements.index');
    Route::get('/placements/{placement}', [App\Http\Controllers\Coordinator\PlacementController::class, 'show'])->name('placements.show');
    Route::post('/placements/{placement}/complete', [App\Http\Controllers\Coordinator\PlacementController::class, 'complete'])->name('placements.complete');
    Route::post('/placements/{placement}/terminate', [App\Http\Controllers\Coordinator\PlacementController::class, 'terminate'])->name('placements.terminate');

    // Logbooks
    Route::get('/logbooks', [App\Http\Controllers\Coordinator\LogbookController::class, 'index'])->name('logbooks.index');
    Route::get('/logbooks/{logbook}', [App\Http\Controllers\Coordinator\LogbookController::class, 'show'])->name('logbooks.show');
    Route::post('/logbooks/{logbook}/review', [App\Http\Controllers\Coordinator\LogbookController::class, 'review'])->name('logbooks.review');

    // Evaluations
    Route::get('/evaluations', [App\Http\Controllers\Coordinator\EvaluationController::class, 'index'])->name('evaluations.index');
    Route::get('/evaluations/{evaluation}', [App\Http\Controllers\Coordinator\EvaluationController::class, 'show'])->name('evaluations.show');
    Route::post('/placements/{placement}/grade', [App\Http\Controllers\Coordinator\EvaluationController::class, 'grade'])->name('placements.grade');

    // Reports
    Route::get('/reports', [App\Http\Controllers\Coordinator\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{placement}/pdf', [App\Http\Controllers\Coordinator\ReportController::class, 'generatePdf'])->name('reports.pdf');
    Route::get('/reports/export-csv', [App\Http\Controllers\Coordinator\ReportController::class, 'exportCsv'])->name('reports.export-csv');
});

// Supervisor Routes
Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Supervisor\DashboardController::class, 'index'])->name('dashboard');

    // Assigned Students
    Route::get('/students', [App\Http\Controllers\Supervisor\StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{placement}', [App\Http\Controllers\Supervisor\StudentController::class, 'show'])->name('students.show');

    // Logbooks
    Route::get('/logbooks', [App\Http\Controllers\Supervisor\LogbookController::class, 'index'])->name('logbooks.index');
    Route::get('/logbooks/{logbook}', [App\Http\Controllers\Supervisor\LogbookController::class, 'show'])->name('logbooks.show');
    Route::post('/logbooks/{logbook}/review', [App\Http\Controllers\Supervisor\LogbookController::class, 'review'])->name('logbooks.review');

    // Evaluations
    Route::get('/evaluations', [App\Http\Controllers\Supervisor\EvaluationController::class, 'index'])->name('evaluations.index');
    Route::get('/evaluations/create/{placement}', [App\Http\Controllers\Supervisor\EvaluationController::class, 'create'])->name('evaluations.create');
    Route::post('/evaluations/{placement}', [App\Http\Controllers\Supervisor\EvaluationController::class, 'store'])->name('evaluations.store');
    Route::get('/evaluations/{evaluation}', [App\Http\Controllers\Supervisor\EvaluationController::class, 'show'])->name('evaluations.show');

    // Profile
    Route::get('/profile', [App\Http\Controllers\Supervisor\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\Supervisor\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Supervisor\ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');

    // Internships
    Route::get('/internships', [App\Http\Controllers\Student\InternshipController::class, 'index'])->name('internships.index');
    Route::get('/internships/{internship}', [App\Http\Controllers\Student\InternshipController::class, 'show'])->name('internships.show');
    Route::post('/internships/{internship}/apply', [App\Http\Controllers\Student\InternshipController::class, 'apply'])->name('internships.apply');

    // Application
    Route::get('/application', [App\Http\Controllers\Student\ApplicationController::class, 'index'])->name('application');
    Route::delete('/application/withdraw', [App\Http\Controllers\Student\ApplicationController::class, 'withdraw'])->name('application.withdraw');

    // Logbook
    Route::resource('logbook', App\Http\Controllers\Student\LogbookController::class)->except(['destroy']);

    // Evaluations
    Route::get('/evaluations', [App\Http\Controllers\Student\EvaluationController::class, 'index'])->name('evaluations.index');
    Route::get('/evaluations/{evaluation}', [App\Http\Controllers\Student\EvaluationController::class, 'show'])->name('evaluations.show');

    // Documents
    Route::get('/documents', [App\Http\Controllers\Student\DocumentController::class, 'index'])->name('documents.index');
    Route::post('/documents', [App\Http\Controllers\Student\DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}/download', [App\Http\Controllers\Student\DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}', [App\Http\Controllers\Student\DocumentController::class, 'destroy'])->name('documents.destroy');

    // Profile
    Route::get('/profile', [App\Http\Controllers\Student\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\Student\ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
