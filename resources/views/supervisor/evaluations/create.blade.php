@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('supervisor.students.show', $placement) }}" class="text-indigo-600 hover:text-indigo-900">&larr; Back to Student Details</a>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900">Submit Evaluation</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Evaluate {{ $placement->student->name }} at {{ $placement->internship->company->name }}
                </p>
            </div>

            <form action="{{ route('supervisor.evaluations.store', $placement) }}" method="POST" class="px-4 py-5 sm:p-6 space-y-6">
                @csrf

                <!-- Evaluation Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Evaluation Type</label>
                    <select id="type" name="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select type...</option>
                        <option value="midterm" {{ in_array('midterm', $existingEvaluations) ? 'disabled' : '' }}>
                            Midterm Evaluation {{ in_array('midterm', $existingEvaluations) ? '(Already submitted)' : '' }}
                        </option>
                        <option value="final" {{ in_array('final', $existingEvaluations) ? 'disabled' : '' }}>
                            Final Evaluation {{ in_array('final', $existingEvaluations) ? '(Already submitted)' : '' }}
                        </option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Scoring Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Performance Scores</h3>
                    <p class="text-sm text-gray-500 mb-6">Rate each criterion from 0-20 (Total: 100 points)</p>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Technical Skills -->
                        <div>
                            <label for="technical_skills" class="block text-sm font-medium text-gray-700">
                                Technical Skills
                                <span class="text-gray-400 font-normal">(0-20)</span>
                            </label>
                            <input type="number" name="technical_skills" id="technical_skills" min="0" max="20" required value="{{ old('technical_skills') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <p class="mt-1 text-xs text-gray-500">Knowledge and application of technical skills</p>
                            @error('technical_skills')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Communication -->
                        <div>
                            <label for="communication" class="block text-sm font-medium text-gray-700">
                                Communication
                                <span class="text-gray-400 font-normal">(0-20)</span>
                            </label>
                            <input type="number" name="communication" id="communication" min="0" max="20" required value="{{ old('communication') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <p class="mt-1 text-xs text-gray-500">Written and verbal communication abilities</p>
                            @error('communication')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teamwork -->
                        <div>
                            <label for="teamwork" class="block text-sm font-medium text-gray-700">
                                Teamwork
                                <span class="text-gray-400 font-normal">(0-20)</span>
                            </label>
                            <input type="number" name="teamwork" id="teamwork" min="0" max="20" required value="{{ old('teamwork') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <p class="mt-1 text-xs text-gray-500">Ability to work with others</p>
                            @error('teamwork')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Punctuality -->
                        <div>
                            <label for="punctuality" class="block text-sm font-medium text-gray-700">
                                Punctuality
                                <span class="text-gray-400 font-normal">(0-20)</span>
                            </label>
                            <input type="number" name="punctuality" id="punctuality" min="0" max="20" required value="{{ old('punctuality') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <p class="mt-1 text-xs text-gray-500">Timeliness and attendance</p>
                            @error('punctuality')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Initiative -->
                        <div class="sm:col-span-2">
                            <label for="initiative" class="block text-sm font-medium text-gray-700">
                                Initiative
                                <span class="text-gray-400 font-normal">(0-20)</span>
                            </label>
                            <input type="number" name="initiative" id="initiative" min="0" max="20" required value="{{ old('initiative') }}" class="mt-1 block w-full sm:w-1/2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <p class="mt-1 text-xs text-gray-500">Self-motivation and willingness to take on tasks</p>
                            @error('initiative')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Score Calculator -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Total Score:</span>
                            <span id="totalScore" class="text-2xl font-bold text-indigo-600">0/100</span>
                        </div>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Grade:</span>
                            <span id="calculatedGrade" class="text-lg font-semibold">-</span>
                        </div>
                    </div>
                </div>

                <!-- Qualitative Feedback -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Qualitative Feedback</h3>

                    <div class="space-y-6">
                        <div>
                            <label for="strengths" class="block text-sm font-medium text-gray-700">Strengths</label>
                            <textarea id="strengths" name="strengths" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="What are the student's key strengths?">{{ old('strengths') }}</textarea>
                        </div>

                        <div>
                            <label for="areas_for_improvement" class="block text-sm font-medium text-gray-700">Areas for Improvement</label>
                            <textarea id="areas_for_improvement" name="areas_for_improvement" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="What areas need improvement?">{{ old('areas_for_improvement') }}</textarea>
                        </div>

                        <div>
                            <label for="comments" class="block text-sm font-medium text-gray-700">Additional Comments</label>
                            <textarea id="comments" name="comments" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Any other comments or recommendations...">{{ old('comments') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-5 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('supervisor.students.show', $placement) }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Submit Evaluation
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fields = ['technical_skills', 'communication', 'teamwork', 'punctuality', 'initiative'];
    const totalScoreEl = document.getElementById('totalScore');
    const gradeEl = document.getElementById('calculatedGrade');

    function calculateTotal() {
        let total = 0;
        fields.forEach(field => {
            const value = parseInt(document.getElementById(field).value) || 0;
            total += value;
        });

        totalScoreEl.textContent = total + '/100';

        let grade = '-';
        let gradeColor = 'text-gray-600';
        if (total >= 90) { grade = 'A'; gradeColor = 'text-green-600'; }
        else if (total >= 80) { grade = 'B'; gradeColor = 'text-blue-600'; }
        else if (total >= 70) { grade = 'C'; gradeColor = 'text-yellow-600'; }
        else if (total >= 60) { grade = 'D'; gradeColor = 'text-orange-600'; }
        else if (total > 0) { grade = 'F'; gradeColor = 'text-red-600'; }

        gradeEl.textContent = grade;
        gradeEl.className = 'text-lg font-semibold ' + gradeColor;
    }

    fields.forEach(field => {
        document.getElementById(field).addEventListener('input', calculateTotal);
    });
});
</script>
@endsection
