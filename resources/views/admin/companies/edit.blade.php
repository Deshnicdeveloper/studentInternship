<x-app-layout>
    @section('title', 'Edit Company')
    <div class="max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Company</h2>
        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.companies.update', $company) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf @method('PUT')
                <div><label class="block text-sm font-medium text-gray-700">Name</label><input type="text" name="name" value="{{ $company->name }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700">City</label><input type="text" name="city" value="{{ $company->city }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700">Email</label><input type="email" name="email" value="{{ $company->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700">Phone</label><input type="text" name="phone" value="{{ $company->phone }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700">Address</label><textarea name="address" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $company->address }}</textarea></div>
                <div><label class="block text-sm font-medium text-gray-700">Description</label><textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $company->description }}</textarea></div>
                <div><label class="block text-sm font-medium text-gray-700">Logo</label><input type="file" name="logo" accept="image/*" class="mt-1 block w-full"></div>
                <div class="flex justify-end"><button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Update Company</button></div>
            </form>
        </div>
    </div>
</x-app-layout>
