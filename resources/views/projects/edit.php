<?php
$title = 'Edit Project - Web Final Project';
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <a href="/projects/show?id=<?= $project['id'] ?>"
        class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900 transition-colors mb-4">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Back to Project
    </a>
    <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">Edit Project</h1>
    <p class="mt-2 text-sm text-slate-600">
        Update the project details below.
    </p>
</div>

<!-- Form Card -->
<div class="mx-auto max-w-2xl">
    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-900/5">
        <form action="/projects/edit" method="POST" class="space-y-6">
            <input type="hidden" name="id" value="<?= $project['id'] ?>">

            <!-- Project Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-2">
                    Project Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title"
                    value="<?= htmlspecialchars($old['title'] ?? $project['title']) ?>"
                    placeholder="Enter project title..."
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all duration-150 <?= isset($errors['title']) ? 'ring-red-500 focus:ring-red-500' : '' ?>"
                    required>
                <?php if (isset($errors['title'])): ?>
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <?= htmlspecialchars($errors['title']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                    Description
                </label>
                <textarea name="description" id="description" rows="4" placeholder="Describe your project..."
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all duration-150 resize-none"><?= htmlspecialchars($old['description'] ?? $project['description'] ?? '') ?></textarea>
            </div>

            <!-- Deadline & Status Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Deadline -->
                <div>
                    <label for="deadline" class="block text-sm font-medium text-slate-700 mb-2">
                        Deadline <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="deadline" id="deadline"
                        value="<?= htmlspecialchars($old['deadline'] ?? $project['deadline'] ?? '') ?>"
                        class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all duration-150 <?= isset($errors['deadline']) ? 'ring-red-500 focus:ring-red-500' : '' ?>"
                        required>
                    <?php if (isset($errors['deadline'])): ?>
                        <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['deadline']) ?></p>
                    <?php endif; ?>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                        Status
                    </label>
                    <?php $currentStatus = $old['status'] ?? $project['status'] ?? 'pending'; ?>
                    <select name="status" id="status"
                        class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all duration-150">
                        <option value="pending" <?= $currentStatus === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="active" <?= $currentStatus === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="completed" <?= $currentStatus === 'completed' ? 'selected' : '' ?>>Completed
                        </option>
                    </select>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-100">
                <a href="/projects/show?id=<?= $project['id'] ?>"
                    class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-slate-900 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-all duration-150">
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
