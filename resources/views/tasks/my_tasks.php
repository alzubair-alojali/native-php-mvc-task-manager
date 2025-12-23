<?php
$title = 'My Tasks - Web Final Project';

ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">My Tasks</h1>
    <p class="mt-2 text-sm text-slate-600">
        All tasks assigned to you across all projects.
    </p>
</div>

<?php if (!empty($tasks)): ?>
    <!-- Tasks List -->
    <div class="space-y-4">
        <?php foreach ($tasks as $task):
            $priorityColors = [
                'low' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'dot' => 'bg-slate-400'],
                'medium' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-400'],
                'high' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'dot' => 'bg-red-500'],
            ];
            $statusColors = [
                'pending' => 'bg-slate-100 text-slate-700',
                'in_progress' => 'bg-blue-100 text-blue-700',
                'completed' => 'bg-emerald-100 text-emerald-700',
            ];
            $priority = $task['priority'] ?? 'medium';
            $status = $task['status'] ?? 'pending';
            $pColor = $priorityColors[$priority] ?? $priorityColors['medium'];
            $sColor = $statusColors[$status] ?? $statusColors['pending'];
            $isOverdue = !empty($task['due_date']) && $task['status'] !== 'completed' && strtotime($task['due_date']) < strtotime('today');
            $isCompleted = $task['status'] === 'completed';
            ?>
            <div
                class="group rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-900/5 hover:shadow-md transition-all duration-200 <?= $isCompleted ? 'opacity-60' : '' ?>">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <!-- Status Badge -->
                    <div class="flex items-center gap-3 sm:w-28">
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium <?= $sColor ?>">
                            <?= ucfirst(str_replace('_', ' ', $status)) ?>
                        </span>
                    </div>

                    <!-- Task Info -->
                    <div class="flex-1 min-w-0">
                        <a href="/tasks/show?id=<?= $task['id'] ?>" class="block">
                            <h3
                                class="text-base font-semibold <?= $isCompleted ? 'text-slate-400 line-through' : 'text-slate-900 group-hover:text-primary-600' ?> transition-colors truncate">
                                <?= htmlspecialchars($task['title']) ?>
                            </h3>
                            <p class="mt-1 text-sm text-slate-500">
                                <span class="font-medium"><?= htmlspecialchars($task['project_title'] ?? 'No project') ?></span>
                            </p>
                        </a>
                    </div>

                    <!-- Meta -->
                    <div class="flex items-center gap-4 text-sm">
                        <!-- Priority -->
                        <span class="inline-flex items-center gap-1 <?= $pColor['text'] ?>">
                            <span class="h-2 w-2 rounded-full <?= $pColor['dot'] ?>"></span>
                            <?= ucfirst($priority) ?>
                        </span>

                        <!-- Due Date -->
                        <span class="<?= $isOverdue ? 'text-red-600 font-medium' : 'text-slate-500' ?>">
                            <?php if (!empty($task['due_date'])): ?>
                                <?= date('M d', strtotime($task['due_date'])) ?>
                            <?php else: ?>
                                No date
                            <?php endif; ?>
                        </span>

                        <!-- Arrow -->
                        <svg class="h-5 w-5 text-slate-400 group-hover:text-primary-500 transition-colors" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <!-- Empty State -->
    <div class="text-center py-16">
        <div class="mx-auto max-w-md">
            <svg class="mx-auto h-40 w-40 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="0.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
            </svg>

            <h3 class="mt-6 text-xl font-semibold text-slate-900">No tasks assigned</h3>
            <p class="mt-2 text-sm text-slate-600">
                You don't have any tasks assigned to you yet.
            </p>
        </div>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
