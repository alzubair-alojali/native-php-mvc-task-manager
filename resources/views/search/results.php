<?php
$title = 'Search Results - Web Final Project';
$query = htmlspecialchars($query ?? '');
$showAll = $showAll ?? false;

ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <?php if ($showAll): ?>
        <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">Browse All</h1>
        <p class="mt-2 text-sm text-slate-600">
            Showing your recent projects and tasks.
        </p>
    <?php elseif (!empty($query)): ?>
        <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">Search Results</h1>
        <p class="mt-2 text-sm text-slate-600">
            Results for "<span class="font-medium text-slate-900"><?= $query ?></span>"
        </p>
    <?php else: ?>
        <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">Search</h1>
        <p class="mt-2 text-sm text-slate-600">
            Use the search bar above to find projects and tasks.
        </p>
    <?php endif; ?>
</div>

<?php if (empty($projects) && empty($tasks)): ?>
    <div class="text-center py-16">
        <svg class="mx-auto h-16 w-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
        </svg>
        <h3 class="mt-4 text-lg font-semibold text-slate-900">No results found</h3>
        <p class="mt-2 text-sm text-slate-500">We couldn't find anything matching "<?= $query ?>"</p>
    </div>
<?php else: ?>

    <!-- Projects Results -->
    <?php if (!empty($projects)): ?>
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Projects (<?= count($projects) ?>)</h2>
            <div class="space-y-3">
                <?php foreach ($projects as $project): ?>
                    <a href="/web_final_project/public/projects/show?id=<?= $project['id'] ?>"
                        class="flex items-center gap-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-900/5 hover:shadow-md transition-all">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-100 text-primary-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900"><?= htmlspecialchars($project['title']) ?></p>
                            <p class="text-xs text-slate-500">Project</p>
                        </div>
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Tasks Results -->
    <?php if (!empty($tasks)): ?>
        <div>
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Tasks (<?= count($tasks) ?>)</h2>
            <div class="space-y-3">
                <?php foreach ($tasks as $task): ?>
                    <a href="/web_final_project/public/tasks/show?id=<?= $task['id'] ?>"
                        class="flex items-center gap-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-900/5 hover:shadow-md transition-all">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900"><?= htmlspecialchars($task['title']) ?></p>
                            <p class="text-xs text-slate-500"><?= htmlspecialchars($task['project_title'] ?? 'Task') ?></p>
                        </div>
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>