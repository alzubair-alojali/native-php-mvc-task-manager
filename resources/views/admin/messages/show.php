<?php
$title = $title ?? 'View Message';

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
                    <a href="<?= base_url('/admin/messages') ?>" class="text-slate-500 hover:text-slate-700">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-xl font-bold text-slate-900">View Message</h1>
                </div>
                <span class="text-sm text-slate-600">
                    <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>
                </span>
            </div>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Message Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            <?= htmlspecialchars($message['name'] ?? 'Unknown') ?>
                        </h2>
                        <a href="mailto:<?= htmlspecialchars($message['email'] ?? '') ?>"
                            class="text-sm text-indigo-600 hover:underline">
                            <?= htmlspecialchars($message['email'] ?? '') ?>
                        </a>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-500">
                            <?= isset($message['created_at']) ? date('F j, Y', strtotime($message['created_at'])) : '' ?>
                        </p>
                        <p class="text-xs text-slate-400">
                            <?= isset($message['created_at']) ? date('g:i A', strtotime($message['created_at'])) : '' ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Message Body -->
            <div class="px-6 py-6">
                <p class="text-slate-700 whitespace-pre-wrap leading-relaxed">
                    <?= htmlspecialchars($message['message'] ?? 'No content') ?>
                </p>
            </div>

            <!-- Actions -->
            <div class="bg-slate-50 border-t border-slate-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <a href="mailto:<?= htmlspecialchars($message['email'] ?? '') ?>"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">
                        <i class="fas fa-reply"></i>
                        Reply via Email
                    </a>

                    <form action="<?= base_url('/admin/messages/delete') ?>" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this message?');">
                        <input type="hidden" name="id" value="<?= $message['id'] ?? '' ?>">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-red-600 ring-1 ring-inset ring-slate-300 hover:bg-red-50 transition-colors">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Back Link -->
        <div class="mt-6 text-center">
            <a href="<?= base_url('/admin/messages') ?>" class="text-sm text-slate-600 hover:text-slate-900">
                <i class="fas fa-arrow-left mr-1"></i> Back to Messages
            </a>
        </div>
    </main>
</body>

</html>