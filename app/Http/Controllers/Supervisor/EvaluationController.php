<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Placement;
use App\Models\User;
use App\Notifications\EvaluationSubmitted;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $supervisor = auth()->user();

        // Get placement IDs assigned to this supervisor
        $placementIds = Placement::where('supervisor_id', $supervisor->id)
            ->whereIn('status', ['active', 'completed'])
            ->pluck('id');

        $query = Evaluation::whereIn('placement_id', $placementIds)
            ->where('evaluated_by', $supervisor->id)
            ->with(['placement.student', 'placement.internship.company']);

        $evaluations = $query->latest()->paginate(10);

        return view('supervisor.evaluations.index', compact('evaluations'));
    }

    public function create(Placement $placement)
    {
        $supervisor = auth()->user();

        // Ensure this placement is assigned to this supervisor
        if ($placement->supervisor_id !== $supervisor->id) {
            abort(403, 'You are not assigned to this student.');
        }

        // Check if supervisor has already submitted evaluation for this placement
        $existingEvaluations = Evaluation::where('placement_id', $placement->id)
            ->where('evaluated_by', $supervisor->id)
            ->pluck('type')
            ->toArray();

        $placement->load(['student', 'internship.company']);

        return view('supervisor.evaluations.create', compact('placement', 'existingEvaluations'));
    }

    public function store(Request $request, Placement $placement)
    {
        $supervisor = auth()->user();

        // Ensure this placement is assigned to this supervisor
        if ($placement->supervisor_id !== $supervisor->id) {
            abort(403, 'You are not assigned to this student.');
        }

        $request->validate([
            'type' => ['required', 'in:midterm,final'],
            'technical_skills' => ['required', 'integer', 'min:0', 'max:20'],
            'communication' => ['required', 'integer', 'min:0', 'max:20'],
            'teamwork' => ['required', 'integer', 'min:0', 'max:20'],
            'punctuality' => ['required', 'integer', 'min:0', 'max:20'],
            'initiative' => ['required', 'integer', 'min:0', 'max:20'],
            'strengths' => ['nullable', 'string', 'max:2000'],
            'areas_for_improvement' => ['nullable', 'string', 'max:2000'],
            'comments' => ['nullable', 'string', 'max:2000'],
        ]);

        // Check if this type of evaluation already exists
        $existing = Evaluation::where('placement_id', $placement->id)
            ->where('evaluated_by', $supervisor->id)
            ->where('type', $request->type)
            ->exists();

        if ($existing) {
            return back()->withErrors(['type' => 'You have already submitted a ' . $request->type . ' evaluation for this student.']);
        }

        // Calculate total score
        $totalScore = $request->technical_skills + $request->communication +
                      $request->teamwork + $request->punctuality + $request->initiative;

        $evaluation = Evaluation::create([
            'placement_id' => $placement->id,
            'evaluated_by' => $supervisor->id,
            'type' => $request->type,
            'technical_skills' => $request->technical_skills,
            'communication' => $request->communication,
            'teamwork' => $request->teamwork,
            'punctuality' => $request->punctuality,
            'initiative' => $request->initiative,
            'total_score' => $totalScore,
            'grade' => $this->calculateGrade($totalScore),
            'strengths' => $request->strengths,
            'areas_for_improvement' => $request->areas_for_improvement,
            'comments' => $request->comments,
        ]);

        // Notify coordinators
        $coordinators = User::role('coordinator')->get();
        foreach ($coordinators as $coordinator) {
            $coordinator->notify(new EvaluationSubmitted($evaluation));
        }

        return redirect()->route('supervisor.evaluations.index')
            ->with('success', ucfirst($request->type) . ' evaluation submitted successfully.');
    }

    public function show(Evaluation $evaluation)
    {
        $supervisor = auth()->user();

        // Ensure this evaluation was submitted by this supervisor
        if ($evaluation->evaluated_by !== $supervisor->id) {
            abort(403, 'You cannot view this evaluation.');
        }

        $evaluation->load(['placement.student', 'placement.internship.company']);

        return view('supervisor.evaluations.show', compact('evaluation'));
    }

    private function calculateGrade(float $totalScore): string
    {
        if ($totalScore >= 90) return 'A';
        if ($totalScore >= 80) return 'B';
        if ($totalScore >= 70) return 'C';
        if ($totalScore >= 60) return 'D';
        return 'F';
    }
}
