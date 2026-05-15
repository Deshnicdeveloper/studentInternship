<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use App\Models\Placement;

class DashboardController extends Controller
{
    public function index()
    {
        $supervisor = auth()->user();

        // Get assigned placements
        $assignedPlacements = Placement::where('supervisor_id', $supervisor->id)
            ->whereIn('status', ['active', 'completed'])
            ->with(['student', 'internship.company'])
            ->get();

        // Stats
        $stats = [
            'active_students' => $assignedPlacements->where('status', 'active')->count(),
            'completed_students' => $assignedPlacements->where('status', 'completed')->count(),
            'pending_logbooks' => Logbook::whereIn('placement_id', $assignedPlacements->pluck('id'))
                ->where('status', 'submitted')
                ->count(),
            'total_evaluations' => $assignedPlacements->sum(function ($placement) use ($supervisor) {
                return $placement->evaluations()->where('evaluated_by', $supervisor->id)->count();
            }),
        ];

        // Pending logbooks for review
        $pendingLogbooks = Logbook::whereIn('placement_id', $assignedPlacements->pluck('id'))
            ->where('status', 'submitted')
            ->with(['student', 'placement.internship.company'])
            ->latest()
            ->take(5)
            ->get();

        // Students requiring evaluation (active placements without recent evaluation)
        $studentsNeedingEvaluation = $assignedPlacements
            ->where('status', 'active')
            ->filter(function ($placement) use ($supervisor) {
                $hasEvaluation = $placement->evaluations()
                    ->where('evaluated_by', $supervisor->id)
                    ->exists();
                return !$hasEvaluation;
            });

        return view('supervisor.dashboard', compact(
            'stats',
            'assignedPlacements',
            'pendingLogbooks',
            'studentsNeedingEvaluation'
        ));
    }
}
