<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get current application
        $application = $user->applications()
            ->with(['internship.company'])
            ->latest()
            ->first();

        // Get active placement
        $placement = $user->placements()
            ->with(['internship.company', 'supervisor', 'coordinator'])
            ->where('status', 'active')
            ->first();

        // Logbook progress
        $logbookStats = [
            'total' => 0,
            'submitted' => 0,
            'draft' => 0,
        ];

        if ($placement) {
            $totalWeeks = max(1, $placement->start_date->diffInWeeks($placement->end_date));
            $submittedCount = $placement->logbooks()->where('status', 'submitted')->count();
            $draftCount = $placement->logbooks()->where('status', 'draft')->count();

            $logbookStats = [
                'total' => $totalWeeks,
                'submitted' => $submittedCount,
                'draft' => $draftCount,
            ];
        }

        // Recent notifications
        $notifications = $user->notifications()->latest()->take(5)->get();

        return view('student.dashboard', compact('application', 'placement', 'logbookStats', 'notifications'));
    }
}
