<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Placement;
use Illuminate\Http\Request;

class PlacementController extends Controller
{
    public function index(Request $request)
    {
        $query = Placement::with(['student', 'internship.company', 'supervisor', 'coordinator']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by company
        if ($request->filled('company')) {
            $query->whereHas('internship', fn($q) => $q->where('company_id', $request->company));
        }

        // Search by student name
        if ($request->filled('search')) {
            $query->whereHas('student', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }

        $placements = $query->latest()->paginate(15)->withQueryString();

        // Get companies for filter
        $companies = \App\Models\Company::where('is_active', true)->orderBy('name')->get();

        return view('coordinator.placements.index', compact('placements', 'companies'));
    }

    public function show(Placement $placement)
    {
        $placement->load([
            'student',
            'internship.company',
            'supervisor',
            'coordinator',
            'logbooks' => fn($q) => $q->orderBy('week_number', 'desc'),
            'evaluations.evaluator',
        ]);

        return view('coordinator.placements.show', compact('placement'));
    }

    public function complete(Placement $placement)
    {
        $placement->update(['status' => 'completed']);

        return back()->with('success', 'Placement marked as completed.');
    }

    public function terminate(Request $request, Placement $placement)
    {
        $request->validate([
            'reason' => ['required', 'string', 'min:10'],
        ]);

        $placement->update([
            'status' => 'terminated',
            'termination_reason' => $request->reason,
        ]);

        return back()->with('success', 'Placement terminated.');
    }
}
