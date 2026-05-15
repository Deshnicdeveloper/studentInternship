<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function index()
    {
        $application = auth()->user()->applications()
            ->with(['internship.company', 'reviewer'])
            ->latest()
            ->first();

        $placement = null;
        if ($application && $application->status === 'approved') {
            $placement = auth()->user()->placements()
                ->with(['internship.company', 'supervisor', 'coordinator'])
                ->where('internship_id', $application->internship_id)
                ->first();
        }

        return view('student.application', compact('application', 'placement'));
    }

    public function withdraw()
    {
        $application = auth()->user()->applications()
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$application) {
            return back()->with('error', 'No pending application found.');
        }

        $application->delete();

        return redirect()->route('student.internships.index')
            ->with('success', 'Your application has been withdrawn.');
    }
}
