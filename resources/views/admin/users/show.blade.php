<x-app-layout>
    @section('title', 'User Details')

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">User Details</h2>
            </div>
            <div class="mt-4 flex gap-2 md:ml-4 md:mt-0">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                    Back
                </a>
                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        <!-- User Info Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                <div class="flex items-center">
                    <img class="h-16 w-16 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        <div class="mt-1 flex items-center gap-2">
                            @foreach($user->roles as $role)
                                @php
                                    $roleColors = [
                                        'admin' => 'bg-purple-100 text-purple-800',
                                        'coordinator' => 'bg-blue-100 text-blue-800',
                                        'supervisor' => 'bg-green-100 text-green-800',
                                        'student' => 'bg-amber-100 text-amber-800',
                                    ];
                                    $color = $roleColors[$role->name] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $color }}">
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                            @if($user->is_active)
                                <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    @if($user->student_id)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Student ID</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->student_id }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Department</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->department ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->phone ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Joined</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        @if($user->hasRole('student'))
            <!-- Applications -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Applications</h3>
                </div>
                @if($user->applications->isEmpty())
                    <div class="px-4 py-8 text-center text-sm text-gray-500">
                        No applications found.
                    </div>
                @else
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($user->applications as $application)
                            <li class="px-4 py-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $application->internship->title }}</p>
                                        <p class="text-sm text-gray-500">{{ $application->internship->company->name }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if($application->status === 'pending')
                                            <span class="inline-flex rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-800">Pending</span>
                                        @elseif($application->status === 'approved')
                                            <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Approved</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Rejected</span>
                                        @endif
                                        <span class="text-xs text-gray-500">{{ $application->applied_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Placements -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Placements</h3>
                </div>
                @if($user->placements->isEmpty())
                    <div class="px-4 py-8 text-center text-sm text-gray-500">
                        No placements found.
                    </div>
                @else
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($user->placements as $placement)
                            <li class="px-4 py-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $placement->internship->title }}</p>
                                        <p class="text-sm text-gray-500">{{ $placement->internship->company->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $placement->start_date->format('M d, Y') }} - {{ $placement->end_date->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        @if($placement->status === 'active')
                                            <span class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800">Active</span>
                                        @elseif($placement->status === 'completed')
                                            <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Completed</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Terminated</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>
