<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;

class EvaluationController extends Controller
{
    public function index()
    {
        $placement = auth()->user()->placements()
            ->with(['internship.company'])
            ->whereIn('status', ['active', 'completed'])
            ->first();

        $evaluations = collect();

        if ($placement) {
            $evaluations = $placement->evaluations()
                ->with('evaluator')
                ->latest()
                ->get();
        }

        return view('student.evaluations.index', compact('placement', 'evaluations'));
    }

    public function show(Evaluation $evaluation)
    {
        // Ensure the student owns this evaluation
        $placement = auth()->user()->placements()
            ->whereIn('status', ['active', 'completed'])
            ->first();

        if (!$placement || $evaluation->placement_id !== $placement->id) {
            abort(403);
        }

        $evaluation->load('evaluator');

        return view('student.evaluations.show', compact('evaluation'));
    }
}
