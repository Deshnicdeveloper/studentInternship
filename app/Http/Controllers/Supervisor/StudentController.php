<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Placement;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $supervisor = auth()->user();

        $query = Placement::where('supervisor_id', $supervisor->id)
            ->with(['student', 'internship.company']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['active', 'completed']);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $placements = $query->latest()->paginate(10);

        return view('supervisor.students.index', compact('placements'));
    }

    public function show(Placement $placement)
    {
        $supervisor = auth()->user();

        // Ensure this placement is assigned to this supervisor
        if ($placement->supervisor_id !== $supervisor->id) {
            abort(403, 'You are not assigned to this student.');
        }

        $placement->load([
            'student',
            'internship.company',
            'logbooks' => fn($q) => $q->latest(),
            'evaluations' => fn($q) => $q->with('evaluator')->latest(),
        ]);

        return view('supervisor.students.show', compact('placement'));
    }
}
