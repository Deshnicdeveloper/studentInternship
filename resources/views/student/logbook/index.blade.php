<x-app-layout>
    @section('title', 'My Logbook')

    <div class="space-y-6">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl">My Logbook</h2>
                <p class="mt-1 text-sm text-gray-500">Record your weekly internship activities and progress</p>
            </div>
            @if($placement)
                <div class="mt-4 flex md:ml-4 md:mt-0">
                    <a href="{{ route('student.logbook.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        New Entry
                    </a>
                </div>
            @endif
        </div>

        @if($placement)
            <!-- Progress Stats -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                    <dt class="truncate text-sm font-medium text-gray-500">Total Entries</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $entries->total() }}</dd>
                </div>
                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                    <dt class="truncate text-sm font-medium text-gray-500">Submitted</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-green-600">{{ $entries->where('status', 'submitted')->count() }}</dd>
                </div>
                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                    <dt class="truncate text-sm font-medium text-gray-500">Drafts</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-amber-600">{{ $entries->where('status', 'draft')->count() }}</dd>
                </div>
            </div>

            <!-- Logbook Entries -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Logbook Entries</h3>
                </div>
                @if($entries->count() > 0)
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($entries as $entry)
                            <li class="hover:bg-gray-50">
                                <a href="{{ route('student.logbook.show', $entry) }}" class="block px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full {{ $entry->status === 'submitted' ? 'bg-green-100' : 'bg-amber-100' }} flex items-center justify-center">
                                                    <span class="text-sm font-medium {{ $entry->status === 'submitted' ? 'text-green-600' : 'text-amber-600' }}">W{{ $entry->week_number }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-900">Week {{ $entry->week_number }}</p>
                                                <p class="text-sm text-gray-500">{{ $entry->week_start->format('M d') }} - {{ $entry->week_end->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $entry->status === 'submitted' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                                {{ ucfirst($entry->status) }}
                                            </span>
                                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    @if($entry->activities)
                                        <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ Str::limit($entry->activities, 150) }}</p>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    @if($entries->hasPages())
                        <div class="px-4 py-3 border-t border-gray-200">
                            {{ $entries->links() }}
                        </div>
                    @endif
                @else
                    <div class="px-4 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No logbook entries</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating your first weekly entry.</p>
                        <div class="mt-6">
                            <a href="{{ route('student.logbook.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Create First Entry
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <!-- No Placement -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No active placement</h3>
                    <p class="mt-1 text-sm text-gray-500">You need to have an active internship placement to create logbook entries.</p>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
