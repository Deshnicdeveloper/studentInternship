<x-app-layout>
    @section('title', 'New Logbook Entry')

    <div class="space-y-6">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <a href="{{ route('student.logbook.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 flex items-center mb-2">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Back to Logbook
                </a>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl">New Logbook Entry</h2>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('student.logbook.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div>
                        <label for="week_number" class="block text-sm font-medium text-gray-700">Week Number</label>
                        <input type="number" name="week_number" id="week_number" value="{{ old('week_number') }}" min="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('week_number')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="week_start" class="block text-sm font-medium text-gray-700">Week Start Date</label>
                        <input type="date" name="week_start" id="week_start" value="{{ old('week_start') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('week_start')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="week_end" class="block text-sm font-medium text-gray-700">Week End Date</label>
                        <input type="date" name="week_end" id="week_end" value="{{ old('week_end') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('week_end')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="activities" class="block text-sm font-medium text-gray-700">Activities Performed</label>
                    <p class="mt-1 text-sm text-gray-500">Describe the tasks and activities you completed this week.</p>
                    <textarea name="activities" id="activities" rows="5" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('activities') }}</textarea>
                    @error('activities')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="learnings" class="block text-sm font-medium text-gray-700">Key Learnings</label>
                    <p class="mt-1 text-sm text-gray-500">What new skills or knowledge did you gain this week?</p>
                    <textarea name="learnings" id="learnings" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('learnings') }}</textarea>
                    @error('learnings')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="challenges" class="block text-sm font-medium text-gray-700">Challenges Faced</label>
                    <p class="mt-1 text-sm text-gray-500">Describe any difficulties you encountered and how you addressed them.</p>
                    <textarea name="challenges" id="challenges" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('challenges') }}</textarea>
                    @error('challenges')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="next_week_plan" class="block text-sm font-medium text-gray-700">Plan for Next Week</label>
                    <p class="mt-1 text-sm text-gray-500">What do you plan to work on next week?</p>
                    <textarea name="next_week_plan" id="next_week_plan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('next_week_plan') }}</textarea>
                    @error('next_week_plan')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <div class="flex items-center">
                        <input type="checkbox" name="submit_entry" id="submit_entry" value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="submit_entry" class="ml-2 block text-sm text-gray-700">Submit entry for review (cannot be edited after submission)</label>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('student.logbook.index') }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Save Entry</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
