<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Placement;
use App\Models\User;
use App\Notifications\ApplicationApproved;
use App\Notifications\ApplicationRejected;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::with(['student', 'internship.company', 'reviewer']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by company
        if ($request->filled('company')) {
            $query->whereHas('internship', fn($q) => $q->where('company_id', $request->company));
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $applications = $query->latest()->paginate(15)->withQueryString();

        // Get companies for filter
        $companies = \App\Models\Company::where('is_active', true)->orderBy('name')->get();

        return view('coordinator.applications.index', compact('applications', 'companies'));
    }

    public function show(Application $application)
    {
        $application->load(['student', 'internship.company', 'reviewer']);

        // Get supervisors for assignment
        $supervisors = User::role('supervisor')->where('is_active', true)->orderBy('name')->get();

        return view('coordinator.applications.show', compact('application', 'supervisors'));
    }

    public function approve(Request $request, Application $application)
    {
        $request->validate([
            'supervisor_id' => ['required', 'exists:users,id'],
        ]);

        // Verify supervisor role
        $supervisor = User::findOrFail($request->supervisor_id);
        if (!$supervisor->hasRole('supervisor')) {
            return back()->with('error', 'Selected user is not a supervisor.');
        }

        // Update application
        $application->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        // Create placement
        Placement::create([
            'application_id' => $application->id,
            'student_id' => $application->student_id,
            'internship_id' => $application->internship_id,
            'supervisor_id' => $request->supervisor_id,
            'coordinator_id' => auth()->id(),
            'start_date' => $application->internship->start_date,
            'end_date' => $application->internship->end_date,
            'status' => 'active',
        ]);

        // Notify student
        $application->student->notify(new ApplicationApproved($application));

        return redirect()->route('coordinator.applications.index')
            ->with('success', 'Application approved and placement created successfully.');
    }

    public function reject(Request $request, Application $application)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'min:10'],
        ]);

        $application->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
            'remarks' => $request->rejection_reason,
        ]);

        // Notify student
        $application->student->notify(new ApplicationRejected($application));

        return redirect()->route('coordinator.applications.index')
            ->with('success', 'Application rejected successfully.');
    }
}
