<x-app-layout>
    @section('title', 'Admin Dashboard')

    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-100">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="truncate text-sm font-medium text-gray-500">Total Students</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $stats['total_students'] }}</dd>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="truncate text-sm font-medium text-gray-500">Total Companies</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $stats['total_companies'] }}</dd>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-amber-100">
                            <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="truncate text-sm font-medium text-gray-500">Total Internships</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $stats['total_internships'] }}</dd>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <dt class="truncate text-sm font-medium text-gray-500">Active Placements</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $stats['active_placements'] }}</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <a href="{{ route('admin.users.create') }}" class="relative block rounded-lg border border-gray-300 bg-white p-6 shadow-sm hover:border-indigo-500 hover:ring-1 hover:ring-indigo-500">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Add New User</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.companies.create') }}" class="relative block rounded-lg border border-gray-300 bg-white p-6 shadow-sm hover:border-indigo-500 hover:ring-1 hover:ring-indigo-500">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-600">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Add Company</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.internships.create') }}" class="relative block rounded-lg border border-gray-300 bg-white p-6 shadow-sm hover:border-indigo-500 hover:ring-1 hover:ring-indigo-500">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-600">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Add Internship</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="relative block rounded-lg border border-gray-300 bg-white p-6 shadow-sm hover:border-indigo-500 hover:ring-1 hover:ring-indigo-500">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-600">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Settings</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Applications -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Applications</h3>
                    <p class="mt-1 text-sm text-gray-500">Latest internship applications.</p>
                </div>
            </div>
            <div class="border-t border-gray-200">
                @if($recentApplications->isEmpty())
                    <div class="px-4 py-12 text-center">
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No applications yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Applications will appear here once students start applying.</p>
                    </div>
                @else
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($recentApplications as $application)
                            <li class="px-4 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center min-w-0">
                                        <img class="h-10 w-10 rounded-full" src="{{ $application->student->profile_photo_url }}" alt="">
                                        <div class="ml-4 truncate">
                                            <p class="truncate text-sm font-medium text-gray-900">{{ $application->student->name }}</p>
                                            <p class="truncate text-sm text-gray-500">{{ $application->internship->title }}</p>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        @if($application->status === 'pending')
                                            <span class="inline-flex rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-800">Pending</span>
                                        @elseif($application->status === 'approved')
                                            <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Approved</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Rejected</span>
                                        @endif
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
