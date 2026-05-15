<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use App\Notifications\LogbookFlagged;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function index(Request $request)
    {
        $query = Logbook::with(['student', 'placement.internship.company'])
            ->whereIn('status', ['submitted', 'approved', 'rejected']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by student
        if ($request->filled('student')) {
            $query->where('student_id', $request->student);
        }

        // Show only submitted (unreviewed) by default
        if (!$request->filled('status')) {
            $query->where('status', 'submitted');
        }

        $logbooks = $query->latest()->paginate(15)->withQueryString();

        // Get students for filter
        $students = \App\Models\User::role('student')
            ->whereHas('placements', fn($q) => $q->whereIn('status', ['active', 'completed']))
            ->orderBy('name')
            ->get();

        return view('coordinator.logbooks.index', compact('logbooks', 'students'));
    }

    public function show(Logbook $logbook)
    {
        $logbook->load(['student', 'placement.internship.company', 'placement.supervisor']);

        return view('coordinator.logbooks.show', compact('logbook'));
    }

    public function review(Request $request, Logbook $logbook)
    {
        $request->validate([
            'coordinator_comment' => ['nullable', 'string'],
            'action' => ['required', 'in:approve,flag'],
        ]);

        if ($request->action === 'approve') {
            $logbook->update([
                'status' => 'approved',
                'coordinator_comment' => $request->coordinator_comment,
                'reviewed_at' => now(),
                'reviewed_by' => auth()->id(),
            ]);

            return redirect()->route('coordinator.logbooks.index')
                ->with('success', 'Logbook entry approved.');
        }

        // Flag the entry
        $request->validate([
            'coordinator_comment' => ['required', 'string', 'min:10'],
        ]);

        $logbook->update([
            'status' => 'rejected',
            'coordinator_comment' => $request->coordinator_comment,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        // Notify student
        $logbook->student->notify(new LogbookFlagged($logbook));

        return redirect()->route('coordinator.logbooks.index')
            ->with('success', 'Logbook entry flagged and student notified.');
    }
}
