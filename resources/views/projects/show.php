<?php
$title = htmlspecialchars($project['title'] ?? 'Project') . ' - Web Final Project';

// Status badge colors
$statusColors = [
    'pending' => 'bg-amber-100 text-amber-700 ring-amber-600/20',
    'active' => 'bg-emerald-100 text-emerald-700 ring-emerald-600/20',
    'completed' => 'bg-blue-100 text-blue-700 ring-blue-600/20',
];
$statusColor = $statusColors[$project['status'] ?? 'pending'] ?? $statusColors['pending'];

ob_start();
?>

<!-- Back Link & Breadcrumb -->
<div class="mb-6">
    <a href="/projects"
        class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900 transition-colors">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Back to Projects
    </a>
</div>

<!-- Project Header Card -->
<div class="rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-slate-900/5 mb-8">
    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
        <!-- Left: Project Info -->
        <div class="flex-1">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                    <?= htmlspecialchars($project['title']) ?>
                </h1>
                <span
                    class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium ring-1 ring-inset <?= $statusColor ?>">
                    <?= ucfirst($project['status'] ?? 'pending') ?>
                </span>
            </div>

            <p class="text-slate-600 max-w-2xl">
                <?= htmlspecialchars($project['description'] ?? 'No description provided.') ?>
            </p>

            <!-- Progress Bar (Visual) -->
            <div class="mt-6">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="font-medium text-slate-700">Progress</span>
                    <span class="text-slate-500">0% Complete</span>
                </div>
                <div class="h-2.5 w-full rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full rounded-full bg-primary-500 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Right: Actions -->
        <div class="flex flex-wrap items-center gap-3">
            <a href="/tasks/create?project_id=<?= $project['id'] ?>"
                class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 transition-all duration-150">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Task
            </a>
            <a href="/projects/edit?id=<?= $project['id'] ?>"
                class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-all duration-150">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
                Edit
            </a>
            <form action="/projects/delete" method="POST" class="inline"
                onsubmit="return confirm('Are you sure you want to delete this project?');">
                <input type="hidden" name="id" value="<?= $project['id'] ?>">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-red-600 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-red-50 hover:ring-red-200 transition-all duration-150">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Two Column Layout -->
<div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

    <!-- Left Column: Tasks (2/3 width) -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Tasks Section -->
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-slate-900">Project Tasks</h2>
                <a href="/tasks?project_id=<?= $project['id'] ?>"
                    class="text-sm font-medium text-primary-600 hover:text-primary-500 transition-colors">
                    View all →
                </a>
            </div>

            <!-- Tasks Placeholder -->
            <div class="text-center py-12 border-2 border-dashed border-slate-200 rounded-xl">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                </svg>
                <p class="mt-4 text-sm text-slate-500">No tasks yet</p>
                <a href="/tasks/create?project_id=<?= $project['id'] ?>"
                    class="mt-2 inline-flex items-center gap-1 text-sm font-medium text-primary-600 hover:text-primary-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add first task
                </a>
            </div>
        </div>
    </div>

    <!-- Right Column: Sidebar (1/3 width) -->
    <div class="space-y-6">
        <!-- Project Details -->
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
            <h3 class="text-sm font-semibold text-slate-900 mb-4">Project Details</h3>

            <dl class="space-y-4">
                <div class="flex items-start gap-3">
                    <dt class="flex-shrink-0">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </dt>
                    <dd>
                        <p class="text-xs text-slate-500">Manager</p>
                        <p class="text-sm font-medium text-slate-900">
                            <?= htmlspecialchars($_SESSION['user_name'] ?? 'Unknown') ?>
                        </p>
                    </dd>
                </div>

                <div class="flex items-start gap-3">
                    <dt class="flex-shrink-0">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                    </dt>
                    <dd>
                        <p class="text-xs text-slate-500">Deadline</p>
                        <p class="text-sm font-medium text-slate-900">
                            <?= $project['deadline'] ? date('F d, Y', strtotime($project['deadline'])) : 'Not set' ?>
                        </p>
                    </dd>
                </div>

                <div class="flex items-start gap-3">
                    <dt class="flex-shrink-0">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </dt>
                    <dd>
                        <p class="text-xs text-slate-500">Created</p>
                        <p class="text-sm font-medium text-slate-900">
                            <?= isset($project['created_at']) ? date('F d, Y', strtotime($project['created_at'])) : 'Unknown' ?>
                        </p>
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Team Members -->
        <?php include __DIR__ . '/../partials/members_list.php'; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
