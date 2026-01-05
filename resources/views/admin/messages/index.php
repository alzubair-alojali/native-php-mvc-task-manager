<?php
$title = $title ?? 'Contact Messages';

// Get flash messages
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= htmlspecialchars($title) ?> - Admin
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-slate-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="<?= base_url('/dashboard') ?>" class="text-slate-500 hover:text-slate-700">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-xl font-bold text-slate-900">Contact Messages</h1>
                    <?php if (($unreadCount ?? 0) > 0): ?>
                        <span
                            class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">
                            <?= $unreadCount ?> unread
                        </span>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-4">
                    <a href="<?= base_url('/admin/content') ?>" class="text-sm text-slate-600 hover:text-indigo-600">
                        <i class="fas fa-cog mr-1"></i> Content
                    </a>
                    <span class="text-slate-400">|</span>
                    <span class="text-sm text-slate-600">
                        <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>
                    </span>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Flash Messages -->
        <?php if ($success): ?>
            <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    <p class="text-emerald-700">
                        <?= htmlspecialchars($success) ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    <p class="text-red-700">
                        <?= htmlspecialchars($error) ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                        <i class="fas fa-envelope text-indigo-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">
                            <?= $totalCount ?? 0 ?>
                        </p>
                        <p class="text-sm text-slate-500">Total Messages</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-lg bg-amber-100 flex items-center justify-center">
                        <i class="fas fa-envelope-open text-amber-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">
                            <?= $unreadCount ?? 0 ?>
                        </p>
                        <p class="text-sm text-slate-500">Unread</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-lg bg-emerald-100 flex items-center justify-center">
                        <i class="fas fa-check-double text-emerald-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">
                            <?= ($totalCount ?? 0) - ($unreadCount ?? 0) ?>
                        </p>
                        <p class="text-sm text-slate-500">Read</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <?php if (!empty($messages)): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left py-4 px-6 text-sm font-medium text-slate-600 w-12">Status</th>
                                <th class="text-left py-4 px-6 text-sm font-medium text-slate-600">Date</th>
                                <th class="text-left py-4 px-6 text-sm font-medium text-slate-600">Name</th>
                                <th class="text-left py-4 px-6 text-sm font-medium text-slate-600">Email</th>
                                <th class="text-left py-4 px-6 text-sm font-medium text-slate-600">Message</th>
                                <th class="text-right py-4 px-6 text-sm font-medium text-slate-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($messages as $msg): ?>
                                <tr
                                    class="hover:bg-slate-50 transition-colors <?= !$msg['is_read'] ? 'bg-indigo-50/50' : '' ?>">
                                    <td class="py-4 px-6">
                                        <?php if (!$msg['is_read']): ?>
                                            <span class="inline-flex h-3 w-3 rounded-full bg-indigo-500" title="Unread"></span>
                                        <?php else: ?>
                                            <span class="inline-flex h-3 w-3 rounded-full bg-slate-300" title="Read"></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-slate-500 whitespace-nowrap">
                                        <?= date('M j, Y', strtotime($msg['created_at'])) ?>
                                        <br>
                                        <span class="text-xs text-slate-400">
                                            <?= date('g:i A', strtotime($msg['created_at'])) ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-medium text-slate-900">
                                            <?= htmlspecialchars($msg['name']) ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-slate-600">
                                        <a href="mailto:<?= htmlspecialchars($msg['email']) ?>"
                                            class="text-indigo-600 hover:underline">
                                            <?= htmlspecialchars($msg['email']) ?>
                                        </a>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-slate-600 max-w-xs">
                                        <p class="line-clamp-2">
                                            <?= htmlspecialchars($msg['message']) ?>
                                        </p>
                                    </td>
                                    <td class="py-4 px-6 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Toggle Read -->
                                            <form action="<?= base_url('/admin/messages/toggle-read') ?>" method="POST"
                                                class="inline">
                                                <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-indigo-600 transition-colors"
                                                    title="<?= $msg['is_read'] ? 'Mark as unread' : 'Mark as read' ?>">
                                                    <i
                                                        class="fas <?= $msg['is_read'] ? 'fa-envelope' : 'fa-envelope-open' ?>"></i>
                                                </button>
                                            </form>
                                            <!-- Delete -->
                                            <form action="<?= base_url('/admin/messages/delete') ?>" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this message?');">
                                                <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-red-600 transition-colors"
                                                    title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="mx-auto h-16 w-16 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                        <i class="fas fa-inbox text-3xl text-slate-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 mb-2">No messages yet</h3>
                    <p class="text-slate-500">When visitors submit the contact form, their messages will appear here.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>