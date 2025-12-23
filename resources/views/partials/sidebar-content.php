<?php
// Helper function for active link styling
$currentPath = $_SERVER['REQUEST_URI'] ?? '';
$navItems = [
    ['name' => 'Dashboard', 'href' => '/', 'icon' => 'home', 'match' => ['public\/$', 'dashboard']],
    ['name' => 'Projects', 'href' => '/projects', 'icon' => 'folder', 'match' => ['projects']],
    ['name' => 'Tasks', 'href' => '/tasks/my-tasks', 'icon' => 'clipboard', 'match' => ['tasks']],
    ['name' => 'Team', 'href' => '/users', 'icon' => 'users', 'match' => ['users']],
];

if (!function_exists('isActiveLink')) {
    function isActiveLink($matches, $currentPath)
    {
        foreach ($matches as $match) {
            if (preg_match('/' . $match . '/', $currentPath)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('getIcon')) {
    function getIcon($name)
    {
        $icons = [
            'home' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>',
            'folder' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/>',
            'clipboard' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>',
            'users' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>',
        ];
        return $icons[$name] ?? '';
    }
}
?>

<!-- Logo -->
<div class="flex h-16 shrink-0 items-center">
    <a href="/" class="flex items-center gap-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-600">
            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.39m3.421 3.39a15.995 15.995 0 004.764-4.648l4.096-6.144a1.125 1.125 0 00-1.565-1.566l-6.144 4.096a16.006 16.006 0 00-4.764 4.764m3.421 3.39L6.75 15" />
            </svg>
        </div>
        <span class="text-xl font-bold text-white">Web Final Project</span>
    </a>
</div>

<!-- Close button for mobile -->
<button @click="sidebarOpen = false" class="absolute right-4 top-4 text-slate-400 hover:text-white lg:hidden">
    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
</button>

<!-- Navigation -->
<nav class="flex flex-1 flex-col mt-8">
    <ul role="list" class="flex flex-1 flex-col gap-y-7">
        <li>
            <ul role="list" class="-mx-2 space-y-1">
                <?php foreach ($navItems as $item):
                    $active = isActiveLink($item['match'], $currentPath);
                    ?>
                    <li>
                        <a href="<?= $item['href'] ?>" class="group flex gap-x-3 rounded-lg p-3 text-sm font-semibold leading-6 transition-all duration-150
                            <?= $active
                                ? 'bg-primary-600 text-white'
                                : 'text-slate-400 hover:bg-slate-800 hover:text-white'
                                ?>">
                            <svg class="h-6 w-6 shrink-0 <?= $active ? 'text-white' : 'text-slate-400 group-hover:text-white' ?>"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <?= getIcon($item['icon']) ?>
                            </svg>
                            <?= $item['name'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>

        <!-- Bottom section -->
        <li class="mt-auto">
            <div class="rounded-lg bg-slate-800 p-4">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-600 text-white font-semibold">
                        <?= strtoupper(substr($_SESSION['user_name'] ?? 'G', 0, 1)) ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">
                            <?= htmlspecialchars($_SESSION['user_name'] ?? 'Guest') ?>
                        </p>
                        <p class="text-xs text-slate-400">Manager</p>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</nav>
