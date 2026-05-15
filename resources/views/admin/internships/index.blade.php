<x-app-layout>
    @section('title', 'Manage Internships')
    <div class="space-y-6">
        <div class="md:flex md:items-center md:justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Internships</h2>
            <a href="{{ route('admin.internships.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white">Add Internship</a>
        </div>
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Internship</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slots</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($internships as $internship)
                        <tr>
                            <td class="px-6 py-4"><div class="text-sm font-medium text-gray-900">{{ $internship->title }}</div><div class="text-sm text-gray-500">{{ $internship->start_date->format('M d') }} - {{ $internship->end_date->format('M d, Y') }}</div></td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $internship->company->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $internship->placements_count ?? 0 }}/{{ $internship->slots }}</td>
                            <td class="px-6 py-4">@if($internship->is_active)<span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Active</span>@else<span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Inactive</span>@endif</td>
                            <td class="px-6 py-4 text-right text-sm"><a href="{{ route('admin.internships.edit', $internship) }}" class="text-indigo-600">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">No internships found.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($internships->hasPages())<div class="px-4 py-3 border-t">{{ $internships->links() }}</div>@endif
        </div>
    </div>
</x-app-layout>
