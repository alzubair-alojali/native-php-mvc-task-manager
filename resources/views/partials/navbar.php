<?php
$userName = $_SESSION['user_name'] ?? 'Guest';
$isLoggedIn = isset($_SESSION['user_id']);
$searchQuery = $_GET['q'] ?? '';
?>

<header class="sticky top-0 z-40 bg-white border-b border-slate-200">
    <div class="flex h-16 items-center gap-x-4 px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">

        <!-- Mobile menu button -->
        <button @click="sidebarOpen = true" type="button" class="-m-2.5 p-2.5 text-slate-700 lg:hidden">
            <span class="sr-only">Open sidebar</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        <!-- Separator -->
        <div class="h-6 w-px bg-slate-200 lg:hidden" aria-hidden="true"></div>

        <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
            <!-- Search Bar -->
            <form class="relative flex flex-1 items-center" action="/web_final_project/public/search" method="GET">
                <div class="relative flex-1 max-w-lg">
                    <!-- Search Icon -->
                    <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                            clip-rule="evenodd" />
                    </svg>

                    <!-- Input -->
                    <input id="search-field" type="search" name="q" value="<?= htmlspecialchars($searchQuery) ?>"
                        placeholder="Search projects or tasks..."
                        class="block w-full rounded-lg border-0 bg-slate-100 py-2.5 pl-10 pr-10 text-slate-900 placeholder:text-slate-500 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm transition-all">

                    <!-- Clear Button (X) - Only shows if query exists -->
                    <?php if (!empty($searchQuery)): ?>
                        <a href="/web_final_project/public/search"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors"
                            title="Clear search">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Search Submit Button -->
                <button type="submit"
                    class="ml-2 inline-flex items-center justify-center rounded-lg bg-indigo-600 p-2.5 text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </form>

            <div class="flex items-center gap-x-4 lg:gap-x-6">
                <!-- Separator -->
                <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-slate-200" aria-hidden="true"></div>

                <!-- Profile dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" type="button"
                        class="-m-1.5 flex items-center p-1.5 hover:bg-slate-50 rounded-lg transition-colors">
                        <span class="sr-only">Open user menu</span>
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-600 text-white text-sm font-semibold">
                            <?= strtoupper(substr($userName, 0, 1)) ?>
                        </div>
                        <span class="hidden lg:flex lg:items-center">
                            <span class="ml-4 text-sm font-semibold leading-6 text-slate-900">
                                <?= htmlspecialchars($userName) ?>
                            </span>
                            <svg class="ml-2 h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 z-10 mt-2.5 w-48 origin-top-right rounded-xl bg-white py-2 shadow-lg ring-1 ring-slate-900/5 focus:outline-none">
                        <a href="/web_final_project/public/profile"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            Your Profile
                        </a>
                        <div class="border-t border-slate-100 my-1"></div>
                        <a href="/web_final_project/public/logout"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                            <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                            Sign out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>