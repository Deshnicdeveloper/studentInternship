<x-app-layout>
    @section('title', 'Supervisor Dashboard')

    @php
        $supervisorId = auth()->id();
        $assignedStudents = \App\Models\Placement::with(['student', 'internship.company'])
            ->where('supervisor_id', $supervisorId)
            ->where('status', 'active')
            ->get();
        $pendingLogbooks = \App\Models\Logbook::whereHas('placement', function($q) use ($supervisorId) {
            $q->where('supervisor_id', $supervisorId);
        })->where('status', 'submitted')->count();
        $pendingEvaluations = $assignedStudents->filter(function($placement) {
            return !$placement->hasMidtermEvaluation() || !$placement->hasFinalEvaluation();
        })->count();
    @endphp

    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Assigned Students -->
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Assigned Students</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-blue-600">
                    {{ $assignedStudents->count() }}
                </dd>
            </div>

            <!-- Pending Logbook Reviews -->
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Pending Logbook Reviews</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-amber-600">
                    {{ $pendingLogbooks }}
                </dd>
            </div>

            <!-- Evaluations Pending -->
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Evaluations Pending</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-purple-600">
                    {{ $pendingEvaluations }}
                </dd>
            </div>
        </div>

        <!-- Assigned Students List -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Assigned Students</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Students currently under your supervision.</p>
            </div>
            <div class="border-t border-gray-200">
                @if($assignedStudents->isEmpty())
                    <div class="px-4 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No students assigned</h3>
                        <p class="mt-1 text-sm text-gray-500">You don't have any students assigned to you yet.</p>
                    </div>
                @else
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($assignedStudents as $placement)
                            <li class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img class="h-12 w-12 rounded-full" src="{{ $placement->student->profile_photo_url }}" alt="">
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $placement->student->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $placement->internship->title }} at {{ $placement->internship->company->name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800">
                                            {{ ucfirst($placement->status) }}
                                        </span>
                                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View Details</a>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $placement->start_date->format('M d, Y') }} - {{ $placement->end_date->format('M d, Y') }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
