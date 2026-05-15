<x-app-layout>
    @section('title', 'Evaluation Details')

    <div class="space-y-6">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <a href="{{ route('coordinator.evaluations.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 flex items-center mb-2">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Back to Evaluations
                </a>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl">{{ ucfirst($evaluation->type) }} Evaluation</h2>
                <p class="mt-1 text-sm text-gray-500">Submitted on {{ $evaluation->created_at->format('F d, Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Score Overview -->
            <div class="lg:col-span-3">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="p-6">
                        <div class="flex flex-col items-center justify-center sm:flex-row sm:justify-between">
                            <div class="flex items-center mb-4 sm:mb-0">
                                <div class="h-20 w-20 rounded-full {{ $evaluation->total_score >= 70 ? 'bg-green-100' : 'bg-amber-100' }} flex items-center justify-center">
                                    <span class="text-3xl font-bold {{ $evaluation->total_score >= 70 ? 'text-green-600' : 'text-amber-600' }}">
                                        {{ $evaluation->total_score }}%
                                    </span>
                                </div>
                                <div class="ml-6">
                                    <p class="text-sm text-gray-500">{{ ucfirst($evaluation->type) }} Evaluation</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        Grade: {{ $evaluation->grade ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-center sm:text-right">
                                <div class="flex items-center mb-2">
                                    <img class="h-10 w-10 rounded-full" src="{{ $evaluation->placement->student->profile_photo_url }}" alt="">
                                    <div class="ml-3 text-left">
                                        <p class="text-sm font-medium text-gray-900">{{ $evaluation->placement->student->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $evaluation->placement->internship->company->name }}</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500">Evaluated by {{ $evaluation->evaluator->name ?? 'Unknown' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Score Breakdown -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Score Breakdown</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div class="space-y-4">
                            @if($evaluation->technical_skills !== null)
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Technical Skills</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $evaluation->technical_skills }}/20</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ ($evaluation->technical_skills / 20) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endif

                            @if($evaluation->communication !== null)
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Communication</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $evaluation->communication }}/20</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ ($evaluation->communication / 20) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endif

                            @if($evaluation->teamwork !== null)
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Teamwork</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $evaluation->teamwork }}/20</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ ($evaluation->teamwork / 20) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endif

                            @if($evaluation->punctuality !== null)
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Punctuality & Attendance</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $evaluation->punctuality }}/20</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ ($evaluation->punctuality / 20) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endif

                            @if($evaluation->initiative !== null)
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Initiative</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $evaluation->initiative }}/20</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ ($evaluation->initiative / 20) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Comments -->
                @if($evaluation->strengths)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Strengths</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="prose prose-sm max-w-none text-gray-600">
                                {!! nl2br(e($evaluation->strengths)) !!}
                            </div>
                        </div>
                    </div>
                @endif

                @if($evaluation->areas_for_improvement)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Areas for Improvement</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="prose prose-sm max-w-none text-gray-600">
                                {!! nl2br(e($evaluation->areas_for_improvement)) !!}
                            </div>
                        </div>
                    </div>
                @endif

                @if($evaluation->comments)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Additional Comments</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="prose prose-sm max-w-none text-gray-600">
                                {!! nl2br(e($evaluation->comments)) !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Evaluation Details</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Type</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $evaluation->type === 'midterm' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($evaluation->type) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Evaluated By</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->evaluator->name ?? 'Unknown' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Submitted On</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->created_at->format('F d, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Final Score</dt>
                                <dd class="mt-1 text-2xl font-bold {{ $evaluation->total_score >= 70 ? 'text-green-600' : 'text-amber-600' }}">
                                    {{ $evaluation->total_score }}%
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Actions</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <a href="{{ route('coordinator.placements.show', $evaluation->placement) }}" class="w-full inline-flex justify-center items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                            View Placement
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
