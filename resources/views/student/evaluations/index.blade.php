<x-app-layout>
    @section('title', 'My Evaluations')

    <div class="space-y-6">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl">My Evaluations</h2>
                <p class="mt-1 text-sm text-gray-500">View your midterm and final evaluation scores</p>
            </div>
        </div>

        @if($placement)
            <!-- Summary Stats -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                    <dt class="truncate text-sm font-medium text-gray-500">Total Evaluations</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $evaluations->count() }}</dd>
                </div>
                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                    <dt class="truncate text-sm font-medium text-gray-500">Average Score</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-indigo-600">
                        @if($evaluations->count() > 0)
                            {{ number_format($evaluations->avg('total_score'), 1) }}%
                        @else
                            N/A
                        @endif
                    </dd>
                </div>
                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                    <dt class="truncate text-sm font-medium text-gray-500">Latest Grade</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight
                        @if($evaluations->first()?->total_score >= 80) text-green-600
                        @elseif($evaluations->first()?->total_score >= 60) text-amber-600
                        @else text-red-600 @endif">
                        @if($evaluations->count() > 0)
                            {{ $evaluations->first()->grade ?? 'Pending' }}
                        @else
                            N/A
                        @endif
                    </dd>
                </div>
            </div>

            <!-- Evaluations List -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Evaluation History</h3>
                </div>
                @if($evaluations->count() > 0)
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($evaluations as $evaluation)
                            <li class="hover:bg-gray-50">
                                <a href="{{ route('student.evaluations.show', $evaluation) }}" class="block px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="h-12 w-12 rounded-full {{ $evaluation->type === 'midterm' ? 'bg-blue-100' : 'bg-green-100' }} flex items-center justify-center">
                                                    <svg class="h-6 w-6 {{ $evaluation->type === 'midterm' ? 'text-blue-600' : 'text-green-600' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-900">{{ ucfirst($evaluation->type) }} Evaluation</p>
                                                <p class="text-sm text-gray-500">By {{ $evaluation->evaluator->name ?? 'Unknown' }}</p>
                                                <p class="text-xs text-gray-400">{{ $evaluation->created_at->format('F d, Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-6">
                                            <div class="text-right">
                                                <p class="text-2xl font-bold {{ $evaluation->total_score >= 80 ? 'text-green-600' : ($evaluation->total_score >= 60 ? 'text-amber-600' : 'text-red-600') }}">
                                                    {{ $evaluation->total_score }}%
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    Grade: <span class="font-medium">{{ $evaluation->grade ?? 'Pending' }}</span>
                                                </p>
                                            </div>
                                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="px-4 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No evaluations yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Your evaluations will appear here after your supervisor or coordinator completes them.</p>
                    </div>
                @endif
            </div>
        @else
            <!-- No Placement -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No active placement</h3>
                    <p class="mt-1 text-sm text-gray-500">You need to have an active internship placement to view evaluations.</p>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
