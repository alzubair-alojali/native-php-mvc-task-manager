<?php
$title = 'Web Final Project - University Project Management';

// Guest guard: If logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: /dashboard");
    exit;
}

ob_start();
?>

<!-- Clean White Header -->
<header class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                </div>
                <span class="text-lg font-bold text-slate-900">Web Final Project</span>
            </div>

            <!-- Nav Links -->
            <div class="flex items-center gap-3">
                <a href="/login"
                    class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors px-4 py-2">
                    Sign In
                </a>
                <a href="/register"
                    class="inline-flex items-center rounded-full bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-all">
                    Get Started
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Hero Section -->
<section class="relative pt-32 pb-20 sm:pt-40 sm:pb-28 overflow-hidden bg-white">
    <!-- Background Pattern -->
    <div class="absolute inset-0 -z-10">
        <svg class="absolute right-0 top-0 h-[600px] w-[600px] -translate-y-1/4 translate-x-1/4 text-indigo-100 opacity-50"
            fill="currentColor" viewBox="0 0 200 200">
            <circle cx="100" cy="100" r="100" />
        </svg>
        <svg class="absolute left-0 bottom-0 h-[400px] w-[400px] translate-y-1/4 -translate-x-1/4 text-slate-100"
            fill="currentColor" viewBox="0 0 200 200">
            <circle cx="100" cy="100" r="100" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-4xl mx-auto">
            <!-- Badge -->
            <div
                class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-4 py-1.5 text-sm font-medium text-indigo-700 mb-8">
                <span class="flex h-2 w-2 rounded-full bg-indigo-500 animate-pulse"></span>
                For University Students & Teams
            </div>

            <!-- Main Headline -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Manage Your University Projects with
                <span class="text-indigo-600"> Web Final Project</span>
            </h1>

            <!-- Subheadline -->
            <p class="mt-6 text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
                The simplest way to organize tasks, collaborate with teams, and hit your deadlines.
                Built for students, by students.
            </p>

            <!-- CTA Buttons -->
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/register"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-full bg-indigo-600 px-8 py-4 text-base font-semibold text-white shadow-lg hover:bg-indigo-500 hover:shadow-xl transition-all duration-300">
                    Get Started Free
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
                <a href="/login"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-full bg-white px-8 py-4 text-base font-semibold text-indigo-600 ring-1 ring-indigo-200 hover:ring-indigo-300 hover:bg-indigo-50 transition-all duration-300">
                    Sign In
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Dashboard Preview Placeholder -->
        <div class="mt-20 relative">
            <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent z-10"></div>
            <div class="rounded-2xl bg-slate-900 p-2 shadow-2xl ring-1 ring-slate-800">
                <div class="rounded-xl bg-slate-800 p-4 sm:p-6">
                    <!-- Mock Dashboard Header -->
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-3 w-3 rounded-full bg-red-500"></div>
                        <div class="h-3 w-3 rounded-full bg-yellow-500"></div>
                        <div class="h-3 w-3 rounded-full bg-green-500"></div>
                        <div class="flex-1 h-6 rounded bg-slate-700"></div>
                    </div>
                    <!-- Mock Content -->
                    <div class="grid grid-cols-4 gap-4">
                        <div class="col-span-1 space-y-3">
                            <div class="h-8 rounded bg-slate-700"></div>
                            <div class="h-4 w-3/4 rounded bg-slate-700"></div>
                            <div class="h-4 w-1/2 rounded bg-slate-700"></div>
                        </div>
                        <div class="col-span-3 grid grid-cols-3 gap-4">
                            <div class="h-24 rounded-lg bg-indigo-600/20 border border-indigo-500/30"></div>
                            <div class="h-24 rounded-lg bg-emerald-600/20 border border-emerald-500/30"></div>
                            <div class="h-24 rounded-lg bg-amber-600/20 border border-amber-500/30"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-slate-900">Everything you need to succeed</h2>
            <p class="mt-4 text-lg text-slate-600">Simple tools that make project management effortless.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg transition-shadow">
                <div class="h-12 w-12 rounded-xl bg-indigo-100 flex items-center justify-center mb-6">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-3">Task Tracking</h3>
                <p class="text-slate-600">Create, assign, and track tasks with priorities and due dates. Never miss a
                    deadline again.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg transition-shadow">
                <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center mb-6">
                    <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-3">Team Collaboration</h3>
                <p class="text-slate-600">Invite teammates, assign roles, and work together seamlessly on group
                    projects.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg transition-shadow">
                <div class="h-12 w-12 rounded-xl bg-amber-100 flex items-center justify-center mb-6">
                    <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-3">Progress Tracking</h3>
                <p class="text-slate-600">Monitor project progress with visual dashboards and real-time updates.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-indigo-600">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-6">Ready to ace your projects?</h2>
        <p class="text-lg text-indigo-100 mb-10">Join students already using Web Final Project.</p>
        <a href="/register"
            class="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-base font-semibold text-indigo-600 shadow-lg hover:bg-indigo-50 transition-all">
            Start Free Today
        </a>
    </div>
</section>

<!-- Footer -->
<footer class="bg-white border-t border-slate-200 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="h-8 w-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                </div>
                <span class="font-semibold text-slate-900">Web Final Project</span>
            </div>
            <p class="text-sm text-slate-500">&copy; <?= date('Y') ?> Web Final Project. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php
$content = ob_get_clean();
include __DIR__ . '/layouts/guest.php';
?>
