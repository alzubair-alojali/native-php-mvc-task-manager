<?php
// Determine current page for active state
$currentPath = $_SERVER['REQUEST_URI'] ?? '';
$isActive = function ($path) use ($currentPath) {
    return strpos($currentPath, $path) !== false;
};
?>

<!-- Mobile Sidebar -->
<aside x-cloak :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 sidebar-transition lg:hidden">
    <?php include __DIR__ . '/sidebar-content.php'; ?>
</aside>

<!-- Desktop Sidebar -->
<aside class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-slate-900 px-6 pb-4">
        <?php include __DIR__ . '/sidebar-content.php'; ?>
    </div>
</aside>
