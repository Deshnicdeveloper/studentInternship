<x-app-layout>
    @section('title', 'Company Details')

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <div class="flex items-center">
                    <img class="h-16 w-16 rounded-lg object-cover" src="{{ $company->logo_url }}" alt="{{ $company->name }}">
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">{{ $company->name }}</h2>
                        <div class="flex items-center gap-2 mt-1">
                            @if($company->industry)
                                <span class="text-sm text-gray-500">{{ $company->industry }}</span>
                            @endif
                            @if($company->is_active)
                                <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex gap-2 md:ml-4 md:mt-0">
                <a href="{{ route('admin.companies.index') }}" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Back</a>
                <a href="{{ route('admin.companies.edit', $company) }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Edit</a>
            </div>
        </div>

        <!-- Company Info -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Company Information</h3>
            </div>
            <div class="px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $company->address ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Website</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($company->website)
                                <a href="{{ $company->website }}" target="_blank" class="text-indigo-600 hover:text-indigo-500">{{ $company->website }}</a>
                            @else
                                -
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Contact Person</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $company->contact_person ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Contact Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $company->contact_email ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Contact Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $company->contact_phone ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Added On</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $company->created_at->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Internships -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Internships ({{ $company->internships->count() }})</h3>
                <a href="{{ route('admin.internships.create', ['company_id' => $company->id]) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Add Internship</a>
            </div>
            @if($company->internships->isEmpty())
                <div class="px-4 py-8 text-center text-sm text-gray-500">
                    No internships found for this company.
                </div>
            @else
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($company->internships as $internship)
                        <li class="px-4 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $internship->title }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $internship->start_date->format('M d, Y') }} - {{ $internship->end_date->format('M d, Y') }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        Slots: {{ $internship->placements_count ?? 0 }}/{{ $internship->slots }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($internship->is_active)
                                        <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Active</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-800">Inactive</span>
                                    @endif
                                    <a href="{{ route('admin.internships.edit', $internship) }}" class="text-indigo-600 hover:text-indigo-500 text-sm">Edit</a>
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
                <h3 class="text-lg font-medium text-gray-900">Placed Students ({{ $company->placements->count() }})</h3>
            </div>
            @if($company->placements->isEmpty())
                <div class="px-4 py-8 text-center text-sm text-gray-500">
                    No students have been placed at this company yet.
                </div>
            @else
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($company->placements as $placement)
                        <li class="px-4 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full" src="{{ $placement->student->profile_photo_url }}" alt="">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $placement->student->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $placement->internship->title }}</p>
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
