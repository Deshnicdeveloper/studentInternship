<x-app-layout>
    @section('title', 'Company Management')

    <div class="space-y-6">
        <!-- Header -->
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Companies</h2>
                <p class="mt-1 text-sm text-gray-500">Manage partner companies offering internship opportunities.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.companies.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add Company
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white shadow rounded-lg p-4">
            <form method="GET" action="{{ route('admin.companies.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Name, industry, or contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                    <select name="industry" id="industry" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Industries</option>
                        @foreach($industries as $industry)
                            <option value="{{ $industry }}" {{ request('industry') == $industry ? 'selected' : '' }}>{{ $industry }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Filter</button>
                    <a href="{{ route('admin.companies.index') }}" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Reset</a>
                </div>
            </form>
        </div>

        <!-- Companies Grid -->
        @if($companies->isEmpty())
            <div class="bg-white shadow rounded-lg px-4 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No companies found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by adding a new company.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($companies as $company)
                    <div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center">
                                <img class="h-12 w-12 rounded-lg object-cover" src="{{ $company->logo_url }}" alt="{{ $company->name }}">
                                <div class="ml-4 flex-1 min-w-0">
                                    <h3 class="text-lg font-medium text-gray-900 truncate">{{ $company->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $company->industry ?? 'No industry' }}</p>
                                </div>
                                @if($company->is_active)
                                    <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Active</span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Inactive</span>
                                @endif
                            </div>
                            <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Internships:</span>
                                    <span class="font-medium text-gray-900">{{ $company->internships_count }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Placements:</span>
                                    <span class="font-medium text-gray-900">{{ $company->placements_count }}</span>
                                </div>
                            </div>
                            @if($company->contact_person)
                                <div class="mt-4 text-sm">
                                    <p class="text-gray-500">Contact: <span class="text-gray-900">{{ $company->contact_person }}</span></p>
                                </div>
                            @endif
                        </div>
                        <div class="bg-gray-50 px-6 py-3 flex justify-between items-center">
                            <a href="{{ route('admin.companies.show', $company) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View Details</a>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.companies.edit', $company) }}" class="text-gray-600 hover:text-gray-900" title="Edit">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.companies.toggle-status', $company) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="{{ $company->is_active ? 'text-amber-600 hover:text-amber-900' : 'text-green-600 hover:text-green-900' }}" title="{{ $company->is_active ? 'Deactivate' : 'Activate' }}">
                                        @if($company->is_active)
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $companies->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
