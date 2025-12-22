<?php
$title = 'Edit Member - Web Final Project';
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <a href="/web_final_project/public/users"
        class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900 transition-colors mb-4">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Back to Team
    </a>
    <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">Edit Member</h1>
    <p class="mt-2 text-sm text-slate-600">
        Update team member information.
    </p>
</div>

<!-- Form Card -->
<div class="mx-auto max-w-lg">
    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-900/5">
        <!-- User Avatar Preview -->
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name'] ?? 'User') ?>&background=6366f1&color=fff&size=64"
                alt="<?= htmlspecialchars($user['name'] ?? 'User') ?>"
                class="h-16 w-16 rounded-full ring-4 ring-white shadow-lg">
            <div>
                <p class="text-lg font-semibold text-slate-900"><?= htmlspecialchars($user['name']) ?></p>
                <p class="text-sm text-slate-500"><?= htmlspecialchars($user['email']) ?></p>
            </div>
        </div>

        <form action="/web_final_project/public/users/edit" method="POST" class="space-y-6">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($old['name'] ?? $user['name']) ?>"
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset <?= isset($errors['name']) ? 'ring-red-500 focus:ring-red-500' : 'ring-slate-300 focus:ring-primary-500' ?> placeholder:text-slate-400 focus:ring-2 focus:ring-inset transition-all duration-150"
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
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset <?= isset($errors['email']) ? 'ring-red-500 focus:ring-red-500' : 'ring-slate-300 focus:ring-primary-500' ?> placeholder:text-slate-400 focus:ring-2 focus:ring-inset transition-all duration-150"
                    required>
                <?php if (isset($errors['email'])): ?>
                    <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['email']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                    New Password
                </label>
                <input type="password" name="password" id="password" placeholder="••••••••"
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset <?= isset($errors['password']) ? 'ring-red-500 focus:ring-red-500' : 'ring-slate-300 focus:ring-primary-500' ?> placeholder:text-slate-400 focus:ring-2 focus:ring-inset transition-all duration-150">
                <p class="mt-2 text-xs text-slate-500">
                    <svg class="inline h-3.5 w-3.5 text-slate-400 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    Leave blank to keep current password
                </p>
                <?php if (isset($errors['password'])): ?>
                    <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['password']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-slate-700 mb-2">
                    Role
                </label>
                <?php $currentRole = $old['role'] ?? $user['role'] ?? 'employee'; ?>
                <select name="role" id="role"
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all duration-150">
                    <option value="employee" <?= $currentRole === 'employee' ? 'selected' : '' ?>>Employee</option>
                    <option value="manager" <?= $currentRole === 'manager' ? 'selected' : '' ?>>Manager</option>
                </select>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-100">
                <a href="/web_final_project/public/users"
                    class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-slate-900 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-all duration-150">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Update Member
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
