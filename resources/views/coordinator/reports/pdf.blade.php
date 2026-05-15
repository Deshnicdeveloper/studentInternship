<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Placement Report - {{ $placement->student->name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #4F46E5;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background-color: #4F46E5;
            color: white;
            padding: 8px 15px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            width: 150px;
            font-weight: bold;
            padding: 5px 0;
            color: #666;
        }
        .info-value {
            display: table-cell;
            padding: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .score-bar {
            background-color: #e5e7eb;
            height: 15px;
            border-radius: 3px;
            overflow: hidden;
        }
        .score-fill {
            background-color: #4F46E5;
            height: 100%;
        }
        .grade-box {
            text-align: center;
            padding: 20px;
            border: 2px solid #4F46E5;
            margin-top: 20px;
        }
        .grade-box .grade {
            font-size: 48px;
            font-weight: bold;
            color: #4F46E5;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
            text-align: center;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
        }
        .status-active { background-color: #DEF7EC; color: #03543F; }
        .status-completed { background-color: #E5E7EB; color: #374151; }
        .status-submitted { background-color: #FEF3C7; color: #92400E; }
        .status-approved { background-color: #DEF7EC; color: #03543F; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SIMS - Internship Placement Report</h1>
        <p>Student Internship Management System</p>
    </div>

    <!-- Student Information -->
    <div class="section">
        <div class="section-title">Student Information</div>
        <div class="info-grid">
            <div class="info-row">
                <span class="info-label">Name:</span>
                <span class="info-value">{{ $placement->student->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Student ID:</span>
                <span class="info-value">{{ $placement->student->student_id ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $placement->student->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Department:</span>
                <span class="info-value">{{ $placement->student->department ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    <!-- Company Information -->
    <div class="section">
        <div class="section-title">Company Information</div>
        <div class="info-grid">
            <div class="info-row">
                <span class="info-label">Company:</span>
                <span class="info-value">{{ $placement->internship->company->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Position:</span>
                <span class="info-value">{{ $placement->internship->title }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Supervisor:</span>
                <span class="info-value">{{ $placement->supervisor->name ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Period:</span>
                <span class="info-value">{{ $placement->start_date->format('F d, Y') }} - {{ $placement->end_date->format('F d, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">
                    <span class="status-badge status-{{ $placement->status }}">{{ ucfirst($placement->status) }}</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Logbook Summary -->
    <div class="section">
        <div class="section-title">Logbook Summary</div>
        @if($placement->logbooks->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Week</th>
                        <th>Period</th>
                        <th>Status</th>
                        <th>Activities Summary</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($placement->logbooks as $logbook)
                        <tr>
                            <td>Week {{ $logbook->week_number }}</td>
                            <td>{{ $logbook->week_start->format('M d') }} - {{ $logbook->week_end->format('M d') }}</td>
                            <td>
                                <span class="status-badge status-{{ $logbook->status }}">{{ ucfirst($logbook->status) }}</span>
                            </td>
                            <td>{{ Str::limit($logbook->activities, 100) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="margin-top: 10px;">
                <strong>Total Entries:</strong> {{ $placement->logbooks->count() }} |
                <strong>Approved:</strong> {{ $placement->logbooks->where('status', 'approved')->count() }} |
                <strong>Pending:</strong> {{ $placement->logbooks->where('status', 'submitted')->count() }}
            </p>
        @else
            <p>No logbook entries submitted.</p>
        @endif
    </div>

    <!-- Evaluations -->
    <div class="section">
        <div class="section-title">Evaluation Scores</div>
        @if($placement->evaluations->count() > 0)
            @foreach($placement->evaluations as $evaluation)
                <div style="margin-bottom: 20px;">
                    <h4 style="margin: 0 0 10px;">{{ ucfirst($evaluation->type) }} Evaluation (by {{ $evaluation->evaluator->name ?? 'Unknown' }})</h4>
                    <table>
                        <tr>
                            <th>Criteria</th>
                            <th>Score</th>
                        </tr>
                        @if($evaluation->technical_skills)
                            <tr>
                                <td>Technical Skills</td>
                                <td>{{ $evaluation->technical_skills }}/20</td>
                            </tr>
                        @endif
                        @if($evaluation->communication)
                            <tr>
                                <td>Communication</td>
                                <td>{{ $evaluation->communication }}/20</td>
                            </tr>
                        @endif
                        @if($evaluation->teamwork)
                            <tr>
                                <td>Teamwork</td>
                                <td>{{ $evaluation->teamwork }}/20</td>
                            </tr>
                        @endif
                        @if($evaluation->punctuality)
                            <tr>
                                <td>Punctuality</td>
                                <td>{{ $evaluation->punctuality }}/20</td>
                            </tr>
                        @endif
                        @if($evaluation->initiative)
                            <tr>
                                <td>Initiative</td>
                                <td>{{ $evaluation->initiative }}/20</td>
                            </tr>
                        @endif
                        <tr style="font-weight: bold;">
                            <td>Total Score</td>
                            <td>{{ $evaluation->total_score }}%</td>
                        </tr>
                    </table>
                    @if($evaluation->comments)
                        <p><strong>Comments:</strong> {{ $evaluation->comments }}</p>
                    @endif
                </div>
            @endforeach
        @else
            <p>No evaluations submitted yet.</p>
        @endif
    </div>

    <!-- Final Grade -->
    @if($placement->coordinator_grade)
        <div class="section">
            <div class="section-title">Final Grade</div>
            <div class="grade-box">
                <div class="grade">{{ $placement->coordinator_grade }}</div>
                <p>Coordinator Assessment</p>
                @if($placement->coordinator_comment)
                    <p style="margin-top: 10px; font-style: italic;">"{{ $placement->coordinator_comment }}"</p>
                @endif
            </div>
        </div>
    @endif

    <div class="footer">
        <p>Generated on {{ now()->format('F d, Y \a\t g:i A') }} | SIMS - Student Internship Management System</p>
    </div>
</body>
</html>
