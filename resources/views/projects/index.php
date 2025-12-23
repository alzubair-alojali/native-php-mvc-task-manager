<?php
$title = 'My Projects - Web Final Project';

ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">My Projects</h1>
            <p class="mt-2 text-sm text-slate-600">
                Manage and track all your projects in one place.
            </p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="/projects/create"
                class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-all duration-150">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New Project
            </a>
        </div>
    </div>
</div>

<?php if (!empty($projects)): ?>
    <!-- Projects Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($projects as $project): ?>
            <div
                class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-900/5 hover:shadow-lg transition-all duration-200">
                <!-- Card Header -->
                <div class="p-6 pb-4">
                    <div class="flex items-start justify-between gap-4">
                        <h3 class="text-lg font-semibold text-slate-900 group-hover:text-primary-600 transition-colors">
                            <a href="/projects/show?id=<?= $project['id'] ?>"
                                class="after:absolute after:inset-0">
                                <?= htmlspecialchars($project['title']) ?>
                            </a>
                        </h3>
                        <?php
                        $statusColors = [
                            'pending' => 'bg-amber-100 text-amber-700 ring-amber-600/20',
                            'active' => 'bg-emerald-100 text-emerald-700 ring-emerald-600/20',
                            'completed' => 'bg-blue-100 text-blue-700 ring-blue-600/20',
                        ];
                        $statusColor = $statusColors[$project['status'] ?? 'pending'] ?? $statusColors['pending'];
                        ?>
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset <?= $statusColor ?>">
                            <?= ucfirst($project['status'] ?? 'pending') ?>
                        </span>
                    </div>

                    <!-- Description -->
                    <p class="mt-3 text-sm text-slate-600 line-clamp-2">
                        <?= htmlspecialchars($project['description'] ?? 'No description provided.') ?>
                    </p>
                </div>

                <!-- Card Footer -->
                <div class="mt-auto border-t border-slate-100 bg-slate-50/50 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            <span>
                                <?= $project['deadline'] ? date('M d, Y', strtotime($project['deadline'])) : 'No deadline' ?>
                            </span>
                        </div>
                        <a href="/projects/show?id=<?= $project['id'] ?>"
                            class="relative z-10 inline-flex items-center gap-1 text-sm font-medium text-primary-600 hover:text-primary-500 transition-colors">
                            Manage
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <!-- Empty State -->
    <div class="text-center py-16">
        <div class="mx-auto max-w-md">
            <!-- Empty State SVG Illustration -->
            <svg class="mx-auto h-40 w-40 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="0.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
            </svg>

            <h3 class="mt-6 text-xl font-semibold text-slate-900">No projects yet</h3>
            <p class="mt-2 text-sm text-slate-600">
                Get started by creating your first project. Organize your work and collaborate with your team.
            </p>

            <div class="mt-8">
                <a href="/projects/create"
                    class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-all duration-150">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Create Your First Project
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
