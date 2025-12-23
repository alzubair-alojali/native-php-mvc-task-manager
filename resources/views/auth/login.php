<?php
$title = 'Sign In - Web Final Project';

// Guest guard: If logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: /dashboard");
    exit;
}

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

ob_start();
?>

<div class="min-h-screen flex">
    <!-- Left Side - Branding -->
    <div class="hidden lg:flex lg:w-1/2 bg-indigo-600 relative overflow-hidden">
        <!-- Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5" />
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#grid)" />
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

            <!-- Quote -->
            <blockquote class="text-3xl font-light leading-relaxed mb-8">
                "The best way to predict your future is to create it."
            </blockquote>
            <p class="text-white/70 text-lg">— Abraham Lincoln</p>

            <!-- Features -->
            <div class="mt-16 space-y-4">
                <div class="flex items-center gap-3 text-white/80">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    <span>Track your university projects</span>
                </div>
                <div class="flex items-center gap-3 text-white/80">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    <span>Collaborate with teammates</span>
                </div>
                <div class="flex items-center gap-3 text-white/80">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    <span>Never miss a deadline</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 bg-white">
        <div class="w-full max-w-md">
            <!-- Mobile Logo -->
            <div class="lg:hidden text-center mb-10">
                <a href="/" class="inline-flex items-center gap-2">
                    <div class="h-10 w-10 rounded-lg bg-indigo-600 flex items-center justify-center">
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
                <h2 class="text-3xl font-bold text-slate-900">Welcome back</h2>
                <p class="mt-2 text-slate-600">
                    Don't have an account?
                    <a href="/register"
                        class="font-semibold text-indigo-600 hover:text-indigo-500">Sign up</a>
                </p>
            </div>

            <!-- Error Message -->
            <?php if (isset($errors['login'])): ?>
                <div class="mb-6 rounded-xl bg-red-50 p-4 border border-red-100">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm font-medium text-red-800"><?= htmlspecialchars($errors['login']) ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <form action="/login" method="POST" class="space-y-6">
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
                    <?php if (isset($errors['password'])): ?>
                        <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['password']) ?></p>
                    <?php endif; ?>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-4 text-base font-semibold text-white shadow-lg shadow-indigo-500/30 hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all">
                    Sign In
                </button>
            </form>

            <!-- Back to Home -->
            <p class="mt-10 text-center">
                <a href="/"
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
