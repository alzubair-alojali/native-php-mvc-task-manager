<?php
$title = 'My Profile - Web Final Project';
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">My Profile</h1>
    <p class="mt-2 text-sm text-slate-600">
        Manage your account information.
    </p>
</div>

<!-- Profile Card -->
<div class="mx-auto max-w-lg">
    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-900/5">
        <!-- Avatar Section -->
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name'] ?? 'User') ?>&background=6366f1&color=fff&size=80"
                alt="<?= htmlspecialchars($user['name'] ?? 'User') ?>"
                class="h-20 w-20 rounded-full ring-4 ring-white shadow-lg">
            <div>
                <p class="text-xl font-semibold text-slate-900"><?= htmlspecialchars($user['name']) ?></p>
                <p class="text-sm text-slate-500"><?= htmlspecialchars($user['email']) ?></p>
                <?php if (!empty($user['role'])): ?>
                    <span
                        class="mt-2 inline-flex items-center rounded-full bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-primary-700">
                        <?= ucfirst($user['role']) ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <form action="/web_final_project/public/profile/update" method="POST" class="space-y-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($old['name'] ?? $user['name']) ?>"
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset <?= isset($errors['name']) ? 'ring-red-500' : 'ring-slate-300' ?> focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all"
                    required>
                <?php if (isset($errors['name'])): ?>
                    <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['name']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email"
                    value="<?= htmlspecialchars($old['email'] ?? $user['email']) ?>"
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset <?= isset($errors['email']) ? 'ring-red-500' : 'ring-slate-300' ?> focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all"
                    required>
                <?php if (isset($errors['email'])): ?>
                    <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['email']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Password Section -->
            <div class="pt-6 border-t border-slate-100">
                <h3 class="text-sm font-semibold text-slate-900 mb-4">Change Password</h3>

                <div class="space-y-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                            New Password
                        </label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset <?= isset($errors['password']) ? 'ring-red-500' : 'ring-slate-300' ?> focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all">
                        <?php if (isset($errors['password'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['password']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="password_confirm" class="block text-sm font-medium text-slate-700 mb-2">
                            Confirm New Password
                        </label>
                        <input type="password" name="password_confirm" id="password_confirm" placeholder="••••••••"
                            class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset <?= isset($errors['password_confirm']) ? 'ring-red-500' : 'ring-slate-300' ?> focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all">
                        <?php if (isset($errors['password_confirm'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['password_confirm']) ?></p>
                        <?php endif; ?>
                    </div>

                    <p class="text-xs text-slate-500">
                        Leave password fields blank to keep your current password.
                    </p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-100">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-primary-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 transition-all">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
