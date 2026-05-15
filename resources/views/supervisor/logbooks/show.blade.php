@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('supervisor.logbooks.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Back to Logbooks</a>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Logbook - Week {{ $logbook->week_number }}</h1>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $logbook->student->name }} | {{ $logbook->placement->internship->company->name }}
                        </p>
                    </div>
                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full
                        @if($logbook->status === 'approved') bg-green-100 text-green-800
                        @elseif($logbook->status === 'submitted') bg-yellow-100 text-yellow-800
                        @elseif($logbook->status === 'rejected') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        @if($logbook->status === 'submitted')
                            Pending Review
                        @elseif($logbook->status === 'rejected')
                            Changes Requested
                        @else
                            {{ ucfirst($logbook->status) }}
                        @endif
                    </span>
                </div>
            </div>

            <!-- Logbook Content -->
            <div class="px-4 py-5 sm:p-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Week Period</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $logbook->week_start->format('F d, Y') }} - {{ $logbook->week_end->format('F d, Y') }}
                        </dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Activities Performed</dt>
                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap bg-gray-50 rounded-md p-4">{{ $logbook->activities }}</dd>
                    </div>

                    @if($logbook->learnings)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Key Learnings</dt>
                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap bg-gray-50 rounded-md p-4">{{ $logbook->learnings }}</dd>
                    </div>
                    @endif

                    @if($logbook->challenges)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Challenges Faced</dt>
                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap bg-gray-50 rounded-md p-4">{{ $logbook->challenges }}</dd>
                    </div>
                    @endif

                    @if($logbook->next_week_plans)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Plans for Next Week</dt>
                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap bg-gray-50 rounded-md p-4">{{ $logbook->next_week_plans }}</dd>
                    </div>
                    @endif

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Hours Worked</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $logbook->hours_worked ?? 'Not specified' }} hours</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Submitted On</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $logbook->created_at->format('F d, Y \a\t h:i A') }}</dd>
                    </div>
                </dl>

                @if($logbook->supervisor_feedback)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Your Previous Feedback</h3>
                    <p class="mt-2 text-sm text-gray-700 bg-gray-50 rounded-md p-4">{{ $logbook->supervisor_feedback }}</p>
                </div>
                @endif
            </div>

            <!-- Review Form -->
            @if($logbook->status === 'submitted')
            <div class="px-4 py-5 sm:p-6 border-t border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Review This Logbook</h3>

                <form action="{{ route('supervisor.logbooks.review', $logbook) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="supervisor_feedback" class="block text-sm font-medium text-gray-700">Feedback (Optional for approval, required for requesting changes)</label>
                        <textarea id="supervisor_feedback" name="supervisor_feedback" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter your feedback for the student...">{{ old('supervisor_feedback') }}</textarea>
                        @error('supervisor_feedback')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" name="action" value="approve" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Approve
                        </button>
                        <button type="submit" name="action" value="request_changes" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            Request Changes
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
