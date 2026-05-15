<x-app-layout>
    @section('title', $internship->title)

    <div class="space-y-6">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <a href="{{ route('student.internships.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 flex items-center mb-2">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Back to Internships
                </a>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl">{{ $internship->title }}</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Company Info -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="h-16 w-16 rounded-lg bg-indigo-100 flex items-center justify-center">
                                <span class="text-2xl font-bold text-indigo-600">{{ substr($internship->company->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-gray-900">{{ $internship->company->name }}</h3>
                                @if($internship->company->website)
                                    <a href="{{ $internship->company->website }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-500">Visit Website</a>
                                @endif
                            </div>
                        </div>
                        @if($internship->company->description)
                            <p class="mt-4 text-sm text-gray-600">{{ $internship->company->description }}</p>
                        @endif
                    </div>
                </div>

                <!-- Job Description -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Description</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div class="prose prose-sm max-w-none text-gray-600">
                            {!! nl2br(e($internship->description)) !!}
                        </div>
                    </div>
                </div>

                <!-- Requirements -->
                @if($internship->requirements)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Requirements</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="prose prose-sm max-w-none text-gray-600">
                                {!! nl2br(e($internship->requirements)) !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Benefits -->
                @if($internship->benefits)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Benefits</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="prose prose-sm max-w-none text-gray-600">
                                {!! nl2br(e($internship->benefits)) !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Apply Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="p-6">
                        @if($hasApplied)
                            <div class="text-center">
                                <div class="h-12 w-12 mx-auto rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="mt-3 text-lg font-medium text-gray-900">Already Applied</h3>
                                <p class="mt-1 text-sm text-gray-500">You have already submitted an application for this internship.</p>
                                <a href="{{ route('student.application') }}" class="mt-4 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    View Application Status →
                                </a>
                            </div>
                        @elseif($hasActiveApplication)
                            <div class="text-center">
                                <div class="h-12 w-12 mx-auto rounded-full bg-amber-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <h3 class="mt-3 text-lg font-medium text-gray-900">Active Application Exists</h3>
                                <p class="mt-1 text-sm text-gray-500">You already have a pending or approved application. Please wait for it to be processed.</p>
                            </div>
                        @elseif($internship->application_deadline->isPast())
                            <div class="text-center">
                                <div class="h-12 w-12 mx-auto rounded-full bg-red-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="mt-3 text-lg font-medium text-gray-900">Application Closed</h3>
                                <p class="mt-1 text-sm text-gray-500">The application deadline has passed for this internship.</p>
                            </div>
                        @else
                            <form action="{{ route('student.internships.apply', $internship) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full inline-flex justify-center items-center rounded-md bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                    </svg>
                                    Apply Now
                                </button>
                            </form>
                            <p class="mt-3 text-xs text-center text-gray-500">By applying, you agree to share your profile information with the company.</p>
                        @endif
                    </div>
                </div>

                <!-- Details Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Details</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Type</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $internship->type === 'full-time' ? 'bg-green-100 text-green-800' : ($internship->type === 'part-time' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                                        {{ ucfirst($internship->type) }}
                                    </span>
                                </dd>
                            </div>
                            @if($internship->location)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Location</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $internship->location }}</dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $internship->duration }} weeks</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Positions Available</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $internship->positions }}</dd>
                            </div>
                            @if($internship->stipend)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Stipend</dt>
                                    <dd class="mt-1 text-sm text-gray-900">${{ number_format($internship->stipend) }}/month</dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Application Deadline</dt>
                                <dd class="mt-1 text-sm {{ $internship->application_deadline->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $internship->application_deadline->format('F d, Y') }}
                                    @if(!$internship->application_deadline->isPast())
                                        <span class="text-gray-500">({{ $internship->application_deadline->diffForHumans() }})</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $internship->start_date->format('F d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Contact Info -->
                @if($internship->company->contact_email || $internship->company->contact_phone)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Contact</h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <dl class="space-y-4">
                                @if($internship->company->contact_email)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                                        <dd class="mt-1 text-sm text-indigo-600">
                                            <a href="mailto:{{ $internship->company->contact_email }}">{{ $internship->company->contact_email }}</a>
                                        </dd>
                                    </div>
                                @endif
                                @if($internship->company->contact_phone)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $internship->company->contact_phone }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
