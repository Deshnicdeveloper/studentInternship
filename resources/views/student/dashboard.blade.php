<x-app-layout>
    @section('title', 'Student Dashboard')

    <div class="space-y-6">
        <!-- Status Card -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img class="h-16 w-16 rounded-full" src="{{ auth()->user()->profile_photo_url }}" alt="">
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-bold text-gray-900">Welcome, {{ auth()->user()->name }}!</h2>
                        <p class="text-sm text-gray-500">Student ID: {{ auth()->user()->student_id ?? 'Not set' }}</p>
                        <p class="text-sm text-gray-500">Department: {{ auth()->user()->department ?? 'Not set' }}</p>
                    </div>
                    <div class="ml-auto">
                        @if($placement)
                            <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-800">
                                <svg class="mr-1.5 h-4 w-4" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Currently Placed
                            </span>
                        @elseif($application && $application->status === 'pending')
                            <span class="inline-flex items-center rounded-full bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-800">
                                <svg class="mr-1.5 h-4 w-4" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Application Pending
                            </span>
                        @elseif($application && $application->status === 'approved')
                            <span class="inline-flex items-center rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-800">
                                <svg class="mr-1.5 h-4 w-4" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Application Approved
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-800">
                                <svg class="mr-1.5 h-4 w-4" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                No Active Application
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($placement)
            <!-- Placement Details -->
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Current Placement Details</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Company</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $placement->internship->company->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Position</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $placement->internship->title }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $placement->start_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">End Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $placement->end_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Supervisor</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $placement->supervisor->name ?? 'Not assigned' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Coordinator</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $placement->coordinator->name ?? 'Not assigned' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Logbook Progress -->
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Logbook Progress</h3>
                        <a href="{{ route('student.logbook.create') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Add Entry</a>
                    </div>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-3xl font-bold text-gray-900">{{ $logbookStats['submitted'] }} / {{ $logbookStats['total'] }}</p>
                            <p class="text-sm text-gray-500">Entries submitted</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-amber-600">{{ $logbookStats['draft'] }} drafts</p>
                            <p class="text-sm text-gray-500">pending submission</p>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        @php
                            $percentage = $logbookStats['total'] > 0 ? ($logbookStats['submitted'] / $logbookStats['total']) * 100 : 0;
                        @endphp
                        <div class="bg-indigo-600 h-3 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            </div>
        @elseif($application)
            <!-- Application Status -->
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Application Status</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            @if($application->status === 'pending')
                                <div class="h-12 w-12 rounded-full bg-amber-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @elseif($application->status === 'approved')
                                <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @else
                                <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">{{ $application->internship->title }}</h4>
                            <p class="text-sm text-gray-500">{{ $application->internship->company->name }}</p>
                            <p class="mt-1 text-sm">
                                Status:
                                <span class="{{ $application->status === 'pending' ? 'text-amber-600' : ($application->status === 'approved' ? 'text-green-600' : 'text-red-600') }} font-semibold">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="ml-auto">
                            <a href="{{ route('student.application') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View Details →</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- No Application - Call to Action -->
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="px-4 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No internship application</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by browsing available internships and submitting an application.</p>
                    <div class="mt-6">
                        <a href="{{ route('student.internships.index') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                            <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            Browse Internships
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recent Notifications -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Notifications</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($notifications as $notification)
                    <div class="px-4 py-4 {{ $notification->read_at ? 'bg-white' : 'bg-indigo-50' }}">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm text-gray-900">{{ $notification->data['message'] ?? 'Notification' }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-8 text-center">
                        <p class="text-sm text-gray-500">No notifications yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
