<x-app-layout>
    @section('title', 'Coordinator Dashboard')

    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Pending Applications -->
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Pending Applications</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-amber-600">
                    {{ \App\Models\Application::where('status', 'pending')->count() }}
                </dd>
            </div>

            <!-- Active Placements -->
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Active Placements</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-blue-600">
                    {{ \App\Models\Placement::where('status', 'active')->count() }}
                </dd>
            </div>

            <!-- Pending Logbook Reviews -->
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Pending Logbook Reviews</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-purple-600">
                    {{ \App\Models\Logbook::where('status', 'submitted')->count() }}
                </dd>
            </div>

            <!-- Evaluations Due -->
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Evaluations Due</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-green-600">
                    {{ \App\Models\Evaluation::count() }}
                </dd>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Applications Awaiting Review</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Quick action panel for pending applications.</p>
            </div>
            <div class="border-t border-gray-200">
                @php
                    $pendingApplications = \App\Models\Application::with(['student', 'internship.company'])
                        ->where('status', 'pending')
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp

                @if($pendingApplications->isEmpty())
                    <div class="px-4 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">All caught up!</h3>
                        <p class="mt-1 text-sm text-gray-500">No pending applications to review.</p>
                    </div>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Internship</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Applied At</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($pendingApplications as $application)
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full" src="{{ $application->student->profile_photo_url }}" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $application->student->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $application->student->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $application->internship->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $application->internship->company->name }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        {{ $application->applied_at->diffForHumans() }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Review</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Students with Overdue Logbooks -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Students with Overdue Logbooks</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Students who haven't submitted their weekly logbook.</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No overdue logbooks</h3>
                <p class="mt-1 text-sm text-gray-500">All students are up to date with their submissions.</p>
            </div>
        </div>
    </div>
</x-app-layout>
