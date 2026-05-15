<x-app-layout>
    @section('title', 'Internship Details')

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <div class="flex items-center">
                    <img class="h-12 w-12 rounded-lg object-cover" src="{{ $internship->company->logo_url }}" alt="{{ $internship->company->name }}">
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">{{ $internship->title }}</h2>
                        <div class="flex items-center gap-2 mt-1">
                            <a href="{{ route('admin.companies.show', $internship->company) }}" class="text-sm text-indigo-600 hover:text-indigo-500">{{ $internship->company->name }}</a>
                            @if($internship->is_active)
                                <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex gap-2 md:ml-4 md:mt-0">
                <a href="{{ route('admin.internships.index') }}" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Back</a>
                <a href="{{ route('admin.internships.edit', $internship) }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Edit</a>
            </div>
        </div>

        <!-- Internship Info -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Internship Information</h3>
            </div>
            <div class="px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $internship->description ?? 'No description provided.' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Duration</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $internship->start_date->format('M d, Y') }} - {{ $internship->end_date->format('M d, Y') }}
                            <span class="text-gray-500">({{ $internship->start_date->diffInWeeks($internship->end_date) }} weeks)</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Slots</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $internship->placements->where('status', 'active')->count() }}/{{ $internship->slots }} filled
                            @if($internship->available_slots > 0)
                                <span class="text-green-600">({{ $internship->available_slots }} available)</span>
                            @else
                                <span class="text-red-600">(Full)</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Applications</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $internship->applications->count() }} total</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created On</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $internship->created_at->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Applications -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Applications ({{ $internship->applications->count() }})</h3>
            </div>
            @if($internship->applications->isEmpty())
                <div class="px-4 py-8 text-center text-sm text-gray-500">
                    No applications received for this internship yet.
                </div>
            @else
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($internship->applications as $application)
                        <li class="px-4 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full" src="{{ $application->student->profile_photo_url }}" alt="">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            <a href="{{ route('admin.users.show', $application->student) }}" class="hover:text-indigo-600">
                                                {{ $application->student->name }}
                                            </a>
                                        </p>
                                        <p class="text-sm text-gray-500">{{ $application->student->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-gray-500">{{ $application->applied_at->format('M d, Y') }}</span>
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

        <!-- Placed Students -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Placed Students ({{ $internship->placements->count() }})</h3>
            </div>
            @if($internship->placements->isEmpty())
                <div class="px-4 py-8 text-center text-sm text-gray-500">
                    No students have been placed in this internship yet.
                </div>
            @else
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($internship->placements as $placement)
                        <li class="px-4 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full" src="{{ $placement->student->profile_photo_url }}" alt="">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            <a href="{{ route('admin.users.show', $placement->student) }}" class="hover:text-indigo-600">
                                                {{ $placement->student->name }}
                                            </a>
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $placement->start_date->format('M d, Y') }} - {{ $placement->end_date->format('M d, Y') }}
                                        </p>
                                    </div>
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
    </div>
</x-app-layout>
