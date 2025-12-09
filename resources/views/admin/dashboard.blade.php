@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-white mb-2 orbitron">Xush kelibsiz, {{ Auth::user()->name }}!</h1>
    <p class="text-gray-400">Bu yerda tizim statistikasi va oxirgi ma'lumotlarni ko'rishingiz mumkin</p>
</div>

<!-- Statistics Cards Row 1 -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Users Card -->
    <div class="stat-card gradient-info rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-blue-100 text-sm mb-1">Jami Foydalanuvchilar</p>
                <p class="text-4xl font-bold">{{ $totalUsers }}</p>
            </div>
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-3xl"></i>
            </div>
        </div>
        <div class="flex items-center text-sm text-blue-100">
            <i class="fas fa-arrow-up mr-2"></i>
            <span>Barcha foydalanuvchilar</span>
        </div>
    </div>

    <!-- Active Users Card -->
    <div class="stat-card gradient-success rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-green-100 text-sm mb-1">Faol Foydalanuvchilar</p>
                <p class="text-4xl font-bold">{{ $activeUsers }}</p>
            </div>
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-user-check text-3xl"></i>
            </div>
        </div>
        <div class="flex items-center text-sm text-green-100">
            <i class="fas fa-check-circle mr-2"></i>
            <span>Aktiv hisoblar</span>
        </div>
    </div>

    <!-- Total Roles Card -->
    <div class="stat-card gradient-warning rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-yellow-100 text-sm mb-1">Jami Rollar</p>
                <p class="text-4xl font-bold">{{ $totalRoles }}</p>
            </div>
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-user-tag text-3xl"></i>
            </div>
        </div>
        <div class="flex items-center text-sm text-yellow-100">
            <i class="fas fa-shield-alt mr-2"></i>
            <span>Rol va huquqlar</span>
        </div>
    </div>

    <!-- Total Permissions Card -->
    <div class="stat-card gradient-danger rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-red-100 text-sm mb-1">Jami Ruxsatlar</p>
                <p class="text-4xl font-bold">{{ $totalPermissions }}</p>
            </div>
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-key text-3xl"></i>
            </div>
        </div>
        <div class="flex items-center text-sm text-red-100">
            <i class="fas fa-lock mr-2"></i>
            <span>Tizim ruxsatlari</span>
        </div>
    </div>
</div>

