<?php
$title = 'Team Members - Web Final Project';

ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">Team Members</h1>
            <p class="mt-2 text-sm text-slate-600">
                Manage users and team members in your organization.
            </p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="/web_final_project/public/users/create"
                class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 transition-all duration-150">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add New Member
            </a>
        </div>
    </div>
</div>

<?php if (!empty($users)): ?>
    <!-- Users Table -->
    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-900/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col"
                            class="py-4 pl-6 pr-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Member
                        </th>
                        <th scope="col"
                            class="hidden px-3 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 md:table-cell">
                            Email
                        </th>
                        <th scope="col"
                            class="px-3 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Role
                        </th>
                        <th scope="col"
                            class="hidden px-3 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:table-cell">
                            Joined
                        </th>
                        <th scope="col" class="relative py-4 pl-3 pr-6">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <!-- Avatar + Name -->
                            <td class="whitespace-nowrap py-4 pl-6 pr-3">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name'] ?? 'User') ?>&background=random&size=40"
                                        alt="<?= htmlspecialchars($user['name'] ?? 'User') ?>"
                                        class="h-10 w-10 rounded-full ring-2 ring-white shadow-sm">
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">
                                            <?= htmlspecialchars($user['name']) ?>
                                        </p>
                                        <p class="text-xs text-slate-500 md:hidden">
                                            <?= htmlspecialchars($user['email']) ?>
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Email (Hidden on mobile) -->
                            <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-slate-600 md:table-cell">
                                <?= htmlspecialchars($user['email']) ?>
                            </td>

                            <!-- Role Badge -->
                            <td class="whitespace-nowrap px-3 py-4">
                                <?php
                                $role = $user['role'] ?? 'employee';
                                $roleColors = [
                                    'manager' => 'bg-purple-100 text-purple-700 ring-purple-600/20',
                                    'admin' => 'bg-red-100 text-red-700 ring-red-600/20',
                                    'employee' => 'bg-blue-100 text-blue-700 ring-blue-600/20',
                                ];
                                $roleColor = $roleColors[$role] ?? $roleColors['employee'];
                                ?>
                                <span
                                    class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset <?= $roleColor ?>">
                                    <?= ucfirst($role) ?>
                                </span>
                            </td>

                            <!-- Joined Date (Hidden on mobile/tablet) -->
                            <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-slate-500 lg:table-cell">
                                <?= isset($user['created_at']) ? date('M d, Y', strtotime($user['created_at'])) : 'Unknown' ?>
                            </td>

                            <!-- Actions -->
                            <td class="whitespace-nowrap py-4 pl-3 pr-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Edit Button -->
                                    <a href="/web_final_project/public/users/edit?id=<?= $user['id'] ?>"
                                        class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-primary-600 hover:bg-primary-50 transition-colors"
                                        title="Edit">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="/web_final_project/public/users/delete" method="POST" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <button type="submit"
                                            class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-red-600 hover:bg-red-50 transition-colors"
                                            title="Delete">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <!-- Empty State -->
    <div class="text-center py-16">
        <div class="mx-auto max-w-md">
            <svg class="mx-auto h-40 w-40 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="0.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>

            <h3 class="mt-6 text-xl font-semibold text-slate-900">No team members yet</h3>
            <p class="mt-2 text-sm text-slate-600">
                Get started by adding your first team member.
            </p>

            <div class="mt-8">
                <a href="/web_final_project/public/users/create"
                    class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 transition-all duration-150">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add First Member
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
