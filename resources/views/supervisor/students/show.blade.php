@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('supervisor.students.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Back to Students</a>
        </div>

        <!-- Student Info -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">{{ $placement->student->name }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ $placement->student->email }}</p>
                </div>
                <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full
                    {{ $placement->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($placement->status) }}
                </span>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Company</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $placement->internship->company->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Position</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $placement->internship->title }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Duration</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $placement->start_date->format('M d, Y') }} - {{ $placement->end_date->format('M d, Y') }}</p>
                    </div>
                    @if($placement->student->phone)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $placement->student->phone }}</p>
                    </div>
                    @endif
                    @if($placement->student->department)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Department</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $placement->student->department }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Logbooks -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Logbook Entries</h3>
                    <span class="text-sm text-gray-500">{{ $placement->logbooks->count() }} entries</span>
                </div>
                <div class="px-4 py-5 sm:p-6 max-h-96 overflow-y-auto">
                    @if($placement->logbooks->count() > 0)
                        <ul class="divide-y divide-gray-200">
                            @foreach($placement->logbooks as $logbook)
                                <li class="py-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Week {{ $logbook->week_number }}</p>
                                            <p class="text-sm text-gray-500">{{ $logbook->week_start->format('M d') }} - {{ $logbook->week_end->format('M d, Y') }}</p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($logbook->status === 'approved') bg-green-100 text-green-800
                                                @elseif($logbook->status === 'submitted') bg-yellow-100 text-yellow-800
                                                @elseif($logbook->status === 'rejected') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($logbook->status) }}
                                            </span>
                                            <a href="{{ route('supervisor.logbooks.show', $logbook) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">View</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">No logbook entries yet.</p>
                    @endif
                </div>
            </div>

            <!-- Evaluations -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Evaluations</h3>
                    <a href="{{ route('supervisor.evaluations.create', $placement) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                        + Add Evaluation
                    </a>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    @php
                        $myEvaluations = $placement->evaluations->where('evaluated_by', auth()->id());
                    @endphp
                    @if($myEvaluations->count() > 0)
                        <ul class="divide-y divide-gray-200">
                            @foreach($myEvaluations as $evaluation)
                                <li class="py-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ ucfirst($evaluation->type) }} Evaluation</p>
                                            <p class="text-sm text-gray-500">Submitted {{ $evaluation->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                Score: {{ $evaluation->total_score }}/100 ({{ $evaluation->grade }})
                                            </span>
                                            <a href="{{ route('supervisor.evaluations.show', $evaluation) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">View</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">No evaluations submitted yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
