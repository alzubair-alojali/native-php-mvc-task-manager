<?php
$title = htmlspecialchars($task['title'] ?? 'Task') . ' - Web Final Project';
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

// Priority colors
$priorityColors = [
    'low' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'dot' => 'bg-slate-400'],
    'medium' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-400'],
    'high' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'dot' => 'bg-red-500'],
];
$priority = $task['priority'] ?? 'medium';
$priorityColor = $priorityColors[$priority] ?? $priorityColors['medium'];

// Status colors
$statusColors = [
    'pending' => 'bg-slate-100 text-slate-700',
    'in_progress' => 'bg-blue-100 text-blue-700',
    'completed' => 'bg-emerald-100 text-emerald-700',
];
$status = $task['status'] ?? 'pending';
$statusColor = $statusColors[$status] ?? $statusColors['pending'];

// Check if task is overdue
$isOverdue = false;
if (!empty($task['due_date']) && $task['status'] !== 'completed') {
    $isOverdue = strtotime($task['due_date']) < strtotime('today');
}

$currentUserId = $_SESSION['user_id'] ?? null;
$comments = $comments ?? [];

ob_start();
?>

<!-- Back Link -->
<div class="mb-6">
    <a href="/web_final_project/public/tasks?project_id=<?= $project['id'] ?? '' ?>"
        class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900 transition-colors">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Back to <?= htmlspecialchars($project['title'] ?? 'Tasks') ?>
    </a>
</div>

<!-- Task Header Card -->
<div class="rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-slate-900/5 mb-6">
    <!-- Title & Actions Row -->
    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-6">
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                <?= htmlspecialchars($task['title']) ?>
            </h1>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="/web_final_project/public/tasks/edit?id=<?= $task['id'] ?>"
                class="inline-flex items-center gap-2 rounded-lg bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-all">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                </svg>
                Edit
            </a>
            <form action="/web_final_project/public/tasks/delete" method="POST" class="inline"
                onsubmit="return confirm('Delete this task?');">
                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-white px-3 py-2 text-sm font-medium text-red-600 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-red-50 transition-all">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Meta Data Row -->
    <div class="flex flex-wrap items-center gap-4 mb-6">
        <!-- Status Badge & Changer -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm font-medium <?= $statusColor ?> hover:opacity-80 transition-opacity">
                <?= ucfirst(str_replace('_', ' ', $status)) ?>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <!-- Status Dropdown -->
            <div x-show="open" x-cloak @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                class="absolute left-0 z-10 mt-2 w-48 origin-top-left rounded-xl bg-white py-2 shadow-lg ring-1 ring-slate-900/5">
                <form action="/web_final_project/public/tasks/update-status" method="POST">
                    <input type="hidden" name="id" value="<?= $task['id'] ?>">
                    <button type="submit" name="status" value="pending"
                        class="flex w-full items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 <?= $status === 'pending' ? 'bg-slate-50' : '' ?>">
                        <span class="h-2 w-2 rounded-full bg-slate-400"></span> Pending
                    </button>
                    <button type="submit" name="status" value="in_progress"
                        class="flex w-full items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 <?= $status === 'in_progress' ? 'bg-slate-50' : '' ?>">
                        <span class="h-2 w-2 rounded-full bg-blue-500"></span> In Progress
                    </button>
                    <button type="submit" name="status" value="completed"
                        class="flex w-full items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 <?= $status === 'completed' ? 'bg-slate-50' : '' ?>">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Completed
                    </button>
                </form>
            </div>
        </div>

        <!-- Priority Badge -->
        <span
            class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-sm font-medium <?= $priorityColor['bg'] ?> <?= $priorityColor['text'] ?>">
            <span class="h-2 w-2 rounded-full <?= $priorityColor['dot'] ?>"></span>
            <?= ucfirst($priority) ?> Priority
        </span>

        <!-- Due Date -->
        <div class="flex items-center gap-2 text-sm <?= $isOverdue ? 'text-red-600 font-medium' : 'text-slate-600' ?>">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <?php if ($isOverdue): ?>
                <span>Overdue: <?= date('M d, Y', strtotime($task['due_date'])) ?></span>
            <?php elseif (!empty($task['due_date'])): ?>
                <span>Due: <?= date('M d, Y', strtotime($task['due_date'])) ?></span>
            <?php else: ?>
                <span>No due date</span>
            <?php endif; ?>
        </div>

        <!-- Assigned To -->
        <div class="flex items-center gap-2 text-sm text-slate-600">
            <div
                class="flex h-6 w-6 items-center justify-center rounded-full bg-primary-100 text-primary-600 text-xs font-semibold">
                <?= strtoupper(substr($task['assigned_user_name'] ?? 'U', 0, 1)) ?>
            </div>
            <span><?= htmlspecialchars($task['assigned_user_name'] ?? 'Unassigned') ?></span>
        </div>
    </div>

    <!-- Description -->
    <?php if (!empty($task['description'])): ?>
        <div class="rounded-xl bg-slate-50 p-4 border border-slate-100">
            <h3 class="text-sm font-medium text-slate-700 mb-2">Description</h3>
            <p class="text-sm text-slate-600 whitespace-pre-wrap"><?= htmlspecialchars($task['description']) ?></p>
        </div>
    <?php endif; ?>
