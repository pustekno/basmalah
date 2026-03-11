<!-- Sidebar -->
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700 transform transition-transform duration-300 ease-in-out" :class="{ '-translate-x-full': !sidebarOpen }">
    <div class="flex flex-col h-full">
        <!-- Logo & Brand -->
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 dark:border-slate-700" :class="{ 'justify-center': sidebarCollapsed }">
            <div class="flex items-center gap-3" :class="{ 'justify-center w-full': sidebarCollapsed }">
                <div class="w-10 h-10 bg-yellow-600 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M24 2C21.8 2 20 3.8 20 6C20 7.5 20.8 8.8 22 9.5V12H18C16.9 12 16 12.9 16 14V16H14C12.9 16 12 16.9 12 18V20H10C8.9 20 8 20.9 8 22V44H40V22C40 20.9 39.1 20 38 20H36V18C36 16.9 35.1 16 34 16H32V14C32 12.9 31.1 12 30 12H26V9.5C27.2 8.8 28 7.5 28 6C28 3.8 26.2 2 24 2ZM24 5C24.6 5 25 5.4 25 6C25 6.6 24.6 7 24 7C23.4 7 23 6.6 23 6C23 5.4 23.4 5 24 5ZM20 23H28V44H20V23ZM12 23H18V44H12V23ZM30 23H36V44H30V23Z"/>
                    </svg>
                </div>
                <div :class="{ 'hidden': sidebarCollapsed }">
                    <div class="text-sm font-extrabold text-gray-900 dark:text-white">Basmallah</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Masjid System</div>
                </div>
            </div>
            <!-- Toggle Button -->
            <button @click="sidebarCollapsed = !sidebarCollapsed" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors" :class="{ 'hidden': sidebarCollapsed }">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
            </button>
        </div>

        @role('Super Admin|Viewer')
        <!-- Masjid Switcher (Super Admin & Viewer) -->
        <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700">
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 text-sm bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-900/30 transition-colors">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span class="font-medium">
                            @if(session('active_masjid_id'))
                                {{ \App\Models\Masjid::find(session('active_masjid_id'))->name }}
                            @else
                                All Masjids
                            @endif
                        </span>
                    </div>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" x-transition class="absolute top-full left-0 right-0 mt-2 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden z-50">
                    @if(session('active_masjid_id'))
                    <form method="POST" action="{{ route('masjid.clear') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            View All Masjids
                        </button>
                    </form>
                    <div class="border-t border-gray-200 dark:border-slate-700"></div>
                    @endif
                    @foreach(\App\Models\Masjid::all() as $masjid)
                    <form method="POST" action="{{ route('masjid.switch') }}">
                        @csrf
                        <input type="hidden" name="masjid_id" value="{{ $masjid->id }}">
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors {{ session('active_masjid_id') == $masjid->id ? 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            {{ $masjid->nama }}
                        </button>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
        @endrole

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-1" :class="{ 'px-2': sidebarCollapsed, 'px-4': !sidebarCollapsed }">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" :class="{ 'justify-center': sidebarCollapsed }" title="{{ __('navigation.dashboard') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="font-medium">{{ __('navigation.dashboard') }}</span>
            </a>

            <!-- Divider -->
            <div class="pt-4 pb-2">
                <div class="border-t border-gray-200 dark:border-slate-700"></div>
            </div>

            @can('view categories')
            <!-- Categories -->
            <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all {{ request()->routeIs('categories.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" :class="{ 'justify-center': sidebarCollapsed }" title="{{ __('navigation.categories') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="font-medium">{{ __('navigation.categories') }}</span>
            </a>
            @endcan

            @can('view budgets')
            <!-- Budgets -->
            <a href="{{ route('budgets.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all {{ request()->routeIs('budgets.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}" :class="{ 'justify-center': sidebarCollapsed }" title="{{ __('navigation.budgets') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="font-medium">{{ __('navigation.budgets') }}</span>
            </a>
            @endcan

            <!-- Divider -->
            <div class="pt-4 pb-2">
                <div class="border-t border-gray-200 dark:border-slate-700"></div>
            </div>

            @can('view accounts')
            <!-- Accounts -->
            <a href="{{ route('accounts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('accounts.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <span class="font-medium">{{ __('navigation.accounts') }}</span>
            </a>
            @endcan

            @can('view transactions')
            <!-- Transactions -->
            <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('transactions.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="font-medium">{{ __('navigation.transactions') }}</span>
            </a>
            @endcan

            @can('view goals')
            <!-- Goals -->
            <a href="{{ route('goals.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('goals.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">{{ __('navigation.goals') }}</span>
            </a>
            @endcan

            @can('view calendar')
            <!-- Calendar -->
            <a href="{{ route('calendar.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('calendar.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="font-medium">{{ __('navigation.calendar') }}</span>
            </a>
            @endcan

            @can('view reports')
            <!-- Reports -->
            <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('reports.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="font-medium">{{ __('navigation.reports') }}</span>
            </a>
            @endcan

            <!-- Divider -->
            <div class="pt-4 pb-2">
                <div class="border-t border-gray-200 dark:border-slate-700"></div>
            </div>

            <!-- Users -->
            @can('manage users')
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span class="font-medium">{{ __('navigation.users') }}</span>
            </a>
            @endcan
        </nav>

        <!-- User Profile -->
        <div class="border-t border-gray-200 dark:border-slate-700 p-4">
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-all">
                    <div class="w-10 h-10 bg-yellow-600 rounded-full flex items-center justify-center text-white font-semibold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 text-left">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" x-transition class="absolute bottom-full left-0 right-0 mb-2 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('navigation.profile') }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors text-left">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="text-sm text-red-600 dark:text-red-400">{{ __('navigation.logout') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toggle Button (All Screens) -->
    <button @click="sidebarOpen = !sidebarOpen" class="fixed top-4 z-50 p-2 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-all"
        :class="sidebarOpen ? 'left-[272px]' : 'left-4'"
        style="transition: left 0.3s ease-in-out;">
        <svg x-show="sidebarOpen" class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
        </svg>
        <svg x-show="!sidebarOpen" x-cloak class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</aside>

<!-- Overlay for mobile -->
<div x-show="sidebarOpen && window.innerWidth < 1024" @click="sidebarOpen = false" class="lg:hidden fixed inset-0 bg-black/50 z-40" x-transition></div>
