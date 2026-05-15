<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use App\Models\Placement;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function index(Request $request)
    {
        $supervisor = auth()->user();

        // Get placement IDs assigned to this supervisor
        $placementIds = Placement::where('supervisor_id', $supervisor->id)
            ->whereIn('status', ['active', 'completed'])
            ->pluck('id');

        $query = Logbook::whereIn('placement_id', $placementIds)
            ->with(['student', 'placement.internship.company']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by student
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $logbooks = $query->latest()->paginate(10);

        // Get students for filter dropdown
        $students = Placement::where('supervisor_id', $supervisor->id)
            ->whereIn('status', ['active', 'completed'])
            ->with('student')
            ->get()
            ->pluck('student')
            ->unique('id');

        return view('supervisor.logbooks.index', compact('logbooks', 'students'));
    }

    public function show(Logbook $logbook)
    {
        $supervisor = auth()->user();

        // Ensure this logbook belongs to a student assigned to this supervisor
        $placement = Placement::where('supervisor_id', $supervisor->id)
            ->where('id', $logbook->placement_id)
            ->firstOrFail();

        $logbook->load(['student', 'placement.internship.company']);

        return view('supervisor.logbooks.show', compact('logbook'));
    }

    public function review(Request $request, Logbook $logbook)
    {
        $supervisor = auth()->user();

        // Ensure this logbook belongs to a student assigned to this supervisor
        $placement = Placement::where('supervisor_id', $supervisor->id)
            ->where('id', $logbook->placement_id)
            ->firstOrFail();

        $request->validate([
            'action' => ['required', 'in:approve,request_changes'],
            'supervisor_feedback' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($request->action === 'approve') {
            $logbook->update([
                'status' => 'approved',
                'supervisor_feedback' => $request->supervisor_feedback,
            ]);

            return redirect()->route('supervisor.logbooks.index')
                ->with('success', 'Logbook approved successfully.');
        }

        // Request changes
        $request->validate([
            'supervisor_feedback' => ['required', 'string', 'max:2000'],
        ]);

        $logbook->update([
            'status' => 'rejected',
            'supervisor_feedback' => $request->supervisor_feedback,
        ]);

        return redirect()->route('supervisor.logbooks.index')
            ->with('success', 'Feedback sent to student. They can revise and resubmit.');
    }
}
