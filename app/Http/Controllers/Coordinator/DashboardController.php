<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Logbook;
use App\Models\Placement;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $stats = [
            'pending_applications' => Application::where('status', 'pending')->count(),
            'active_placements' => Placement::where('status', 'active')->count(),
            'pending_logbooks' => Logbook::where('status', 'submitted')->count(),
            'evaluations_due' => Placement::where('status', 'active')
                ->whereDoesntHave('evaluations', fn($q) => $q->where('type', 'midterm'))
                ->count(),
        ];

        // Recent pending applications
        $pendingApplications = Application::with(['student', 'internship.company'])
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

        // Students with overdue logbooks (more than 1 week without submission)
        $overdueStudents = Placement::with(['student', 'internship.company'])
            ->where('status', 'active')
            ->whereHas('student')
            ->get()
            ->filter(function ($placement) {
                $lastLogbook = $placement->logbooks()->latest()->first();
                if (!$lastLogbook) {
                    // No logbook at all, check if placement started more than a week ago
                    return $placement->start_date->diffInWeeks(now()) >= 1;
                }
                // Check if last logbook was more than a week ago
                return $lastLogbook->created_at->diffInWeeks(now()) >= 1;
            })
            ->take(10);

        return view('coordinator.dashboard', compact('stats', 'pendingApplications', 'overdueStudents'));
    }
}
