<x-app-layout>
    @section('title', 'Admin Dashboard')

    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Students -->
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Total Students</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                    {{ \App\Models\User::role('student')->count() }}
                </dd>
            </div>

            <!-- Total Companies -->
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Total Companies</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                    {{ \App\Models\Company::count() }}
                </dd>
            </div>

            <!-- Total Internships -->
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Total Internships</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                    {{ \App\Models\Internship::count() }}
                </dd>
            </div>

            <!-- Active Placements -->
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Active Placements</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                    {{ \App\Models\Placement::where('status', 'active')->count() }}
                </dd>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Applications</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Latest 10 internship applications.</p>
            </div>
            <div class="border-t border-gray-200">
                @php
                    $recentApplications = \App\Models\Application::with(['student', 'internship.company'])
                        ->latest()
                        ->take(10)
                        ->get();
                @endphp

                @if($recentApplications->isEmpty())
                    <div class="px-4 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No applications yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Applications will appear here once students start applying.</p>
                    </div>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Internship</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Company</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Applied At</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($recentApplications as $application)
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $application->student->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        {{ $application->internship->title }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        {{ $application->internship->company->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        @if($application->status === 'pending')
                                            <span class="inline-flex rounded-full bg-amber-100 px-2 text-xs font-semibold leading-5 text-amber-800">Pending</span>
                                        @elseif($application->status === 'approved')
                                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Approved</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        {{ $application->applied_at->format('M d, Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Applications Chart Placeholder -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Applications per Month</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Monthly application statistics.</p>
            </div>
            <div class="border-t border-gray-200 p-6">
                <div id="applications-chart" class="h-64 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400">
                    <p>Chart will be implemented in Phase 2</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
