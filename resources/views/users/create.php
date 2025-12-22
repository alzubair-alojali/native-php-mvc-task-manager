<?php
$title = 'Add Member - Web Final Project';
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
    <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">Add New Member</h1>
    <p class="mt-2 text-sm text-slate-600">
        Create a new team member account.
    </p>
</div>

<!-- Form Card -->
<div class="mx-auto max-w-lg">
    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-900/5">
        <form action="/web_final_project/public/users/create" method="POST" class="space-y-6">

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                    placeholder="John Doe"
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset <?= isset($errors['name']) ? 'ring-red-500 focus:ring-red-500' : 'ring-slate-300 focus:ring-primary-500' ?> placeholder:text-slate-400 focus:ring-2 focus:ring-inset transition-all duration-150"
                    required>
                <?php if (isset($errors['name'])): ?>
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <?= htmlspecialchars($errors['name']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                    placeholder="john@example.com"
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset <?= isset($errors['email']) ? 'ring-red-500 focus:ring-red-500' : 'ring-slate-300 focus:ring-primary-500' ?> placeholder:text-slate-400 focus:ring-2 focus:ring-inset transition-all duration-150"
                    required>
                <?php if (isset($errors['email'])): ?>
                    <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['email']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password" id="password" placeholder="••••••••"
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset <?= isset($errors['password']) ? 'ring-red-500 focus:ring-red-500' : 'ring-slate-300 focus:ring-primary-500' ?> placeholder:text-slate-400 focus:ring-2 focus:ring-inset transition-all duration-150"
                    required>
                <?php if (isset($errors['password'])): ?>
                    <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['password']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-slate-700 mb-2">
                    Role
                </label>
                <select name="role" id="role"
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all duration-150">
                    <option value="employee" <?= ($old['role'] ?? '') === 'employee' ? 'selected' : '' ?>>Employee</option>
                    <option value="manager" <?= ($old['role'] ?? '') === 'manager' ? 'selected' : '' ?>>Manager</option>
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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add Member
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
