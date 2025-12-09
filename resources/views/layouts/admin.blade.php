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

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        ::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Sidebar Animation */
        .sidebar-transition {
            transition: width 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Gradient Backgrounds */
        .gradient-primary {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        .gradient-success {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        }

        .gradient-warning {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        }

        .gradient-danger {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        }

        .gradient-info {
            background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%);
        }

        /* Card Hover Effect */
        .stat-card {
            transition: transform 300ms, box-shadow 300ms;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }

        /* Active Nav Item */
        .nav-item-active {
            background: linear-gradient(90deg, #10b981 0%, transparent 100%);
            border-left: 4px solid #10b981;
        }
    </style>

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
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-medium">Foydalanuvchilar</span>
                </a>
                @endcan

                @can('view-roles')
                <a href="{{ route('admin.roles.index') }}"
                   class="flex items-center px-3 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('admin.roles.*') ? 'nav-item-active' : '' }}">
                    <i class="fas fa-user-tag w-6 text-purple-400"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-medium">Rollar</span>
                </a>
                @endcan

                @can('view-permissions')
                <a href="{{ route('admin.permissions.index') }}"
                   class="flex items-center px-3 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('admin.permissions.*') ? 'nav-item-active' : '' }}">
                    <i class="fas fa-key w-6 text-yellow-400"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-medium">Ruxsatlar</span>
                </a>
                @endcan

                @can('view-groups')
                <a href="{{ route('admin.groups.index') }}"
                   class="flex items-center px-3 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('admin.groups.*') ? 'nav-item-active' : '' }}">
                    <i class="fas fa-users w-6 text-indigo-400"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-medium">Guruhlar</span>
                </a>
                @endcan

                @can('view-lessons')
                <a href="{{ route('admin.lessons.index') }}"
                   class="flex items-center px-3 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('admin.lessons.*') ? 'nav-item-active' : '' }}">
                    <i class="fas fa-book w-6 text-pink-400"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-medium">Darslar</span>
                </a>
                @endcan

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

                @can('view-settings')
                <a href="#"
                   class="flex items-center px-3 py-3 rounded-lg hover:bg-slate-700 transition-colors">
                    <i class="fas fa-cog w-6 text-gray-400"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-medium">Sozlamalar</span>
                </a>
                @endcan
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
                    <div class="flex items-center space-x-3">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-400">{{ Auth::user()->roles->first()?->name ?? 'User' }}</div>
                        </div>
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>

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

    <!-- Toast Notification Script -->
    <script>
        // Toast Notification Function
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');

            const colors = {
                success: 'from-green-600 to-green-700 border-green-500',
                error: 'from-red-600 to-red-700 border-red-500',
                warning: 'from-yellow-600 to-yellow-700 border-yellow-500',
                info: 'from-blue-600 to-blue-700 border-blue-500'
            };

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-times-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };

            toast.className = `toast-item bg-gradient-to-r ${colors[type] || colors.success} border-2 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 min-w-[300px] max-w-md animate-slide-down`;
            toast.innerHTML = `
                <i class="fas ${icons[type] || icons.success} text-2xl"></i>
                <span class="flex-1 font-medium">${message}</span>
                <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            `;

            container.appendChild(toast);

            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        // Show toasts on page load if there are session messages
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
    </script>

    <style>
        @keyframes slide-down {
            from {
                opacity: 0;
                transform: translateY(-100px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-down {
            animation: slide-down 0.3s ease-out;
        }

        .toast-item {
            transition: all 0.3s ease-out;
        }
    </style>
</body>
</html>
