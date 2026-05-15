<x-app-layout>
    @section('title', 'Review Application')

    <div class="space-y-6">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <a href="{{ route('coordinator.applications.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 flex items-center mb-2">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Back to Applications
                </a>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl">Review Application</h2>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <span class="inline-flex items-center rounded-full px-4 py-2 text-sm font-medium
                    {{ $application->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                    {{ $application->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ ucfirst($application->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Student Info -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Student Information</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center mb-4">
                        <img class="h-16 w-16 rounded-full" src="{{ $application->student->profile_photo_url }}" alt="">
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">{{ $application->student->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $application->student->email }}</p>
                        </div>
                    </div>
                    <dl class="space-y-3">
                        @if($application->student->student_id)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Student ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $application->student->student_id }}</dd>
                            </div>
                        @endif
                        @if($application->student->department)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Department</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $application->student->department }}</dd>
                            </div>
                        @endif
                        @if($application->student->phone)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $application->student->phone }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Internship Info -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Internship Details</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-lg font-medium text-gray-900">{{ $application->internship->title }}</h4>
                    <p class="text-sm text-gray-500">{{ $application->internship->company->name }}</p>
                    <dl class="mt-4 space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Type</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst($application->internship->type ?? 'full-time') }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Duration</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $application->internship->duration ?? 12 }} weeks</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $application->internship->start_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Positions Available</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $application->internship->positions ?? $application->internship->slots }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Action Panel -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Action</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    @if($application->status === 'pending')
                        <!-- Approve Form -->
                        <form action="{{ route('coordinator.applications.approve', $application) }}" method="POST" class="mb-6">
                            @csrf
                            <div class="mb-4">
                                <label for="supervisor_id" class="block text-sm font-medium text-gray-700">Assign Supervisor</label>
                                <select name="supervisor_id" id="supervisor_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Select Supervisor</option>
                                    @foreach($supervisors as $supervisor)
                                        <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                    @endforeach
                                </select>
                                @error('supervisor_id')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <button type="submit" class="w-full inline-flex justify-center items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500">
                                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Approve Application
                            </button>
                        </form>

                        <div class="relative">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="bg-white px-2 text-sm text-gray-500">or</span>
                            </div>
                        </div>

                        <!-- Reject Form -->
                        <form action="{{ route('coordinator.applications.reject', $application) }}" method="POST" class="mt-6">
                            @csrf
                            <div class="mb-4">
                                <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                                <textarea name="rejection_reason" id="rejection_reason" rows="3" required placeholder="Please provide a reason for rejection..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                @error('rejection_reason')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <button type="submit" class="w-full inline-flex justify-center items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Reject Application
                            </button>
                        </form>
                    @else
                        <div class="text-center">
                            <div class="h-12 w-12 mx-auto rounded-full {{ $application->status === 'approved' ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center">
                                @if($application->status === 'approved')
                                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                            <h3 class="mt-3 text-lg font-medium text-gray-900">
                                Application {{ ucfirst($application->status) }}
                            </h3>
                            @if($application->reviewer)
                                <p class="mt-1 text-sm text-gray-500">
                                    By {{ $application->reviewer->name }} on {{ $application->reviewed_at?->format('M d, Y') }}
                                </p>
                            @endif
                            @if($application->remarks)
                                <div class="mt-4 p-3 bg-gray-50 rounded-md text-left">
                                    <p class="text-sm font-medium text-gray-700">Remarks:</p>
                                    <p class="mt-1 text-sm text-gray-600">{{ $application->remarks }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Application Timeline -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Application Timeline</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                            <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                        <div>
                                            <p class="text-sm text-gray-900">Application Submitted</p>
                                        </div>
                                        <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                            {{ $application->created_at->format('M d, Y \a\t g:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        @if($application->status !== 'pending')
                            <li>
                                <div class="relative">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full {{ $application->status === 'approved' ? 'bg-green-500' : 'bg-red-500' }} flex items-center justify-center ring-8 ring-white">
                                                @if($application->status === 'approved')
                                                    <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                @else
                                                    <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-900">Application {{ ucfirst($application->status) }}</p>
                                                @if($application->reviewer)
                                                    <p class="text-xs text-gray-500">By {{ $application->reviewer->name }}</p>
                                                @endif
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                {{ $application->reviewed_at?->format('M d, Y \a\t g:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
