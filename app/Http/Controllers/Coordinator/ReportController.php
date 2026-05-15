<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Placement;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Placement::with(['student', 'internship.company']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by company
        if ($request->filled('company')) {
            $query->whereHas('internship', fn($q) => $q->where('company_id', $request->company));
        }

        $placements = $query->latest()->paginate(15)->withQueryString();

        // Get companies for filter
        $companies = \App\Models\Company::where('is_active', true)->orderBy('name')->get();

        return view('coordinator.reports.index', compact('placements', 'companies'));
    }

    public function generatePdf(Placement $placement)
    {
        $placement->load([
            'student',
            'internship.company',
            'supervisor',
            'coordinator',
            'logbooks' => fn($q) => $q->orderBy('week_number'),
            'evaluations.evaluator',
        ]);

        $pdf = Pdf::loadView('coordinator.reports.pdf', compact('placement'));

        return $pdf->download("placement-report-{$placement->student->name}.pdf");
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $placements = Placement::with(['student', 'internship.company', 'supervisor'])
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="placements-export.csv"',
        ];

        $callback = function () use ($placements) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'Student Name',
                'Student ID',
                'Email',
                'Company',
                'Position',
                'Supervisor',
                'Start Date',
                'End Date',
                'Status',
                'Coordinator Grade',
            ]);

            // Data rows
            foreach ($placements as $placement) {
                fputcsv($file, [
                    $placement->student->name ?? 'N/A',
                    $placement->student->student_id ?? 'N/A',
                    $placement->student->email ?? 'N/A',
                    $placement->internship->company->name ?? 'N/A',
                    $placement->internship->title ?? 'N/A',
                    $placement->supervisor->name ?? 'N/A',
                    $placement->start_date?->format('Y-m-d'),
                    $placement->end_date?->format('Y-m-d'),
                    $placement->status,
                    $placement->coordinator_grade ?? 'Not graded',
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'placements-export.csv', $headers);
    }
}
