<?php
$title = 'Create Account - Web Final Project';

// Guest guard: If logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: /web_final_project/public/dashboard");
    exit;
}

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

ob_start();
?>

<div class="min-h-screen flex">
    <!-- Left Side - Branding -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-emerald-500 to-teal-600 relative overflow-hidden">
        <!-- Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="dots" width="5" height="5" patternUnits="userSpaceOnUse">
                        <circle cx="2.5" cy="2.5" r="1" fill="white" />
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#dots)" />
            </svg>
        </div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col justify-center px-12 lg:px-16 text-white">
            <!-- Logo -->
            <div class="flex items-center gap-3 mb-16">
                <div class="h-12 w-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                    <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                </div>
                <span class="text-2xl font-bold">Web Final Project</span>
            </div>

            <!-- Welcome Message -->
            <h1 class="text-4xl font-bold leading-tight mb-6">
                Start your journey to better project management.
            </h1>
            <p class="text-xl text-white/80 leading-relaxed">
                Join thousands of students who organize their university work with Web Final Project.
            </p>

            <!-- Benefits -->
            <div class="mt-12 space-y-4">
                <div class="flex items-center gap-3 text-white/90">
                    <div class="h-8 w-8 rounded-full bg-white/20 flex items-center justify-center">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <span>Free forever for students</span>
                </div>
                <div class="flex items-center gap-3 text-white/90">
                    <div class="h-8 w-8 rounded-full bg-white/20 flex items-center justify-center">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <span>Set up in under 2 minutes</span>
                </div>
                <div class="flex items-center gap-3 text-white/90">
                    <div class="h-8 w-8 rounded-full bg-white/20 flex items-center justify-center">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <span>No credit card required</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 bg-white">
        <div class="w-full max-w-md">
            <!-- Mobile Logo -->
            <div class="lg:hidden text-center mb-10">
                <a href="/web_final_project/public/" class="inline-flex items-center gap-2">
                    <div class="h-10 w-10 rounded-lg bg-emerald-600 flex items-center justify-center">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-slate-900">Web Final Project</span>
                </a>
            </div>

            <!-- Form Header -->
            <div class="mb-10">
                <h2 class="text-3xl font-bold text-slate-900">Create your account</h2>
                <p class="mt-2 text-slate-600">
                    Already have an account?
                    <a href="/web_final_project/public/login"
                        class="font-semibold text-indigo-600 hover:text-indigo-500">Sign in</a>
                </p>
            </div>

            <form action="/web_final_project/public/register" method="POST" class="space-y-5">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">
                        Full Name
                    </label>
                    <input type="text" name="name" id="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                        placeholder="John Doe"
                        class="block w-full rounded-xl border-0 bg-slate-50 px-4 py-4 text-slate-900 ring-1 ring-inset <?= isset($errors['name']) ? 'ring-red-300 focus:ring-red-500' : 'ring-slate-200 focus:ring-indigo-500' ?> placeholder:text-slate-400 focus:bg-white focus:ring-2 transition-all text-base"
                        required>
                    <?php if (isset($errors['name'])): ?>
                        <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['name']) ?></p>
                    <?php endif; ?>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">
                        Email Address
                    </label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                        placeholder="you@university.edu"
                        class="block w-full rounded-xl border-0 bg-slate-50 px-4 py-4 text-slate-900 ring-1 ring-inset <?= isset($errors['email']) ? 'ring-red-300 focus:ring-red-500' : 'ring-slate-200 focus:ring-indigo-500' ?> placeholder:text-slate-400 focus:bg-white focus:ring-2 transition-all text-base"
                        required>
                    <?php if (isset($errors['email'])): ?>
                        <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['email']) ?></p>
                    <?php endif; ?>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">
                        Password
                    </label>
                    <input type="password" name="password" id="password" placeholder="••••••••"
                        class="block w-full rounded-xl border-0 bg-slate-50 px-4 py-4 text-slate-900 ring-1 ring-inset <?= isset($errors['password']) ? 'ring-red-300 focus:ring-red-500' : 'ring-slate-200 focus:ring-indigo-500' ?> placeholder:text-slate-400 focus:bg-white focus:ring-2 transition-all text-base"
                        required>
                    <p class="mt-2 text-xs text-slate-500">Must be at least 6 characters</p>
                    <?php if (isset($errors['password'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?= htmlspecialchars($errors['password']) ?></p>
                    <?php endif; ?>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-4 text-base font-semibold text-white shadow-lg shadow-indigo-500/30 hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all">
                    Create Account
                </button>
            </form>

            <!-- Terms -->
            <p class="mt-6 text-center text-xs text-slate-500">
                By signing up, you agree to our
                <a href="#" class="text-indigo-600 hover:underline">Terms</a> and
                <a href="#" class="text-indigo-600 hover:underline">Privacy Policy</a>
            </p>

            <!-- Back to Home -->
            <p class="mt-8 text-center">
                <a href="/web_final_project/public/"
                    class="text-sm font-medium text-slate-500 hover:text-indigo-600 inline-flex items-center gap-1 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Back to Home
                </a>
            </p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/guest.php';
?>
