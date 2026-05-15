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

// Coordinator Routes (placeholder)
Route::middleware(['auth', 'role:coordinator'])->prefix('coordinator')->name('coordinator.')->group(function () {
    Route::get('/dashboard', function () {
        return view('coordinator.dashboard');
    })->name('dashboard');
});

// Supervisor Routes (placeholder)
Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('supervisor.dashboard');
    })->name('dashboard');
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
