<?php
$title = 'Add Task - Web Final Project';
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

// Placeholder members if not provided
$members = $members ?? [];

ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <a href="/web_final_project/public/projects/show?id=<?= $project['id'] ?? '' ?>"
        class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900 transition-colors mb-4">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Back to <?= htmlspecialchars($project['title'] ?? 'Project') ?>
    </a>
    <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">Add New Task</h1>
    <p class="mt-2 text-sm text-slate-600">
        Create a new task for <span
            class="font-medium text-slate-900"><?= htmlspecialchars($project['title'] ?? 'this project') ?></span>
    </p>
</div>

<!-- Form Card -->
<div class="mx-auto max-w-2xl">
    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-900/5">
        <form action="/web_final_project/public/tasks/store" method="POST" class="space-y-6">
            <input type="hidden" name="project_id" value="<?= $project['id'] ?? '' ?>">

            <!-- Task Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-2">
                    Task Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                    placeholder="What needs to be done?"
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all duration-150 text-lg <?= isset($errors['title']) ? 'ring-red-500 focus:ring-red-500' : '' ?>"
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
                <textarea name="description" id="description" rows="4" placeholder="Add more details about this task..."
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all duration-150 resize-none"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
            </div>

            <!-- Priority Selection -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-3">
                    Priority
                </label>
                <div class="flex flex-wrap gap-3" x-data="{ priority: '<?= $old['priority'] ?? 'medium' ?>' }">
                    <!-- Low Priority -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="priority" value="low" class="peer sr-only" x-model="priority">
                        <div
                            class="flex items-center gap-2 rounded-lg border-2 px-4 py-2.5 transition-all peer-checked:border-slate-400 peer-checked:bg-slate-50 border-slate-200 hover:border-slate-300">
                            <span class="h-2.5 w-2.5 rounded-full bg-slate-400"></span>
                            <span class="text-sm font-medium text-slate-700">Low</span>
                        </div>
                    </label>

                    <!-- Medium Priority -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="priority" value="medium" class="peer sr-only" x-model="priority">
                        <div
                            class="flex items-center gap-2 rounded-lg border-2 px-4 py-2.5 transition-all peer-checked:border-amber-400 peer-checked:bg-amber-50 border-slate-200 hover:border-slate-300">
                            <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                            <span class="text-sm font-medium text-slate-700">Medium</span>
                        </div>
                    </label>

                    <!-- High Priority -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="priority" value="high" class="peer sr-only" x-model="priority">
                        <div
                            class="flex items-center gap-2 rounded-lg border-2 px-4 py-2.5 transition-all peer-checked:border-red-400 peer-checked:bg-red-50 border-slate-200 hover:border-slate-300">
                            <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>
                            <span class="text-sm font-medium text-slate-700">High</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Due Date & Assign To Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Due Date -->
                <div>
                    <label for="due_date" class="block text-sm font-medium text-slate-700 mb-2">
                        Due Date
                    </label>
                    <input type="date" name="due_date" id="due_date"
                        value="<?= htmlspecialchars($old['due_date'] ?? '') ?>"
                        class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all duration-150 <?= isset($errors['due_date']) ? 'ring-red-500 focus:ring-red-500' : '' ?>">
                    <?php if (isset($errors['due_date'])): ?>
                        <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['due_date']) ?></p>
                    <?php endif; ?>
                </div>

                <!-- Assign To -->
                <div>
                    <label for="assigned_to" class="block text-sm font-medium text-slate-700 mb-2">
                        Assign To
                    </label>
                    <select name="assigned_to" id="assigned_to"
                        class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all duration-150">
                        <option value="">Unassigned</option>
                        <?php if (!empty($members)): ?>
                            <?php foreach ($members as $member): ?>
                                <option value="<?= $member['user_id'] ?>" <?= ($old['assigned_to'] ?? '') == $member['user_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($member['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <!-- Self-assign option -->
                        <option value="<?= $_SESSION['user_id'] ?? '' ?>" <?= ($old['assigned_to'] ?? '') == ($_SESSION['user_id'] ?? '') ? 'selected' : '' ?>>
                            Me (<?= htmlspecialchars($_SESSION['user_name'] ?? 'Manager') ?>)
                        </option>
                    </select>
                </div>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                    Initial Status
                </label>
                <select name="status" id="status"
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all duration-150">
                    <option value="pending" <?= ($old['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="in_progress" <?= ($old['status'] ?? '') === 'in_progress' ? 'selected' : '' ?>>In
                        Progress</option>
                    <!-- Note: 'Completed' is only available when editing -->
                </select>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-100">
                <a href="/web_final_project/public/projects/show?id=<?= $project['id'] ?? '' ?>"
                    class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-slate-900 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-all duration-150">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Create Task
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
