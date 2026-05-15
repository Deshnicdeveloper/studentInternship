<x-app-layout>
    @section('title', 'Placement Details')

    <div class="space-y-6">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <a href="{{ route('coordinator.placements.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 flex items-center mb-2">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Back to Placements
                </a>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl">Placement Details</h2>
            </div>
            <div class="mt-4 flex items-center gap-4 md:ml-4 md:mt-0">
                <span class="inline-flex items-center rounded-full px-4 py-2 text-sm font-medium
                    {{ $placement->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $placement->status === 'completed' ? 'bg-gray-100 text-gray-800' : '' }}
                    {{ $placement->status === 'terminated' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ ucfirst($placement->status) }}
                </span>
                <a href="{{ route('coordinator.reports.pdf', $placement) }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Student & Company Info -->
            <div class="space-y-6">
                <!-- Student Info -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Student</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <img class="h-12 w-12 rounded-full" src="{{ $placement->student->profile_photo_url }}" alt="">
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">{{ $placement->student->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $placement->student->email }}</p>
                                <p class="text-xs text-gray-400">{{ $placement->student->student_id }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Info -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Company</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <h4 class="text-sm font-medium text-gray-900">{{ $placement->internship->company->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $placement->internship->title }}</p>
                        <dl class="mt-4 space-y-2">
                            <div>
                                <dt class="text-xs font-medium text-gray-500">Supervisor</dt>
                                <dd class="text-sm text-gray-900">{{ $placement->supervisor->name ?? 'Not assigned' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500">Period</dt>
                                <dd class="text-sm text-gray-900">{{ $placement->start_date->format('M d') }} - {{ $placement->end_date->format('M d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Grade Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Final Grade</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        @if($placement->coordinator_grade)
                            <div class="text-center">
                                <p class="text-4xl font-bold text-indigo-600">{{ $placement->coordinator_grade }}</p>
                                @if($placement->coordinator_comment)
                                    <p class="mt-2 text-sm text-gray-500">{{ $placement->coordinator_comment }}</p>
                                @endif
                            </div>
                        @else
                            <form action="{{ route('coordinator.placements.grade', $placement) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="coordinator_grade" class="block text-sm font-medium text-gray-700">Grade</label>
                                    <select name="coordinator_grade" id="coordinator_grade" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Select Grade</option>
                                        <option value="A">A (Excellent)</option>
                                        <option value="B">B (Good)</option>
                                        <option value="C">C (Satisfactory)</option>
                                        <option value="D">D (Needs Improvement)</option>
                                        <option value="F">F (Unsatisfactory)</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="coordinator_comment" class="block text-sm font-medium text-gray-700">Comment</label>
                                    <textarea name="coordinator_comment" id="coordinator_comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                </div>
                                <button type="submit" class="w-full inline-flex justify-center items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                    Submit Grade
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Status Actions -->
                @if($placement->status === 'active')
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Actions</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6 space-y-3">
                            <form action="{{ route('coordinator.placements.complete', $placement) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full inline-flex justify-center items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500">
                                    Mark as Completed
                                </button>
                            </form>
                            <form action="{{ route('coordinator.placements.terminate', $placement) }}" method="POST" x-data="{ showReason: false }">
                                @csrf
                                <div x-show="showReason" class="mb-3">
                                    <textarea name="reason" rows="2" placeholder="Reason for termination..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                </div>
                                <button type="button" x-show="!showReason" @click="showReason = true" class="w-full inline-flex justify-center items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                                    Terminate Placement
                                </button>
                                <button type="submit" x-show="showReason" class="w-full inline-flex justify-center items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                                    Confirm Termination
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Logbook History -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Logbook Submissions</h3>
                    </div>
                    @if($placement->logbooks->count() > 0)
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach($placement->logbooks as $logbook)
                                <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900">Week {{ $logbook->week_number }}</p>
                                            <p class="text-sm text-gray-500">{{ $logbook->week_start->format('M d') }} - {{ $logbook->week_end->format('M d, Y') }}</p>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                                {{ $logbook->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                                {{ $logbook->status === 'submitted' ? 'bg-amber-100 text-amber-800' : '' }}
                                                {{ $logbook->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $logbook->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($logbook->status) }}
                                            </span>
                                            <a href="{{ route('coordinator.logbooks.show', $logbook) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Review</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="px-4 py-8 text-center">
                            <p class="text-sm text-gray-500">No logbook entries yet.</p>
                        </div>
                    @endif
                </div>

                <!-- Evaluations -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Evaluations</h3>
                    </div>
                    @if($placement->evaluations->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($placement->evaluations as $evaluation)
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ ucfirst($evaluation->type) }} Evaluation</p>
                                            <p class="text-sm text-gray-500">By {{ $evaluation->evaluator->name ?? 'Unknown' }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold {{ $evaluation->total_score >= 70 ? 'text-green-600' : 'text-amber-600' }}">{{ $evaluation->total_score }}%</p>
                                            <a href="{{ route('coordinator.evaluations.show', $evaluation) }}" class="text-sm text-indigo-600 hover:text-indigo-900">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="px-4 py-8 text-center">
                            <p class="text-sm text-gray-500">No evaluations submitted yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
