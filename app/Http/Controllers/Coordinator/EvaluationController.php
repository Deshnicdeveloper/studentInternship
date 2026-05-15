<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Placement;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $query = Evaluation::with(['placement.student', 'placement.internship.company', 'evaluator']);

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by company
        if ($request->filled('company')) {
            $query->whereHas('placement.internship', fn($q) => $q->where('company_id', $request->company));
        }

        $evaluations = $query->latest()->paginate(15)->withQueryString();

        // Get companies for filter
        $companies = \App\Models\Company::where('is_active', true)->orderBy('name')->get();

        return view('coordinator.evaluations.index', compact('evaluations', 'companies'));
    }

    public function show(Evaluation $evaluation)
    {
        $evaluation->load(['placement.student', 'placement.internship.company', 'evaluator']);

        return view('coordinator.evaluations.show', compact('evaluation'));
    }

    public function grade(Request $request, Placement $placement)
    {
        $request->validate([
            'coordinator_grade' => ['required', 'string', 'max:2'],
            'coordinator_comment' => ['nullable', 'string'],
        ]);

        $placement->update([
            'coordinator_grade' => $request->coordinator_grade,
            'coordinator_comment' => $request->coordinator_comment,
            'graded_at' => now(),
        ]);

        return back()->with('success', 'Final grade submitted successfully.');
    }
}
