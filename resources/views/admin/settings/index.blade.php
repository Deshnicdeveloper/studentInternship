<x-app-layout>
    @section('title', 'System Settings')
    <div class="max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">System Settings</h2>
        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                <div><label class="block text-sm font-medium text-gray-700">System Name</label><input type="text" name="system_name" value="{{ $settings['system_name'] ?? 'SIMS' }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700">Contact Email</label><input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700">Academic Year</label><input type="text" name="academic_year" value="{{ $settings['academic_year'] ?? '2024-2025' }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                <div class="flex justify-end"><button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Save Settings</button></div>
            </form>
        </div>
    </div>
</x-app-layout>
