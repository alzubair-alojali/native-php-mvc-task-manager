<?php
$title = 'Dashboard - Web Final Project';

ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                Welcome back<?= isset($username) ? ', ' . htmlspecialchars($username) : '' ?>! 👋
            </h1>
            <p class="mt-2 text-sm text-slate-600">
                Here's what's happening with your projects today.
            </p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="/projects/create"
                class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 transition-all duration-150">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New Project
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards Grid -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Total Projects Card -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 p-6 shadow-lg">
        <div class="absolute right-0 top-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10"></div>
        <div class="relative">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                </svg>
            </div>
            <p class="mt-4 text-3xl font-bold text-white"><?= $stats['total_projects'] ?? 0 ?></p>
            <p class="mt-1 text-sm font-medium text-white/80">Total Projects</p>
        </div>
    </div>

    <!-- Active Projects Card -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 p-6 shadow-lg">
        <div class="absolute right-0 top-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10"></div>
        <div class="relative">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                </svg>
            </div>
            <p class="mt-4 text-3xl font-bold text-white"><?= $stats['active_projects'] ?? 0 ?></p>
            <p class="mt-1 text-sm font-medium text-white/80">Active Projects</p>
        </div>
    </div>

    <!-- Pending Tasks Card -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 p-6 shadow-lg">
        <div class="absolute right-0 top-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10"></div>
        <div class="relative">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="mt-4 text-3xl font-bold text-white"><?= $stats['pending_tasks'] ?? 0 ?></p>
            <p class="mt-1 text-sm font-medium text-white/80">Pending Tasks</p>
        </div>
    </div>

    <!-- In Progress Card -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 p-6 shadow-lg">
        <div class="absolute right-0 top-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10"></div>
        <div class="relative">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="mt-4 text-3xl font-bold text-white"><?= $stats['in_progress_tasks'] ?? 0 ?></p>
            <p class="mt-1 text-sm font-medium text-white/80">In Progress</p>
        </div>
    </div>
</div>

<!-- Two Column Grid: Recent Activity -->
<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

    <!-- Left Column: Recent Projects Table -->
    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-900/5">
        <div class="border-b border-slate-100 px-6 py-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Recent Projects</h2>
                <a href="/projects"
                    class="text-sm font-medium text-primary-600 hover:text-primary-500 transition-colors">
                    View all →
                </a>
            </div>
        </div>

        <?php if (!empty($recent_projects)): ?>
            <div class="divide-y divide-slate-100">
                <?php foreach ($recent_projects as $project): ?>
                    <a href="/projects/show?id=<?= $project['id'] ?>"
                        class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900 truncate"><?= htmlspecialchars($project['title']) ?>
                            </p>
                            <p class="text-xs text-slate-500">
                                <?= isset($project['created_at']) ? date('M d, Y', strtotime($project['created_at'])) : 'Recently' ?>
                            </p>
                        </div>
                        <?php
                        $statusColors = [
                            'pending' => 'bg-amber-100 text-amber-700',
                            'active' => 'bg-emerald-100 text-emerald-700',
                            'completed' => 'bg-blue-100 text-blue-700',
                        ];
                        $sColor = $statusColors[$project['status'] ?? 'pending'] ?? $statusColors['pending'];
                        ?>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium <?= $sColor ?>">
                            <?= ucfirst($project['status'] ?? 'pending') ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                </svg>
                <p class="mt-4 text-sm text-slate-500">No projects yet</p>
                <a href="/projects/create"
                    class="mt-2 inline-block text-sm font-medium text-primary-600 hover:text-primary-500">
                    Create your first project →
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Right Column: My Tasks (To-Do List) -->
    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-900/5">
        <div class="border-b border-slate-100 px-6 py-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">My Tasks</h2>
                <span class="text-xs text-slate-500">Upcoming</span>
            </div>
        </div>

        <?php if (!empty($recent_tasks)): ?>
            <div class="divide-y divide-slate-100">
                <?php foreach ($recent_tasks as $task):
                    $isCompleted = ($task['status'] ?? '') === 'completed';
                    $isOverdue = !empty($task['due_date']) && !$isCompleted && strtotime($task['due_date']) < strtotime('today');
                    ?>
                    <div class="flex items-start gap-4 px-6 py-4 hover:bg-slate-50 transition-colors">
                        <!-- Checkbox Visual -->
                        <div class="flex-shrink-0 pt-0.5">
                            <div
                                class="flex h-5 w-5 items-center justify-center rounded border-2 <?= $isCompleted ? 'border-emerald-500 bg-emerald-500' : 'border-slate-300' ?>">
                                <?php if ($isCompleted): ?>
                                    <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Task Info -->
                        <div class="flex-1 min-w-0">
                            <a href="/tasks/show?id=<?= $task['id'] ?>" class="block">
                                <p
                                    class="text-sm font-medium <?= $isCompleted ? 'text-slate-400 line-through' : 'text-slate-900' ?> truncate">
                                    <?= htmlspecialchars($task['title']) ?>
                                </p>
                                <div class="mt-1 flex items-center gap-2 text-xs">
                                    <span
                                        class="text-slate-500"><?= htmlspecialchars($task['project_title'] ?? 'No project') ?></span>
                                    <?php if (!empty($task['due_date'])): ?>
                                        <span class="<?= $isOverdue ? 'text-red-600 font-medium' : 'text-slate-400' ?>">
                                            • Due <?= date('M d', strtotime($task['due_date'])) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>

                        <!-- Priority Indicator -->
                        <?php
                        $priorityDots = [
                            'high' => 'bg-red-500',
                            'medium' => 'bg-amber-400',
                            'low' => 'bg-slate-300',
                        ];
                        $pDot = $priorityDots[$task['priority'] ?? 'medium'] ?? $priorityDots['medium'];
                        ?>
                        <div class="flex-shrink-0">
                            <span class="inline-block h-2 w-2 rounded-full <?= $pDot ?>"
                                title="<?= ucfirst($task['priority'] ?? 'Medium') ?> priority"></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                </svg>
                <p class="mt-4 text-sm text-slate-500">No tasks assigned yet</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($member_projects)): ?>
    <!-- Member Projects Section -->
    <div class="mt-8">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Projects I'm a Member Of</h2>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($member_projects as $mProject): ?>
                <a href="/projects/show?id=<?= $mProject['id'] ?>"
                    class="group rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-900/5 hover:shadow-md transition-all">
                    <p class="text-sm font-medium text-slate-900 group-hover:text-primary-600 transition-colors">
                        <?= htmlspecialchars($mProject['title']) ?>
                    </p>
                    <p class="mt-1 text-xs text-slate-500">
                        Joined
                        <?= isset($mProject['joined_at']) ? date('M d, Y', strtotime($mProject['joined_at'])) : 'Recently' ?>
                    </p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
