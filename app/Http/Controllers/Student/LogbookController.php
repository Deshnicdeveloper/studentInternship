<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function index()
    {
        $placement = auth()->user()->placements()
            ->with('internship.company')
            ->where('status', 'active')
            ->first();

        $entries = collect();

        if ($placement) {
            $entries = $placement->logbooks()
                ->orderBy('week_number', 'desc')
                ->paginate(10);
        }

        return view('student.logbook.index', compact('placement', 'entries'));
    }

    public function create()
    {
        $placement = auth()->user()->placements()
            ->with('internship.company')
            ->where('status', 'active')
            ->first();

        if (!$placement) {
            return redirect()->route('student.dashboard')
                ->with('error', 'You do not have an active placement.');
        }

        return view('student.logbook.create', compact('placement'));
    }

    public function store(Request $request)
    {
        $placement = auth()->user()->placements()
            ->where('status', 'active')
            ->first();

        if (!$placement) {
            return redirect()->route('student.dashboard')
                ->with('error', 'You do not have an active placement.');
        }

        $validated = $request->validate([
            'week_number' => ['required', 'integer', 'min:1'],
            'week_start' => ['required', 'date'],
            'week_end' => ['required', 'date', 'after_or_equal:week_start'],
            'activities' => ['required', 'string', 'min:20'],
            'learnings' => ['nullable', 'string'],
            'challenges' => ['nullable', 'string'],
            'next_week_plan' => ['nullable', 'string'],
        ]);

        $status = $request->has('submit_entry') ? 'submitted' : 'draft';

        Logbook::create([
            'placement_id' => $placement->id,
            'student_id' => auth()->id(),
            'week_number' => $validated['week_number'],
            'week_start' => $validated['week_start'],
            'week_end' => $validated['week_end'],
            'activities' => $validated['activities'],
            'learnings' => $validated['learnings'],
            'challenges' => $validated['challenges'],
            'next_week_plan' => $validated['next_week_plan'],
            'status' => $status,
        ]);

        $message = $status === 'submitted'
            ? 'Logbook entry submitted successfully!'
            : 'Logbook entry saved as draft.';

        return redirect()->route('student.logbook.index')
            ->with('success', $message);
    }

    public function show(Logbook $logbook)
    {
        // Ensure student can only view their own logbooks
        if ($logbook->student_id !== auth()->id()) {
            abort(403);
        }

        return view('student.logbook.show', compact('logbook'));
    }

    public function edit(Logbook $logbook)
    {
        // Ensure student can only edit their own draft logbooks
        if ($logbook->student_id !== auth()->id()) {
            abort(403);
        }

        if ($logbook->status !== 'draft') {
            return back()->with('error', 'Only draft entries can be edited.');
        }

        return view('student.logbook.edit', compact('logbook'));
    }

    public function update(Request $request, Logbook $logbook)
    {
        if ($logbook->student_id !== auth()->id()) {
            abort(403);
        }

        if ($logbook->status !== 'draft' && !$request->has('submit_entry')) {
            return back()->with('error', 'Only draft entries can be edited.');
        }

        $validated = $request->validate([
            'week_number' => ['required', 'integer', 'min:1'],
            'week_start' => ['required', 'date'],
            'week_end' => ['required', 'date', 'after_or_equal:week_start'],
            'activities' => ['required', 'string', 'min:20'],
            'learnings' => ['nullable', 'string'],
            'challenges' => ['nullable', 'string'],
            'next_week_plan' => ['nullable', 'string'],
        ]);

        $status = $request->has('submit_entry') ? 'submitted' : 'draft';

        $logbook->update([
            'week_number' => $validated['week_number'],
            'week_start' => $validated['week_start'],
            'week_end' => $validated['week_end'],
            'activities' => $validated['activities'],
            'learnings' => $validated['learnings'],
            'challenges' => $validated['challenges'],
            'next_week_plan' => $validated['next_week_plan'],
            'status' => $status,
        ]);

        $message = $status === 'submitted'
            ? 'Logbook entry submitted successfully!'
            : 'Logbook entry updated.';

        return redirect()->route('student.logbook.show', $logbook)
            ->with('success', $message);
    }
}