</div>

<!-- Discussion/Comments Section -->
<div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-900/5 overflow-hidden">
    <!-- Header -->
    <div class="border-b border-slate-100 px-6 py-4">
        <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
            </svg>
            Discussion
            <?php if (count($comments) > 0): ?>
                <span class="text-sm font-normal text-slate-500">(<?= count($comments) ?>)</span>
            <?php endif; ?>
        </h2>
    </div>

    <!-- Comments Stream -->
    <div class="p-6 space-y-4 max-h-96 overflow-y-auto">
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment):
                $isCurrentUser = ($comment['user_id'] ?? 0) == $currentUserId;
                $timeAgo = time() - strtotime($comment['created_at']);
                if ($timeAgo < 60) {
                    $timeText = 'Just now';
                } elseif ($timeAgo < 3600) {
                    $timeText = floor($timeAgo / 60) . ' min ago';
                } elseif ($timeAgo < 86400) {
                    $timeText = floor($timeAgo / 3600) . ' hours ago';
                } else {
                    $timeText = date('M d, Y', strtotime($comment['created_at']));
                }
                ?>
                <div class="flex gap-3 <?= $isCurrentUser ? 'flex-row-reverse' : '' ?>">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full <?= $isCurrentUser ? 'bg-primary-500 text-white' : 'bg-slate-200 text-slate-600' ?> text-sm font-semibold">
                            <?= strtoupper(substr($comment['user_name'] ?? 'U', 0, 1)) ?>
                        </div>
                    </div>

                    <!-- Comment Bubble -->
                    <div class="flex-1 max-w-md <?= $isCurrentUser ? 'text-right' : '' ?>">
                        <div
                            class="inline-block rounded-2xl px-4 py-2.5 <?= $isCurrentUser ? 'bg-primary-500 text-white rounded-br-md' : 'bg-slate-100 text-slate-900 rounded-bl-md' ?>">
                            <p class="text-sm whitespace-pre-wrap"><?= htmlspecialchars($comment['body']) ?></p>
                        </div>
                        <div
                            class="mt-1 flex items-center gap-2 text-xs text-slate-500 <?= $isCurrentUser ? 'justify-end' : '' ?>">
                            <span class="font-medium"><?= htmlspecialchars($comment['user_name'] ?? 'Unknown') ?></span>
                            <span>•</span>
                            <span><?= $timeText ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                </svg>
                <p class="mt-4 text-sm text-slate-500">Be the first to comment on this task.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Comment Form -->
    <div class="border-t border-slate-100 p-4 bg-slate-50">
        <form action="/web_final_project/public/comments/store" method="POST" class="flex gap-3">
            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
            <div class="flex-shrink-0">
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-500 text-white text-sm font-semibold">
                    <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                </div>
            </div>
            <div class="flex-1">
                <textarea name="body" rows="2" placeholder="Write a comment..."
                    class="block w-full rounded-xl border-0 px-4 py-2.5 text-sm text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all duration-150 resize-none"
                    required></textarea>
                <?php if (isset($errors['body'])): ?>
                    <p class="mt-1 text-sm text-red-600"><?= htmlspecialchars($errors['body']) ?></p>
                <?php endif; ?>
            </div>
            <div class="flex-shrink-0 self-end">
                <button type="submit"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 transition-all duration-150">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                    Post
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
