<?php
$title = $title ?? 'Content Management';

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
                    <h1 class="text-xl font-bold text-slate-900">Content Management</h1>
                </div>
                <div class="flex items-center gap-4">
                    <a href="<?= base_url('/admin/messages') ?>" class="text-sm text-slate-600 hover:text-indigo-600">
                        <i class="fas fa-envelope mr-1"></i> Messages
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- ============================================================ -->
            <!-- SECTION A: Site Settings -->
            <!-- ============================================================ -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-900 mb-6 flex items-center gap-2">
                    <i class="fas fa-cog text-indigo-500"></i>
                    Site Settings
                </h2>

                <form action="<?= base_url('/admin/settings/update') ?>" method="POST" class="space-y-6">
                    <!-- Hero Heading -->
                    <div>
                        <label for="hero_heading" class="block text-sm font-medium text-slate-700 mb-2">
                            Hero Section Heading
                        </label>
                        <input type="text" name="hero_heading" id="hero_heading"
                            value="<?= htmlspecialchars($settings['hero_heading'] ?? '') ?>"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all"
                            placeholder="Main landing page heading">
                    </div>

                    <!-- About Title -->
                    <div>
                        <label for="about_us_title" class="block text-sm font-medium text-slate-700 mb-2">
                            About Us Title
                        </label>
                        <input type="text" name="about_us_title" id="about_us_title"
                            value="<?= htmlspecialchars($settings['about_us_title'] ?? '') ?>"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all"
                            placeholder="About section title">
                    </div>

                    <!-- About Content -->
                    <div>
                        <label for="about_us_content" class="block text-sm font-medium text-slate-700 mb-2">
                            About Us Content
                        </label>
                        <textarea name="about_us_content" id="about_us_content" rows="4"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all resize-none"
                            placeholder="Describe your organization..."><?= htmlspecialchars($settings['about_us_content'] ?? '') ?></textarea>
                    </div>

                    <button type="submit"
                        class="w-full rounded-lg bg-indigo-600 px-4 py-3 text-white font-semibold hover:bg-indigo-500 transition-colors">
                        <i class="fas fa-save mr-2"></i> Save Settings
                    </button>
                </form>
            </div>

            <!-- ============================================================ -->
            <!-- SECTION B: Services Management -->
            <!-- ============================================================ -->
            <div class="space-y-6">
                <!-- Add New Service Form -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-6 flex items-center gap-2">
                        <i class="fas fa-plus-circle text-emerald-500"></i>
                        Add New Service
                    </h2>

                    <form action="<?= base_url('/admin/services/store') ?>" method="POST" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="service_title" class="block text-sm font-medium text-slate-700 mb-2">
                                    Service Title *
                                </label>
                                <input type="text" name="title" id="service_title" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all"
                                    placeholder="e.g., Web Development">
                            </div>
                            <div>
                                <label for="service_icon" class="block text-sm font-medium text-slate-700 mb-2">
                                    Icon Class
                                </label>
                                <input type="text" name="icon" id="service_icon"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all"
                                    placeholder="fa-code">
                                <p class="mt-1 text-xs text-slate-500">FontAwesome class (e.g., fa-code, fa-mobile-alt)
                                </p>
                            </div>
                        </div>

                        <div>
                            <label for="service_description" class="block text-sm font-medium text-slate-700 mb-2">
                                Description
                            </label>
                            <textarea name="description" id="service_description" rows="2"
                                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all resize-none"
                                placeholder="Brief description of the service..."></textarea>
                        </div>

                        <button type="submit"
                            class="rounded-lg bg-emerald-600 px-6 py-2.5 text-white font-medium hover:bg-emerald-500 transition-colors">
                            <i class="fas fa-plus mr-2"></i> Add Service
                        </button>
                    </form>
                </div>

                <!-- Existing Services Table -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-6 flex items-center gap-2">
                        <i class="fas fa-list text-slate-500"></i>
                        Existing Services
                        <span class="ml-auto text-sm font-normal text-slate-500">
                            <?= count($services ?? []) ?> total
                        </span>
                    </h2>

                    <?php if (!empty($services)): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-slate-200">
                                        <th class="text-left py-3 px-4 text-sm font-medium text-slate-600">Icon</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-slate-600">Title</th>
                                        <th class="text-left py-3 px-4 text-sm font-medium text-slate-600">Description</th>
                                        <th class="text-right py-3 px-4 text-sm font-medium text-slate-600">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <?php foreach ($services as $service): ?>
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="py-3 px-4">
                                                <div
                                                    class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                                    <i
                                                        class="fas <?= htmlspecialchars($service['icon'] ?? 'fa-star') ?> text-indigo-600"></i>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 font-medium text-slate-900">
                                                <?= htmlspecialchars($service['title']) ?>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-slate-600 max-w-xs truncate">
                                                <?= htmlspecialchars($service['description'] ?? '-') ?>
                                            </td>
                                            <td class="py-3 px-4 text-right">
                                                <form action="<?= base_url('/admin/services/delete') ?>" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this service?');">
                                                    <input type="hidden" name="id" value="<?= $service['id'] ?>">
                                                    <button type="submit"
                                                        class="text-red-500 hover:text-red-700 transition-colors">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8 text-slate-500">
                            <i class="fas fa-inbox text-4xl mb-3"></i>
                            <p>No services added yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</body>

</html>