<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInternshipRequest;
use App\Http\Requests\Admin\UpdateInternshipRequest;
use App\Models\Company;
use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index(Request $request)
    {
        $query = Internship::with('company')
            ->withCount(['applications', 'placements']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('company', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by company
        if ($request->filled('company')) {
            $query->where('company_id', $request->company);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $internships = $query->latest()->paginate(15)->withQueryString();
        $companies = Company::active()->orderBy('name')->get();

        return view('admin.internships.index', compact('internships', 'companies'));
    }

    public function create()
    {
        $companies = Company::active()->orderBy('name')->get();
        return view('admin.internships.create', compact('companies'));
    }

    public function store(StoreInternshipRequest $request)
    {
        Internship::create($request->validated());

        return redirect()->route('admin.internships.index')
            ->with('success', 'Internship created successfully.');
    }

    public function show(Internship $internship)
    {
        $internship->load([
            'company',
            'applications.student',
            'placements.student'
        ]);

        return view('admin.internships.show', compact('internship'));
    }

    public function edit(Internship $internship)
    {
        $companies = Company::active()->orderBy('name')->get();
        return view('admin.internships.edit', compact('internship', 'companies'));
    }

    public function update(UpdateInternshipRequest $request, Internship $internship)
    {
        $internship->update($request->validated());

        return redirect()->route('admin.internships.index')
            ->with('success', 'Internship updated successfully.');
    }

    public function destroy(Internship $internship)
    {
        // Check if internship has applications or placements
        if ($internship->applications()->exists() || $internship->placements()->exists()) {
            return back()->with('error', 'Cannot delete internship with existing applications or placements.');
        }

        $internship->delete();

        return redirect()->route('admin.internships.index')
            ->with('success', 'Internship deleted successfully.');
    }

    public function toggleStatus(Internship $internship)
    {
        $internship->update(['is_active' => !$internship->is_active]);

        $status = $internship->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Internship {$status} successfully.");
    }
}
