<x-app-layout>
    @section('title', 'Week ' . $logbook->week_number . ' - Logbook')

    <div class="space-y-6">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <a href="{{ route('student.logbook.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 flex items-center mb-2">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Back to Logbook
                </a>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl">Week {{ $logbook->week_number }}</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $logbook->week_start->format('F d') }} - {{ $logbook->week_end->format('F d, Y') }}</p>
            </div>
            <div class="mt-4 flex items-center gap-4 md:ml-4 md:mt-0">
                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium {{ $logbook->status === 'submitted' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                    {{ ucfirst($logbook->status) }}
                </span>
                @if($logbook->status === 'draft')
                    <a href="{{ route('student.logbook.edit', $logbook) }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        Edit
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Activities -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Activities Performed</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div class="prose prose-sm max-w-none text-gray-600">
                            {!! nl2br(e($logbook->activities)) !!}
                        </div>
                    </div>
                </div>

                <!-- Learnings -->
                @if($logbook->learnings)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Key Learnings</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="prose prose-sm max-w-none text-gray-600">
                                {!! nl2br(e($logbook->learnings)) !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Challenges -->
                @if($logbook->challenges)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Challenges Faced</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="prose prose-sm max-w-none text-gray-600">
                                {!! nl2br(e($logbook->challenges)) !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Next Week Plan -->
                @if($logbook->next_week_plan)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Plan for Next Week</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="prose prose-sm max-w-none text-gray-600">
                                {!! nl2br(e($logbook->next_week_plan)) !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Entry Info -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Entry Details</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $logbook->status === 'submitted' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ ucfirst($logbook->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Week Period</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $logbook->week_start->format('M d') }} - {{ $logbook->week_end->format('M d, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $logbook->created_at->format('M d, Y \a\t g:i A') }}</dd>
                            </div>
                            @if($logbook->status === 'submitted')
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Submitted</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $logbook->updated_at->format('M d, Y \a\t g:i A') }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Supervisor Feedback -->
                @if($logbook->supervisor_feedback)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Supervisor Feedback</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="prose prose-sm max-w-none text-gray-600">
                                {!! nl2br(e($logbook->supervisor_feedback)) !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Actions for Draft -->
                @if($logbook->status === 'draft')
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Actions</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6 space-y-3">
                            <form action="{{ route('student.logbook.update', $logbook) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="submit_entry" value="1">
                                <input type="hidden" name="week_number" value="{{ $logbook->week_number }}">
                                <input type="hidden" name="week_start" value="{{ $logbook->week_start->format('Y-m-d') }}">
                                <input type="hidden" name="week_end" value="{{ $logbook->week_end->format('Y-m-d') }}">
                                <input type="hidden" name="activities" value="{{ $logbook->activities }}">
                                <input type="hidden" name="learnings" value="{{ $logbook->learnings }}">
                                <input type="hidden" name="challenges" value="{{ $logbook->challenges }}">
                                <input type="hidden" name="next_week_plan" value="{{ $logbook->next_week_plan }}">
                                <button type="submit" class="w-full inline-flex justify-center items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500" onclick="return confirm('Are you sure you want to submit this entry? You will not be able to edit it after submission.');">
                                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                    </svg>
                                    Submit for Review
                                </button>
                            </form>
                            <p class="text-xs text-center text-gray-500">Once submitted, you cannot edit this entry.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
