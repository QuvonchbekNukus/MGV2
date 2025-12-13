<!DOCTYPE html>
<html lang="uz" x-data="{ sidebarOpen: true }" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Harbiy Admin Panel')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Common CSS -->
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @stack('styles')
</head>
<body class="h-full bg-slate-900 text-gray-100">
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside
            :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="sidebar-transition bg-slate-800 border-r border-slate-700 flex-shrink-0 hidden md:flex md:flex-col">

            <!-- Logo -->
            <div class="h-16 flex items-center justify-between px-4 border-b border-slate-700 flex-shrink-0">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shield-alt text-white text-xl"></i>
                    </div>
                    <div x-show="sidebarOpen" x-transition class="text-white font-bold text-lg">
                        ADMIN
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 mt-6 px-3 space-y-1 overflow-y-auto">
                @can('view-dashboard')
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-3 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('admin.dashboard') ? 'nav-item-active' : '' }}">
                    <i class="fas fa-tachometer-alt w-6 text-green-400"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-medium">Dashboard</span>
                </a>
                @endcan

                @can('view-users')
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center px-3 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('admin.users.*') ? 'nav-item-active' : '' }}">
                    <i class="fas fa-users w-6 text-blue-400"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-medium">Askarlar</span>
                </a>
                @endcan

                @can('view-groups')
                <a href="{{ route('admin.groups.index') }}"
                   class="flex items-center px-3 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('admin.groups.*') ? 'nav-item-active' : '' }}">
                    <i class="fas fa-users w-6 text-indigo-400"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-medium">Guruhlar</span>
                </a>
                @endcan

                @if(auth()->user()->can('view-lessons') || auth()->user()->group)
                <div x-data="{ open: {{ request()->routeIs('admin.group-journals.*') ? 'true' : 'false' }} }" class="relative">
                    <button @click="open = !open"
                            class="w-full flex items-center px-3 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('admin.group-journals.*') ? 'nav-item-active' : '' }}">
                        <i class="fas fa-book w-6 text-pink-400"></i>
                        <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-medium flex-1 text-left">Guruh Jurnallari</span>
                        <i x-show="sidebarOpen" x-transition :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-gray-400 text-xs"></i>
                    </button>
                    <div x-show="open && sidebarOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-cloak
                         class="ml-12 mt-1 space-y-1">
                        @if(auth()->user()->can('view-lessons'))
                            @isset($groups)
                                @foreach($groups as $group)
                                    <a href="{{ route('admin.group-journals.show', $group) }}"
                                       class="flex items-center px-3 py-2 rounded-lg hover:bg-slate-700 transition-colors text-sm {{ request()->routeIs('admin.group-journals.show') && request()->route('group') && request()->route('group')->id_group == $group->id_group ? 'bg-slate-700 text-green-400' : 'text-gray-400' }}">
                                        <i class="fas fa-users w-4 text-blue-400"></i>
                                        <span class="ml-2">{{ $group->name }}</span>
                                        @if(request()->routeIs('admin.group-journals.show') && request()->route('group') && request()->route('group')->id_group == $group->id_group)
                                            <i class="fas fa-check-circle ml-auto text-green-400 text-xs"></i>
                                        @endif
                                    </a>
                                @endforeach
                            @endisset
                        @else
                            @if(auth()->user()->group)
                                <a href="{{ route('admin.group-journals.show', auth()->user()->group) }}"
                                   class="flex items-center px-3 py-2 rounded-lg hover:bg-slate-700 transition-colors text-sm {{ request()->routeIs('admin.group-journals.show') && request()->route('group') && request()->route('group')->id_group == auth()->user()->id_group ? 'bg-slate-700 text-green-400' : 'text-gray-400' }}">
                                    <i class="fas fa-users w-4 text-blue-400"></i>
                                    <span class="ml-2">{{ auth()->user()->group->name }}</span>
                                    @if(request()->routeIs('admin.group-journals.show') && request()->route('group') && request()->route('group')->id_group == auth()->user()->id_group)
                                        <i class="fas fa-check-circle ml-auto text-green-400 text-xs"></i>
                                    @endif
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
                @endif

                @can('view-toys')
                <a href="{{ route('admin.toys.index') }}"
                   class="flex items-center px-3 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('admin.toys.*') ? 'nav-item-active' : '' }}">
                    <i class="fas fa-shield-alt w-6 text-orange-400"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-medium">Qurollar</span>
                </a>
                @endcan

                @can('view-activity-logs')
                <a href="{{ route('admin.activities.index') }}"
                   class="flex items-center px-3 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('admin.activities.*') ? 'nav-item-active' : '' }}">
                    <i class="fas fa-history w-6 text-cyan-400"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-medium">Activity Logs</span>
                </a>
                @endcan

                @if(auth()->user()->can('view-roles') || auth()->user()->can('view-permissions'))
                <div x-data="{ open: {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'true' : 'false' }} }" class="relative">
                    <button @click="open = !open"
                            class="w-full flex items-center px-3 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'nav-item-active' : '' }}">
                        <i class="fas fa-cog w-6 text-gray-400"></i>
                        <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-medium flex-1 text-left">Sozlamalar</span>
                        <i x-show="sidebarOpen" x-transition :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-gray-400 text-xs"></i>
                    </button>
                    <div x-show="open && sidebarOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-cloak
                         class="ml-12 mt-1 space-y-1">
                        @can('view-roles')
                        <a href="{{ route('admin.roles.index') }}"
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-slate-700 transition-colors text-sm {{ request()->routeIs('admin.roles.*') ? 'bg-slate-700 text-purple-400' : 'text-gray-400' }}">
                            <i class="fas fa-user-tag w-4 text-purple-400"></i>
                            <span class="ml-2">Rollar</span>
                            @if(request()->routeIs('admin.roles.*'))
                                <i class="fas fa-check-circle ml-auto text-purple-400 text-xs"></i>
                            @endif
                        </a>
                        @endcan

                        @can('view-permissions')
                        <a href="{{ route('admin.permissions.index') }}"
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-slate-700 transition-colors text-sm {{ request()->routeIs('admin.permissions.*') ? 'bg-slate-700 text-yellow-400' : 'text-gray-400' }}">
                            <i class="fas fa-key w-4 text-yellow-400"></i>
                            <span class="ml-2">Ruxsatlar</span>
                            @if(request()->routeIs('admin.permissions.*'))
                                <i class="fas fa-check-circle ml-auto text-yellow-400 text-xs"></i>
                            @endif
                        </a>
                        @endcan
                    </div>
                </div>
                @endif
            </nav>

            <!-- Sidebar Toggle Button -->
            <div class="p-4 border-t border-slate-700 flex-shrink-0">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="w-full flex items-center justify-center py-3 bg-slate-700 hover:bg-slate-600 rounded-lg transition-all group">
                    <i :class="sidebarOpen ? 'fa-angles-left' : 'fa-angles-right'"
                       class="fas text-gray-400 group-hover:text-green-400 transition-colors"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-2 text-sm text-gray-400 group-hover:text-green-400">Yopish</span>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Top Header -->
            <header class="h-16 bg-slate-800 border-b border-slate-700 flex items-center justify-between px-6">
                <!-- Left Side -->
                <div class="flex items-center space-x-4">
                    <!-- Mobile Sidebar Toggle -->
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="md:hidden text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Breadcrumb -->
                    <div class="flex items-center space-x-2 text-sm">
                        <i class="fas fa-home text-gray-400"></i>
                        <span class="text-gray-400">/</span>
                        <span class="text-green-400 font-medium">@yield('page-title', 'Dashboard')</span>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- User Info -->
                    <a href="{{ route('admin.users.show', Auth::user()) }}"
                       class="flex items-center space-x-3 hover:opacity-80 transition-opacity cursor-pointer">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-400">{{ Auth::user()->roles->first()?->name ?? 'User' }}</div>
                        </div>
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg hover:shadow-green-500/50 transition-all">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>Chiqish
                        </button>
                    </form>

                    <!-- Mobile Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="sm:hidden">
                        @csrf
                        <button type="submit"
                                class="w-10 h-10 bg-red-600 hover:bg-red-700 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-slate-900 p-6">

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-20 left-1/2 transform -translate-x-1/2 z-[9999] space-y-2"></div>

    @stack('scripts')

    <!-- Common JS -->
    <script src="{{ asset('js/common.js') }}"></script>

    <!-- Admin JS -->
    <script src="{{ asset('js/admin.js') }}"></script>

    <!-- Session Messages Handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif

            @if(session('error'))
                showToast("{{ session('error') }}", 'error');
            @endif

            @if(session('warning'))
                showToast("{{ session('warning') }}", 'warning');
            @endif

            @if(session('info'))
                showToast("{{ session('info') }}", 'info');
            @endif
        });
    </script>
</body>
</html>
