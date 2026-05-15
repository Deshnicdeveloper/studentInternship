<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Company;
use App\Models\Internship;
use App\Models\Placement;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => User::role('student')->count(),
            'total_companies' => Company::count(),
            'total_internships' => Internship::count(),
            'active_placements' => Placement::where('status', 'active')->count(),
        ];

        $recentApplications = Application::with(['student', 'internship.company'])
            ->latest()
            ->take(10)
            ->get();

        $applicationsPerMonth = Application::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentApplications', 'applicationsPerMonth'));
    }
}
