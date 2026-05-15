@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('supervisor.evaluations.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Back to Evaluations</a>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">{{ ucfirst($evaluation->type) }} Evaluation</h1>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $evaluation->placement->student->name }} | {{ $evaluation->placement->internship->company->name }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 inline-flex text-lg font-bold rounded-full
                            @if($evaluation->grade === 'A') bg-green-100 text-green-800
                            @elseif($evaluation->grade === 'B') bg-blue-100 text-blue-800
                            @elseif($evaluation->grade === 'C') bg-yellow-100 text-yellow-800
                            @elseif($evaluation->grade === 'D') bg-orange-100 text-orange-800
                            @else bg-red-100 text-red-800 @endif">
                            Grade: {{ $evaluation->grade }}
                        </span>
                        <p class="mt-2 text-sm text-gray-500">Score: {{ $evaluation->total_score }}/100</p>
                    </div>
                </div>
            </div>

            <div class="px-4 py-5 sm:p-6">
                <!-- Score Breakdown -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Score Breakdown</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-5">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-sm font-medium text-gray-500">Technical Skills</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $evaluation->technical_skills }}/20</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-sm font-medium text-gray-500">Communication</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $evaluation->communication }}/20</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-sm font-medium text-gray-500">Teamwork</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $evaluation->teamwork }}/20</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-sm font-medium text-gray-500">Punctuality</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $evaluation->punctuality }}/20</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-sm font-medium text-gray-500">Initiative</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $evaluation->initiative }}/20</p>
                        </div>
                    </div>
                </div>

                <!-- Qualitative Feedback -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Qualitative Feedback</h3>

                    <dl class="space-y-6">
                        @if($evaluation->strengths)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Strengths</dt>
                            <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap bg-green-50 rounded-md p-4">{{ $evaluation->strengths }}</dd>
                        </div>
                        @endif

                        @if($evaluation->areas_for_improvement)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Areas for Improvement</dt>
                            <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap bg-yellow-50 rounded-md p-4">{{ $evaluation->areas_for_improvement }}</dd>
                        </div>
                        @endif

                        @if($evaluation->comments)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Additional Comments</dt>
                            <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap bg-gray-50 rounded-md p-4">{{ $evaluation->comments }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <!-- Metadata -->
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Submitted On</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->created_at->format('F d, Y \a\t h:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Evaluation Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($evaluation->type) }} Evaluation</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
