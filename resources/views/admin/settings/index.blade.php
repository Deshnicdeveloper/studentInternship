<x-app-layout>
    @section('title', 'System Settings')

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">System Settings</h2>
                <p class="mt-1 text-sm text-gray-500">Configure system-wide settings for the internship management system.</p>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Settings Form -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.settings.update') }}" method="POST" class="divide-y divide-gray-200">
                @csrf

                <!-- General Settings -->
                <div class="p-6 space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">General Settings</h3>
                        <p class="mt-1 text-sm text-gray-500">Basic configuration for the system.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="system_name" class="block text-sm font-medium text-gray-700">System Name <span class="text-red-500">*</span></label>
                            <input type="text" name="system_name" id="system_name"
                                value="{{ old('system_name', $settings['system_name'] ?? 'Student Internship Management System') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('system_name') border-red-500 @enderror"
                                placeholder="Student Internship Management System">
                            @error('system_name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">This name will be displayed in the header and emails.</p>
                        </div>

                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700">Contact Email <span class="text-red-500">*</span></label>
                            <input type="email" name="contact_email" id="contact_email"
                                value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('contact_email') border-red-500 @enderror"
                                placeholder="admin@example.com">
                            @error('contact_email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Primary contact email for system notifications and support inquiries.</p>
                        </div>

                        <div>
                            <label for="academic_year" class="block text-sm font-medium text-gray-700">Academic Year <span class="text-red-500">*</span></label>
                            <input type="text" name="academic_year" id="academic_year"
                                value="{{ old('academic_year', $settings['academic_year'] ?? '') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('academic_year') border-red-500 @enderror"
                                placeholder="2024-2025">
                            @error('academic_year')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Current academic year for internship records.</p>
                        </div>
                    </div>
                </div>

                <!-- System Info (Read-only) -->
                <div class="p-6 space-y-6 bg-gray-50">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">System Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Current system statistics and information.</p>
                    </div>

                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-3">
                        <div class="bg-white rounded-lg px-4 py-3 shadow-sm">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Users</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ \App\Models\User::count() }}</dd>
                        </div>
                        <div class="bg-white rounded-lg px-4 py-3 shadow-sm">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Companies</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ \App\Models\Company::count() }}</dd>
                        </div>
                        <div class="bg-white rounded-lg px-4 py-3 shadow-sm">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Active Internships</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ \App\Models\Internship::active()->count() }}</dd>
                        </div>
                        <div class="bg-white rounded-lg px-4 py-3 shadow-sm">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Placements</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ \App\Models\Placement::count() }}</dd>
                        </div>
                        <div class="bg-white rounded-lg px-4 py-3 shadow-sm">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Pending Applications</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ \App\Models\Application::pending()->count() }}</dd>
                        </div>
                        <div class="bg-white rounded-lg px-4 py-3 shadow-sm">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Laravel Version</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ app()->version() }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Submit Button -->
                <div class="p-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Save Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="bg-white shadow rounded-lg border border-red-200">
            <div class="p-6">
                <h3 class="text-lg font-medium text-red-900">Danger Zone</h3>
                <p class="mt-1 text-sm text-gray-500">These actions are destructive and cannot be undone.</p>

                <div class="mt-6 space-y-4">
                    <div class="flex items-center justify-between py-3 border-t border-gray-200">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Clear Application Cache</h4>
                            <p class="text-sm text-gray-500">Clear all cached data including routes, config, and views.</p>
                        </div>
                        <form action="{{ route('admin.settings.update') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="action" value="clear_cache">
                            <button type="button" onclick="alert('Cache clearing will be implemented in a future update.')"
                                class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-red-600 shadow-sm ring-1 ring-inset ring-red-300 hover:bg-red-50">
                                Clear Cache
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
