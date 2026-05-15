<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InternshipController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Default dashboard route (redirects based on role)
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('coordinator')) {
        return redirect()->route('coordinator.dashboard');
    }

    if ($user->hasRole('supervisor')) {
        return redirect()->route('supervisor.dashboard');
    }

    if ($user->hasRole('student')) {
        return redirect()->route('student.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications route (shared across all roles)
    Route::get('/notifications', function () {
        return view('notifications.index', [
            'notifications' => auth()->user()->notifications()->paginate(15),
        ]);
    })->name('notifications.index');

    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('notifications.mark-all-read');

    Route::post('/notifications/{id}/mark-read', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return back();
    })->name('notifications.mark-read');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users management
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    // Companies management
    Route::resource('companies', CompanyController::class);
    Route::post('/companies/{company}/toggle-status', [CompanyController::class, 'toggleStatus'])->name('companies.toggle-status');

    // Internships management
    Route::resource('internships', InternshipController::class);
    Route::post('/internships/{internship}/toggle-status', [InternshipController::class, 'toggleStatus'])->name('internships.toggle-status');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

// Coordinator routes
Route::middleware(['auth', 'role:coordinator'])->prefix('coordinator')->name('coordinator.')->group(function () {
    Route::get('/dashboard', function () {
        return view('coordinator.dashboard');
    })->name('dashboard');

    // Applications management (placeholder routes)
    Route::get('/applications', function () {
        return view('coordinator.applications.index');
    })->name('applications.index');

    // Placements management (placeholder routes)
    Route::get('/placements', function () {
        return view('coordinator.placements.index');
    })->name('placements.index');

    // Logbooks management (placeholder routes)
    Route::get('/logbooks', function () {
        return view('coordinator.logbooks.index');
    })->name('logbooks.index');

    // Evaluations management (placeholder routes)
    Route::get('/evaluations', function () {
        return view('coordinator.evaluations.index');
    })->name('evaluations.index');

    // Reports (placeholder routes)
    Route::get('/reports', function () {
        return view('coordinator.reports.index');
    })->name('reports.index');
});

// Supervisor routes
Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('supervisor.dashboard');
    })->name('dashboard');

    // Students management (placeholder routes)
    Route::get('/students', function () {
        return view('supervisor.students.index');
    })->name('students.index');

    // Logbooks management (placeholder routes)
    Route::get('/logbooks', function () {
        return view('supervisor.logbooks.index');
    })->name('logbooks.index');

    // Evaluations management (placeholder routes)
    Route::get('/evaluations', function () {
        return view('supervisor.evaluations.index');
    })->name('evaluations.index');
});

// Student routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', function () {
        return view('student.dashboard');
    })->name('dashboard');

    // Internships listing (placeholder routes)
    Route::get('/internships', function () {
        return view('student.internships.index');
    })->name('internships.index');

    // My Application (placeholder routes)
    Route::get('/application', function () {
        return view('student.application');
    })->name('application');

    // Logbook (placeholder routes)
    Route::get('/logbook', function () {
        return view('student.logbook.index');
    })->name('logbook.index');

    // Evaluations (placeholder routes)
    Route::get('/evaluations', function () {
        return view('student.evaluations');
    })->name('evaluations');

    // Documents (placeholder routes)
    Route::get('/documents', function () {
        return view('student.documents.index');
    })->name('documents.index');
});

require __DIR__.'/auth.php';
