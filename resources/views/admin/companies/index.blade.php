<x-app-layout>
    @section('title', 'Manage Companies')
    <div class="space-y-6">
        <div class="md:flex md:items-center md:justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Companies</h2>
            <a href="{{ route('admin.companies.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white">Add Company</a>
        </div>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($companies as $company)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <img class="h-12 w-12 rounded-lg object-cover" src="{{ $company->logo_url }}" alt="">
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $company->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $company->city }}</p>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between text-sm">
                        <span>{{ $company->internships_count }} internships</span>
                        <a href="{{ route('admin.companies.edit', $company) }}" class="text-indigo-600">Edit</a>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center py-12 text-gray-500">No companies found.</p>
            @endforelse
        </div>
        @if($companies->hasPages())
            <div class="mt-6">{{ $companies->links() }}</div>
        @endif
    </div>
</x-app-layout>
