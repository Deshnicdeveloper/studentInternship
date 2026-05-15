<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Company;
use App\Models\Internship;
use App\Models\User;
use App\Notifications\ApplicationSubmitted;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index(Request $request)
    {
        $query = Internship::with('company')
            ->available()
            ->withCount(['applications', 'placements']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('company', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('company')) {
            $query->where('company_id', $request->company);
        }




        $internships = $query->latest()->paginate(12)->withQueryString();

        // Get all companies for filter
        $companies = Company::where('is_active', true)->orderBy('name')->get();

        // Get user's current application
        $userApplication = auth()->user()->applications()
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        return view('student.internships.index', compact('internships', 'companies', 'userApplication'));
    }

    public function show(Internship $internship)
    {
        $internship->load(['company', 'applications', 'placements']);

        $hasApplied = auth()->user()->applications()
            ->where('internship_id', $internship->id)
            ->exists();

        $hasActiveApplication = auth()->user()->applications()
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        return view('student.internships.show', compact('internship', 'hasApplied', 'hasActiveApplication'));
    }

    public function apply(Internship $internship)
    {
        $user = auth()->user();

        // Check if student already has a pending or approved application
        if ($user->applications()->whereIn('status', ['pending', 'approved'])->exists()) {
            return back()->with('error', 'You already have an active application. You can only apply to one internship at a time.');
        }

        // Check if internship is available
        if (!$internship->is_active || $internship->is_full) {
            return back()->with('error', 'This internship is no longer available.');
        }

        // Create application
        $application = Application::create([
            'student_id' => $user->id,
            'internship_id' => $internship->id,
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        // Notify coordinators
        $coordinators = User::role('coordinator')->get();
        foreach ($coordinators as $coordinator) {
            $coordinator->notify(new ApplicationSubmitted($application));
        }

        return redirect()->route('student.application')
            ->with('success', 'Your application has been submitted successfully!');
    }
}
