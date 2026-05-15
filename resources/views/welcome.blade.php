<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SIMS') }} - Student Internship Management</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white/95 backdrop-blur-sm z-50 border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-gray-900">SIMS</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-sm text-gray-600 hover:text-gray-900 transition">Features</a>
                    <a href="#how-it-works" class="text-sm text-gray-600 hover:text-gray-900 transition">How it works</a>
                    <a href="#roles" class="text-sm text-gray-600 hover:text-gray-900 transition">User roles</a>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">Sign in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">Get started</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-sm text-gray-600 mb-6">
                <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>
                Trusted by universities nationwide
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                Streamline your internship program management
            </h1>
            <p class="text-lg text-gray-600 mb-10 max-w-2xl mx-auto">
                A complete platform for students, coordinators, and supervisors to manage internship applications, track progress, and evaluate performance.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition font-medium">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition font-medium">
                        Sign in to continue
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-8 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                            Create an account
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900">500+</div>
                    <div class="text-sm text-gray-600 mt-1">Students placed</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900">50+</div>
                    <div class="text-sm text-gray-600 mt-1">Partner companies</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900">98%</div>
                    <div class="text-sm text-gray-600 mt-1">Completion rate</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900">4.8/5</div>
                    <div class="text-sm text-gray-600 mt-1">User satisfaction</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Everything you need to manage internships</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">From application to evaluation, SIMS provides all the tools to run a successful internship program.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 rounded-xl border border-gray-200 hover:border-gray-300 transition">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Application Management</h3>
                    <p class="text-gray-600 text-sm">Students can browse and apply for internships. Coordinators review and approve applications with ease.</p>
                </div>
                <div class="p-6 rounded-xl border border-gray-200 hover:border-gray-300 transition">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Weekly Logbooks</h3>
                    <p class="text-gray-600 text-sm">Students document their learning journey with weekly entries. Supervisors provide timely feedback.</p>
                </div>
                <div class="p-6 rounded-xl border border-gray-200 hover:border-gray-300 transition">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Performance Evaluation</h3>
                    <p class="text-gray-600 text-sm">Comprehensive evaluation system with midterm and final assessments. Generate detailed PDF reports.</p>
                </div>
                <div class="p-6 rounded-xl border border-gray-200 hover:border-gray-300 transition">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Real-time Notifications</h3>
                    <p class="text-gray-600 text-sm">Stay informed with instant notifications for application updates, logbook reviews, and evaluations.</p>
                </div>
                <div class="p-6 rounded-xl border border-gray-200 hover:border-gray-300 transition">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Company Management</h3>
                    <p class="text-gray-600 text-sm">Maintain a database of partner companies and their available internship positions.</p>
                </div>
                <div class="p-6 rounded-xl border border-gray-200 hover:border-gray-300 transition">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Reports & Analytics</h3>
                    <p class="text-gray-600 text-sm">Generate PDF reports and export data to CSV for comprehensive program analysis.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works Section -->
    <section id="how-it-works" class="py-20 bg-gray-50 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">How it works</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">A simple, streamlined process from application to completion.</p>
            </div>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-12 h-12 bg-gray-900 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-lg font-semibold">1</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Apply</h3>
                    <p class="text-sm text-gray-600">Students browse available internships and submit applications.</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-gray-900 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-lg font-semibold">2</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Get Approved</h3>
                    <p class="text-sm text-gray-600">Coordinators review applications and assign supervisors.</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-gray-900 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-lg font-semibold">3</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Document Progress</h3>
                    <p class="text-sm text-gray-600">Students submit weekly logbooks and receive feedback.</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-gray-900 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-lg font-semibold">4</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Get Evaluated</h3>
                    <p class="text-sm text-gray-600">Supervisors submit evaluations and final grades are assigned.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- User Roles Section -->
    <section id="roles" class="py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Designed for everyone</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Each user role has a tailored experience with the right tools for their needs.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl border border-gray-200">
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Students</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>Browse internships</li>
                        <li>Submit applications</li>
                        <li>Write weekly logbooks</li>
                        <li>View evaluations</li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200">
                    <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Coordinators</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>Review applications</li>
                        <li>Assign supervisors</li>
                        <li>Monitor progress</li>
                        <li>Generate reports</li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200">
                    <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Supervisors</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>View assigned students</li>
                        <li>Review logbooks</li>
                        <li>Provide feedback</li>
                        <li>Submit evaluations</li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200">
                    <div class="w-10 h-10 bg-rose-50 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Administrators</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>Manage users</li>
                        <li>Manage companies</li>
                        <li>Configure internships</li>
                        <li>System settings</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gray-900 px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to get started?</h2>
            <p class="text-gray-400 mb-8">Sign in to access your dashboard or create an account to begin.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-white text-gray-900 rounded-lg hover:bg-gray-100 transition font-medium">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-white text-gray-900 rounded-lg hover:bg-gray-100 transition font-medium">
                        Sign in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-8 py-3 border border-gray-600 text-white rounded-lg hover:bg-gray-800 transition font-medium">
                            Create account
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-gray-200 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <span class="text-lg font-bold text-gray-900">SIMS</span>
                    <p class="text-sm text-gray-500 mt-1">Student Internship Management System</p>
                </div>
                <div class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} SIMS. All rights reserved.
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
