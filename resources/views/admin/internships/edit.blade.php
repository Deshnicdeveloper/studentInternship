<x-app-layout>
    @section('title', 'Edit Internship')
    <div class="max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Internship</h2>
        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.internships.update', $internship) }}" method="POST" class="space-y-6">
                @csrf @method('PUT')
                <div><label class="block text-sm font-medium text-gray-700">Company</label><select name="company_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">@foreach($companies as $company)<option value="{{ $company->id }}" {{ $internship->company_id == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>@endforeach</select></div>
                <div><label class="block text-sm font-medium text-gray-700">Title</label><input type="text" name="title" value="{{ $internship->title }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700">Description</label><textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $internship->description }}</textarea></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700">Start Date</label><input type="date" name="start_date" value="{{ $internship->start_date->format('Y-m-d') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                    <div><label class="block text-sm font-medium text-gray-700">End Date</label><input type="date" name="end_date" value="{{ $internship->end_date->format('Y-m-d') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                </div>
                <div><label class="block text-sm font-medium text-gray-700">Slots</label><input type="number" name="slots" min="1" value="{{ $internship->slots }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                <div class="flex justify-end"><button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Update Internship</button></div>
            </form>
        </div>
    </div>
</x-app-layout>