<!-- Activity Statistics Row -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Today Activities -->
    <div class="bg-gradient-to-br from-cyan-600 to-cyan-700 rounded-xl p-6 text-white shadow-lg stat-card">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-cyan-100 text-sm mb-1">Bugungi Aktivliklar</p>
                <p class="text-4xl font-bold">{{ $todayActivities }}</p>
            </div>
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-calendar-day text-3xl"></i>
            </div>
        </div>
        <div class="flex items-center text-sm text-cyan-100">
            <i class="fas fa-clock mr-2"></i>
            <span>Bugun</span>
        </div>
    </div>

    <!-- Week Activities -->
    <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl p-6 text-white shadow-lg stat-card">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-purple-100 text-sm mb-1">Haftalik Aktivliklar</p>
                <p class="text-4xl font-bold">{{ $weekActivities }}</p>
            </div>
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-calendar-week text-3xl"></i>
            </div>
        </div>
        <div class="flex items-center text-sm text-purple-100">
            <i class="fas fa-history mr-2"></i>
            <span>Oxirgi 7 kun</span>
        </div>
    </div>

    <!-- Create Actions -->
    <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl p-6 text-white shadow-lg stat-card">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-green-100 text-sm mb-1">Yaratilganlar</p>
                <p class="text-4xl font-bold">{{ $createCount }}</p>
            </div>
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-plus-circle text-3xl"></i>
            </div>
        </div>
        <div class="flex items-center text-sm text-green-100">
            <i class="fas fa-arrow-up mr-2"></i>
            <span>Create amallar</span>
        </div>
    </div>

    <!-- Login Actions -->
    <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-xl p-6 text-white shadow-lg stat-card">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-indigo-100 text-sm mb-1">Login Amallar</p>
                <p class="text-4xl font-bold">{{ $loginCount }}</p>
            </div>
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-sign-in-alt text-3xl"></i>
            </div>
        </div>
        <div class="flex items-center text-sm text-indigo-100">
            <i class="fas fa-users mr-2"></i>
            <span>Kirish amallar</span>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    <!-- Recent Activities Widget (2 columns) -->
    <div class="lg:col-span-2">
        <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm">
            <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-history text-cyan-400 mr-2"></i>
                    Oxirgi Aktivliklar
                </h3>
                @can('view-activity-logs')
                <a href="{{ route('admin.activities.index') }}"
                   class="text-sm text-green-400 hover:text-green-300 transition-colors">
                    Barchasini ko'rish <i class="fas fa-arrow-right ml-1"></i>
                </a>
                @endcan
            </div>
            <div class="p-6">
                @if($recentActivities->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentActivities as $activity)
                            <div class="flex items-start space-x-4 p-4 bg-slate-900/50 border border-slate-700 rounded-lg hover:bg-slate-700/30 transition-all">
                                <!-- Icon -->
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center
                                        @if($activity->action_color == 'green') bg-green-500/20
                                        @elseif($activity->action_color == 'blue') bg-blue-500/20
                                        @elseif($activity->action_color == 'red') bg-red-500/20
                                        @elseif($activity->action_color == 'purple') bg-purple-500/20
                                        @elseif($activity->action_color == 'cyan') bg-cyan-500/20
                                        @else bg-gray-500/20
                                        @endif">
                                        <i class="fas {{ $activity->action_icon }}
                                            @if($activity->action_color == 'green') text-green-400
                                            @elseif($activity->action_color == 'blue') text-blue-400
                                            @elseif($activity->action_color == 'red') text-red-400
                                            @elseif($activity->action_color == 'purple') text-purple-400
                                            @elseif($activity->action_color == 'cyan') text-cyan-400
                                            @else text-gray-400
                                            @endif"></i>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-white">{{ $activity->description }}</p>
                                    <div class="flex items-center mt-2 space-x-4 text-xs text-gray-400">
                                        <span><i class="fas fa-user mr-1"></i>{{ $activity->user?->name ?? 'System' }}</span>
                                        <span><i class="fas fa-{{ $activity->device == 'Mobile' ? 'mobile-alt' : 'desktop' }} mr-1"></i>{{ $activity->device }}</span>
                                        <span><i class="fas fa-clock mr-1"></i>{{ $activity->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <!-- Action Badge -->
                                <div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($activity->action_color == 'green') bg-green-500/20 text-green-400
                                        @elseif($activity->action_color == 'blue') bg-blue-500/20 text-blue-400
                                        @elseif($activity->action_color == 'red') bg-red-500/20 text-red-400
                                        @elseif($activity->action_color == 'purple') bg-purple-500/20 text-purple-400
                                        @elseif($activity->action_color == 'cyan') bg-cyan-500/20 text-cyan-400
                                        @else bg-gray-500/20 text-gray-400
                                        @endif">
                                        {{ ucfirst($activity->action) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-history text-4xl text-gray-600 mb-2"></i>
                        <p class="text-gray-400">Hozircha aktivlik yo'q</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Most Active Users Widget (1 column) -->
    <div class="lg:col-span-1">
        <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm">
            <div class="px-6 py-4 border-b border-slate-700">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-fire text-orange-400 mr-2"></i>
                    Eng Faol Foydalanuvchilar
                </h3>
            </div>
            <div class="p-6">
                @if($mostActiveUsers->count() > 0)
                    <div class="space-y-4">
                        @foreach($mostActiveUsers as $index => $activeUser)
                            <div class="flex items-center space-x-4">
                                <!-- Rank -->
                                <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm
                                    @if($index === 0) bg-yellow-500/20 text-yellow-400
                                    @elseif($index === 1) bg-gray-400/20 text-gray-300
                                    @elseif($index === 2) bg-orange-500/20 text-orange-400
                                    @else bg-slate-700 text-gray-400
                                    @endif">
                                    {{ $index + 1 }}
                                </div>

                                <!-- User Info -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-white truncate">
                                        {{ $activeUser->user?->name ?? 'Unknown' }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        <i class="fas fa-bolt mr-1"></i>{{ $activeUser->activity_count }} amal
                                    </p>
                                </div>

                                <!-- Medal Icon -->
                                @if($index < 3)
                                <div class="flex-shrink-0">
                                    <i class="fas fa-medal
                                        @if($index === 0) text-yellow-400
                                        @elseif($index === 1) text-gray-300
                                        @elseif($index === 2) text-orange-400
                                        @endif text-xl"></i>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-users text-4xl text-gray-600 mb-2"></i>
                        <p class="text-gray-400">Ma'lumot yo'q</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Activity Chart -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Activity Trend Chart -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm">
        <div class="px-6 py-4 border-b border-slate-700">
            <h3 class="text-lg font-bold text-white flex items-center">
                <i class="fas fa-chart-line text-green-400 mr-2"></i>
                Aktivlik Grafigi (Oxirgi 7 kun)
            </h3>
        </div>
        <div class="p-6">
            <canvas id="activityChart" height="300"></canvas>
        </div>
    </div>

    <!-- Activity Distribution Chart -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm">
        <div class="px-6 py-4 border-b border-slate-700">
            <h3 class="text-lg font-bold text-white flex items-center">
                <i class="fas fa-chart-pie text-purple-400 mr-2"></i>
                Amal Turlari Bo'yicha
            </h3>
        </div>
        <div class="p-6">
            <canvas id="actionChart" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @can('create-users')
    <a href="{{ route('admin.users.create') }}"
       class="bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 rounded-xl p-6 text-white shadow-lg transition-all transform hover:scale-105">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-user-plus text-2xl"></i>
            </div>
            <div>
                <h4 class="font-bold text-lg">Foydalanuvchi Qo'shish</h4>
                <p class="text-sm text-blue-100">Yangi user yaratish</p>
            </div>
        </div>
    </a>
    @endcan

    @can('create-roles')
    <a href="{{ route('admin.roles.create') }}"
       class="bg-gradient-to-br from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 rounded-xl p-6 text-white shadow-lg transition-all transform hover:scale-105">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-plus-circle text-2xl"></i>
            </div>
            <div>
                <h4 class="font-bold text-lg">Rol Qo'shish</h4>
                <p class="text-sm text-purple-100">Yangi rol yaratish</p>
            </div>
        </div>
    </a>
    @endcan

    @can('view-activity-logs')
    <a href="{{ route('admin.activities.index') }}"
       class="bg-gradient-to-br from-cyan-600 to-cyan-700 hover:from-cyan-500 hover:to-cyan-600 rounded-xl p-6 text-white shadow-lg transition-all transform hover:scale-105">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-history text-2xl"></i>
            </div>
            <div>
                <h4 class="font-bold text-lg">Aktivliklar</h4>
                <p class="text-sm text-cyan-100">Barcha loglarni ko'rish</p>
            </div>
        </div>
    </a>
    @endcan
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Activity Trend Chart (Line)
    const activityCtx = document.getElementById('activityChart').getContext('2d');
    const activityData = @json($last7DaysActivity);

    new Chart(activityCtx, {
        type: 'line',
        data: {
            labels: activityData.map(item => item.date),
            datasets: [{
                label: 'Aktivliklar',
                data: activityData.map(item => item.count),
                borderColor: 'rgb(34, 211, 238)',
                backgroundColor: 'rgba(34, 211, 238, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(34, 211, 238)',
                pointBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgb(34, 211, 238)',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(148, 163, 184, 0.1)'
                    },
                    ticks: {
                        color: '#94a3b8',
                        stepSize: 1
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(148, 163, 184, 0.1)'
                    },
                    ticks: {
                        color: '#94a3b8'
                    }
                }
            }
        }
    });

    // Action Distribution Chart (Doughnut)
    const actionCtx = document.getElementById('actionChart').getContext('2d');
    const actionData = @json($activityByAction);

    const actionColors = {
        'create': 'rgb(34, 197, 94)',
        'update': 'rgb(59, 130, 246)',
        'delete': 'rgb(239, 68, 68)',
        'view': 'rgb(168, 85, 247)',
        'login': 'rgb(34, 211, 238)',
        'logout': 'rgb(156, 163, 175)'
    };

    new Chart(actionCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(actionData).map(key => key.charAt(0).toUpperCase() + key.slice(1)),
            datasets: [{
                data: Object.values(actionData),
                backgroundColor: Object.keys(actionData).map(key => actionColors[key] || 'rgb(156, 163, 175)'),
                borderColor: '#1e293b',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#94a3b8',
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgb(168, 85, 247)',
                    borderWidth: 1
                }
            }
        }
    });
</script>
@endpush
