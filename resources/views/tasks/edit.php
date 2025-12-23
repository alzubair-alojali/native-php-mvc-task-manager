<?php
$title = 'Edit Task - Web Final Project';
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

$members = $members ?? [];

ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <a href="/tasks/show?id=<?= $task['id'] ?>"
        class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900 transition-colors mb-4">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Back to Task
    </a>
    <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">Edit Task</h1>
    <p class="mt-2 text-sm text-slate-600">Update the task details below.</p>
</div>

<!-- Form Card -->
<div class="mx-auto max-w-2xl">
    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-900/5">
        <form action="/tasks/update" method="POST" class="space-y-6">
            <input type="hidden" name="id" value="<?= $task['id'] ?>">
            <input type="hidden" name="project_id" value="<?= $task['project_id'] ?>">

            <!-- Task Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-2">
                    Task Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title"
                    value="<?= htmlspecialchars($old['title'] ?? $task['title']) ?>"
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all text-lg <?= isset($errors['title']) ? 'ring-red-500' : '' ?>"
                    required>
                <?php if (isset($errors['title'])): ?>
                    <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['title']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all resize-none"><?= htmlspecialchars($old['description'] ?? $task['description'] ?? '') ?></textarea>
            </div>

            <!-- Priority Selection -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-3">Priority</label>
                <?php $currentPriority = $old['priority'] ?? $task['priority'] ?? 'medium'; ?>
                <div class="flex flex-wrap gap-3" x-data="{ priority: '<?= $currentPriority ?>' }">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="priority" value="low" class="peer sr-only" x-model="priority">
                        <div
                            class="flex items-center gap-2 rounded-lg border-2 px-4 py-2.5 transition-all peer-checked:border-slate-400 peer-checked:bg-slate-50 border-slate-200 hover:border-slate-300">
                            <span class="h-2.5 w-2.5 rounded-full bg-slate-400"></span>
                            <span class="text-sm font-medium text-slate-700">Low</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="priority" value="medium" class="peer sr-only" x-model="priority">
                        <div
                            class="flex items-center gap-2 rounded-lg border-2 px-4 py-2.5 transition-all peer-checked:border-amber-400 peer-checked:bg-amber-50 border-slate-200 hover:border-slate-300">
                            <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                            <span class="text-sm font-medium text-slate-700">Medium</span>
                        </div>
                    </label>
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

            <!-- Grid: Due Date, Status, Assign To -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                <div>
                    <label for="due_date" class="block text-sm font-medium text-slate-700 mb-2">Due Date</label>
                    <input type="date" name="due_date" id="due_date"
                        value="<?= htmlspecialchars($old['due_date'] ?? $task['due_date'] ?? '') ?>"
                        class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                    <?php $currentStatus = $old['status'] ?? $task['status'] ?? 'pending'; ?>
                    <select name="status" id="status"
                        class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all">
                        <option value="pending" <?= $currentStatus === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="in_progress" <?= $currentStatus === 'in_progress' ? 'selected' : '' ?>>In Progress
                        </option>
                        <option value="completed" <?= $currentStatus === 'completed' ? 'selected' : '' ?>>Completed
                        </option>
                    </select>
                </div>
                <div>
                    <label for="assigned_to" class="block text-sm font-medium text-slate-700 mb-2">Assign To</label>
                    <?php $currentAssigned = $old['assigned_to'] ?? $task['assigned_to'] ?? ''; ?>
                    <select name="assigned_to" id="assigned_to"
                        class="block w-full rounded-lg border-0 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all">
                        <option value="">Unassigned</option>
                        <?php foreach ($members as $member): ?>
                            <option value="<?= $member['user_id'] ?>" <?= $currentAssigned == $member['user_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($member['name']) ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="<?= $_SESSION['user_id'] ?? '' ?>" <?= $currentAssigned == ($_SESSION['user_id'] ?? '') ? 'selected' : '' ?>>
                            Me (<?= htmlspecialchars($_SESSION['user_name'] ?? 'Manager') ?>)
                        </option>
                    </select>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-100">
                <a href="/tasks/show?id=<?= $task['id'] ?>"
                    class="px-4 py-2.5 text-sm font-medium text-slate-700 hover:text-slate-900 transition-colors">Cancel</a>
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 transition-all">
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
