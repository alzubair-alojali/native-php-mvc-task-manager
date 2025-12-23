<?php
/**
 * Project Members List Component
 * Include this partial in projects/show.php
 * Expects: $members (array), $project (array)
 */
$members = $members ?? [];
$projectId = $project['id'] ?? null;
$isManager = ($_SESSION['user_id'] ?? null) == ($project['manager_id'] ?? null);
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>

<div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-900/5">
    <!-- Header -->
    <div class="border-b border-slate-100 px-6 py-4">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                Team Members
                <?php if (count($members) > 0): ?>
                    <span
                        class="inline-flex items-center justify-center h-5 min-w-[1.25rem] px-1.5 rounded-full bg-slate-100 text-xs font-medium text-slate-600">
                        <?= count($members) ?>
                    </span>
                <?php endif; ?>
            </h3>
        </div>
    </div>

    <!-- Add Member Form (Only for Manager) -->
    <?php if ($isManager): ?>
        <div class="border-b border-slate-100 px-6 py-4 bg-slate-50">
            <form action="/projects/members/add" method="POST" class="flex gap-2">
                <input type="hidden" name="project_id" value="<?= $projectId ?>">
                <div class="flex-1">
                    <input type="email" name="email" placeholder="Enter email to invite..."
                        class="block w-full rounded-lg border-0 px-3 py-2 text-sm text-slate-900 shadow-sm ring-1 ring-inset <?= isset($errors['email']) ? 'ring-red-500' : 'ring-slate-300' ?> placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all"
                        required>
                </div>
                <button type="submit"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-primary-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-500 transition-all">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Invite
                </button>
            </form>
            <?php if (isset($errors['email'])): ?>
                <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($errors['email']) ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Members List -->
    <div class="divide-y divide-slate-100">
        <!-- Manager (Always First) -->
        <div class="flex items-center gap-3 px-6 py-4">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user_name'] ?? 'Manager') ?>&background=6366f1&color=fff&size=40"
                alt="<?= htmlspecialchars($_SESSION['user_name'] ?? 'Manager') ?>"
                class="h-10 w-10 rounded-full ring-2 ring-white shadow-sm">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-900 truncate">
                    <?= htmlspecialchars($_SESSION['user_name'] ?? 'Project Manager') ?>
                </p>
                <p class="text-xs text-primary-600 font-medium">Manager</p>
            </div>
            <span
                class="inline-flex items-center rounded-full bg-primary-100 px-2 py-0.5 text-xs font-medium text-primary-700">
                Owner
            </span>
        </div>

        <?php if (!empty($members)): ?>
            <?php foreach ($members as $member): ?>
                <div class="flex items-center gap-3 px-6 py-4 group">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($member['name'] ?? 'User') ?>&background=random&size=40"
                        alt="<?= htmlspecialchars($member['name'] ?? 'User') ?>"
                        class="h-10 w-10 rounded-full ring-2 ring-white shadow-sm">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-900 truncate">
                            <?= htmlspecialchars($member['name'] ?? 'Team Member') ?>
                        </p>
                        <p class="text-xs text-slate-500">Member</p>
                    </div>

                    <?php if ($isManager): ?>
                        <!-- Remove Button (Manager Only) -->
                        <form action="/projects/members/remove" method="POST"
                            class="opacity-0 group-hover:opacity-100 transition-opacity"
                            onsubmit="return confirm('Remove this member?');">
                            <input type="hidden" name="project_id" value="<?= $projectId ?>">
                            <input type="hidden" name="user_id" value="<?= $member['user_id'] ?>">
                            <button type="submit"
                                class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all"
                                title="Remove member">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (empty($members)): ?>
            <div class="px-6 py-8 text-center">
                <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
                <p class="mt-3 text-sm text-slate-500">No team members yet</p>
                <?php if ($isManager): ?>
                    <p class="mt-1 text-xs text-slate-400">Invite members using their email above</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
