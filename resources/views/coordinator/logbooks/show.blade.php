<x-app-layout>
    @section('title', 'Review Logbook')

    <div class="space-y-6">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <a href="{{ route('coordinator.logbooks.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 flex items-center mb-2">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Back to Logbooks
                </a>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl">Week {{ $logbook->week_number }} Logbook</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $logbook->week_start->format('F d') }} - {{ $logbook->week_end->format('F d, Y') }}</p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <span class="inline-flex items-center rounded-full px-4 py-2 text-sm font-medium
                    {{ $logbook->status === 'submitted' ? 'bg-amber-100 text-amber-800' : '' }}
                    {{ $logbook->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $logbook->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ $logbook->status === 'rejected' ? 'Flagged' : ucfirst($logbook->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Student Info -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Student</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <img class="h-12 w-12 rounded-full" src="{{ $logbook->student->profile_photo_url }}" alt="">
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">{{ $logbook->student->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $logbook->placement->internship->company->name }}</p>
                            <p class="text-xs text-gray-400">Supervisor: {{ $logbook->placement->supervisor->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logbook Content -->
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

                <!-- Supervisor Feedback -->
                @if($logbook->supervisor_feedback)
                    <div class="bg-blue-50 shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-blue-200">
                            <h3 class="text-lg font-medium leading-6 text-blue-900">Supervisor Feedback</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="prose prose-sm max-w-none text-blue-800">
                                {!! nl2br(e($logbook->supervisor_feedback)) !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Review Action -->
                @if($logbook->status === 'submitted')
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Review Action</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <form action="{{ route('coordinator.logbooks.review', $logbook) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="coordinator_comment" class="block text-sm font-medium text-gray-700">Comment (optional for approval, required for flagging)</label>
                                    <textarea name="coordinator_comment" id="coordinator_comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Add your feedback..."></textarea>
                                    @error('coordinator_comment')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                                </div>
                                <div class="flex gap-3">
                                    <button type="submit" name="action" value="approve" class="flex-1 inline-flex justify-center items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500">
                                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Approve
                                    </button>
                                    <button type="submit" name="action" value="flag" class="flex-1 inline-flex justify-center items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                                        </svg>
                                        Flag for Revision
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @elseif($logbook->coordinator_comment)
                    <div class="bg-gray-50 shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Coordinator Comment</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="prose prose-sm max-w-none text-gray-600">
                                {!! nl2br(e($logbook->coordinator_comment)) !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
