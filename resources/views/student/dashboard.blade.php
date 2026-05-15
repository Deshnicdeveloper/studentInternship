<x-app-layout>
    @section('title', 'Student Dashboard')

    @php
        $student = auth()->user();
        $pendingApplication = $student->pendingApplication();
        $activePlacement = $student->activePlacement();
        $latestApplication = $student->applications()->latest()->first();
    @endphp

    <div class="space-y-6">
        <!-- Application Status Card -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:p-6">
                @if($activePlacement)
                    <!-- Has Active Placement -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Active Placement</h3>
                            <p class="text-sm text-gray-500">You are currently placed at <strong>{{ $activePlacement->internship->company->name }}</strong></p>
                        </div>
                    </div>
                    <div class="mt-4 border-t border-gray-200 pt-4">
                        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Position</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $activePlacement->internship->title }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Supervisor</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $activePlacement->supervisor?->name ?? 'Not assigned' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $activePlacement->start_date->format('M d, Y') }} - {{ $activePlacement->end_date->format('M d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                @elseif($pendingApplication)
                    <!-- Has Pending Application -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-amber-100">
                                <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Application Pending</h3>
                            <p class="text-sm text-gray-500">Your application is under review for <strong>{{ $pendingApplication->internship->title }}</strong> at {{ $pendingApplication->internship->company->name }}</p>
                        </div>
                    </div>
                @elseif($latestApplication && $latestApplication->status === 'rejected')
                    <!-- Application Rejected -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Application Rejected</h3>
                            <p class="text-sm text-gray-500">Your previous application was not approved. You can apply for another internship.</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('student.internships.index') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                            Browse Internships
                        </a>
                    </div>
                @else
                    <!-- No Application -->
                    <div class="text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No internship application</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by browsing available internships.</p>
                        <div class="mt-6">
                            <a href="{{ route('student.internships.index') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Browse Internships
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($activePlacement)
            <!-- Logbook Progress -->
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900">Logbook Progress</h3>
                    <div class="mt-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Weekly submissions</span>
                            <span class="font-medium text-gray-900">{{ $activePlacement->logbooks()->whereIn('status', ['submitted', 'reviewed'])->count() }} / {{ $activePlacement->duration_in_weeks }} weeks</span>
                        </div>
                        <div class="mt-2">
                            <div class="overflow-hidden rounded-full bg-gray-200">
                                <div class="h-2 rounded-full bg-indigo-600" style="width: {{ $activePlacement->logbook_completion_percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('student.logbook.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            View Logbook &rarr;
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recent Notifications -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Notifications</h3>
            </div>
            <div class="border-t border-gray-200">
                @if($student->notifications->isEmpty())
                    <div class="px-4 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No notifications</h3>
                        <p class="mt-1 text-sm text-gray-500">You're all caught up!</p>
                    </div>
                @else
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($student->notifications->take(5) as $notification)
                            <li class="px-4 py-4 {{ $notification->read_at ? '' : 'bg-indigo-50' }}">
                                <p class="text-sm text-gray-900">{{ $notification->data['message'] ?? 'New notification' }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
