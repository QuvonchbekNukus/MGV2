@extends('layouts.admin')

@section('title', 'Askar Ma\'lumotlari')
@section('page-title', 'Askar Ma\'lumotlari')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white orbitron mb-2">
                {{ $user->name }}
                @if($user->second_name)
                    {{ $user->second_name }}
                @endif
                @if($user->third_name)
                    {{ $user->third_name }}
                @endif
            </h1>
            <p class="text-gray-400">
                @if($user->id === auth()->id())
                    Mening profilim
                @else
                    Askar to'liq ma'lumotlari va aktivliklari
                @endif
            </p>
        </div>
        <div class="flex space-x-3">
            @if($user->id === auth()->id())
                @can('edit-users')
                <a href="{{ route('admin.users.edit', $user) }}"
                   class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all">
                    <i class="fas fa-edit mr-2"></i>Tahrirlash
                </a>
                @endcan
            @else
                @can('edit-users')
                <a href="{{ route('admin.users.edit', $user) }}"
                   class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all">
                    <i class="fas fa-edit mr-2"></i>Tahrirlash
                </a>
                @endcan
                @can('view-users')
                <a href="{{ route('admin.users.index') }}"
                   class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-all">
                    <i class="fas fa-arrow-left mr-2"></i>Orqaga
                </a>
                @endcan
            @endif
        </div>
    </div>

    <!-- User Profile Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- User Card -->
        <div class="lg:col-span-1">
            <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 backdrop-blur-sm sticky top-6">
                <!-- Avatar -->
                <div class="flex flex-col items-center mb-6">
                    <div class="w-32 h-32 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-4xl mb-4 shadow-lg">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h3 class="text-xl font-bold text-white text-center">{{ $user->name }}</h3>
                    @if($user->second_name || $user->third_name)
                    <p class="text-gray-400 text-sm text-center">
                        {{ $user->second_name ?? '' }} {{ $user->third_name ?? '' }}
                    </p>
                    @endif
                    <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                    @if($user->username)
                    <p class="text-gray-500 text-xs mt-1">{{ $user->username }}</p>
                    @endif
                </div>

                <!-- Status Badge -->
                <div class="mb-6 flex justify-center">
                    @if($user->is_active)
                        <span class="px-4 py-2 text-sm rounded-full bg-green-500/20 text-green-400 border border-green-500 font-medium">
                            <i class="fas fa-check-circle mr-2"></i>Faol
                        </span>
                    @else
                        <span class="px-4 py-2 text-sm rounded-full bg-red-500/20 text-red-400 border border-red-500 font-medium">
                            <i class="fas fa-times-circle mr-2"></i>Nofaol
                        </span>
                    @endif
                </div>

                <!-- Quick Info -->
                <div class="space-y-4 border-t border-slate-700 pt-6">
                    @if($user->phone)
                    <div class="flex items-center text-gray-300">
                        <i class="fas fa-phone w-6 text-green-400"></i>
                        <span class="ml-3 text-sm">{{ $user->phone }}</span>
                    </div>
                    @endif

                    @if($user->group)
                    <div class="flex items-center text-gray-300">
                        <i class="fas fa-users w-6 text-blue-400"></i>
                        <span class="ml-3 text-sm">{{ $user->group->name }}</span>
                    </div>
                    @endif

                    <div class="flex items-center text-gray-300">
                        <i class="fas fa-calendar w-6 text-purple-400"></i>
                        <div class="ml-3 flex-1">
                            <div class="text-xs text-gray-500">Ro'yxatdan o'tgan</div>
                            <div class="text-sm">{{ $user->created_at->format('d.m.Y') }}</div>
                        </div>
                    </div>

                    @if($user->last_login_at)
                    <div class="flex items-center text-gray-300">
                        <i class="fas fa-clock w-6 text-cyan-400"></i>
                        <div class="ml-3 flex-1">
                            <div class="text-xs text-gray-500">Oxirgi kirish</div>
                            <div class="text-sm">{{ $user->last_login_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Asosiy Ma'lumotlar -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 backdrop-blur-sm">
                <h2 class="text-xl font-bold text-white mb-4 pb-2 border-b border-slate-700">
                    <i class="fas fa-user mr-2"></i>Asosiy Ma'lumotlar
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-gray-400">Ism</label>
                        <p class="text-white font-medium mt-1">{{ $user->name }}</p>
                    </div>
                    @if($user->second_name)
                    <div>
                        <label class="text-sm text-gray-400">Familiya</label>
                        <p class="text-white font-medium mt-1">{{ $user->second_name }}</p>
                    </div>
                    @endif
                    @if($user->third_name)
                    <div>
                        <label class="text-sm text-gray-400">Otasining ismi</label>
                        <p class="text-white font-medium mt-1">{{ $user->third_name }}</p>
                    </div>
                    @endif
                    @if($user->username)
                    <div>
                        <label class="text-sm text-gray-400">Username</label>
                        <p class="text-white font-medium mt-1">{{ $user->username }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="text-sm text-gray-400">Email</label>
                        <p class="text-white font-medium mt-1">{{ $user->email }}</p>
                    </div>
                    @if($user->phone)
                    <div>
                        <label class="text-sm text-gray-400">Telefon</label>
                        <p class="text-white font-medium mt-1">{{ $user->phone }}</p>
                    </div>
                    @endif
                    @if($user->jinsi)
                    <div>
                        <label class="text-sm text-gray-400">Jinsi</label>
                        <p class="text-white font-medium mt-1 capitalize">{{ $user->jinsi }}</p>
                    </div>
                    @endif
                    @if($user->address)
                    <div class="md:col-span-2">
                        <label class="text-sm text-gray-400">Manzil</label>
                        <p class="text-white font-medium mt-1">{{ $user->address }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Harbiy Ma'lumotlar -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 backdrop-blur-sm">
                <h2 class="text-xl font-bold text-white mb-4 pb-2 border-b border-slate-700">
                    <i class="fas fa-shield-alt mr-2"></i>Harbiy Ma'lumotlar
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($user->rank)
                    <div>
                        <label class="text-sm text-gray-400">Unvon</label>
                        <p class="text-white font-medium mt-1">{{ $user->rank }}</p>
                    </div>
                    @endif
                    @if($user->job_title)
                    <div>
                        <label class="text-sm text-gray-400">Lavozim</label>
                        <p class="text-white font-medium mt-1">{{ $user->job_title }}</p>
                    </div>
                    @endif
                    @if($user->group)
                    <div>
                        <label class="text-sm text-gray-400">Guruh</label>
                        <p class="text-white font-medium mt-1">{{ $user->group->name }}</p>
                    </div>
                    @endif
                    @if($user->job_responsibility)
                    <div class="md:col-span-2">
                        <label class="text-sm text-gray-400">Vazifa va Mas'uliyat</label>
                        <p class="text-white font-medium mt-1">{{ $user->job_responsibility }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Shaxsiy Ma'lumotlar -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 backdrop-blur-sm">
                <h2 class="text-xl font-bold text-white mb-4 pb-2 border-b border-slate-700">
                    <i class="fas fa-id-card mr-2"></i>Shaxsiy Ma'lumotlar
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($user->passport_seria)
                    <div>
                        <label class="text-sm text-gray-400">Pasport Seriyasi</label>
                        <p class="text-white font-medium mt-1">{{ $user->passport_seria }}</p>
                    </div>
                    @endif
                    @if($user->passport_code)
                    <div>
                        <label class="text-sm text-gray-400">Pasport Raqami</label>
                        <p class="text-white font-medium mt-1">{{ $user->passport_code }}</p>
                    </div>
                    @endif
                    @if($user->degree)
                    <div>
                        <label class="text-sm text-gray-400">Ma'lumoti</label>
                        <p class="text-white font-medium mt-1">{{ $user->degree }}</p>
                    </div>
                    @endif
                    @if($user->height)
                    <div>
                        <label class="text-sm text-gray-400">Bo'y (sm)</label>
                        <p class="text-white font-medium mt-1">{{ $user->height }} sm</p>
                    </div>
                    @endif
                    @if($user->weight)
                    <div>
                        <label class="text-sm text-gray-400">Vazn (kg)</label>
                        <p class="text-white font-medium mt-1">{{ $user->weight }} kg</p>
                    </div>
                    @endif
                    @if($user->license_code)
                    <div>
                        <label class="text-sm text-gray-400">Guvohnoma Raqami</label>
                        <p class="text-white font-medium mt-1">{{ $user->license_code }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="text-sm text-gray-400">Oilaviy Holati</label>
                        <p class="text-white font-medium mt-1">
                            @if($user->is_married)
                                <span class="px-3 py-1 text-sm rounded-full bg-pink-500/20 text-pink-400 border border-pink-500">
                                    <i class="fas fa-heart mr-1"></i>Uylangan
                                </span>
                            @else
                                <span class="px-3 py-1 text-sm rounded-full bg-gray-500/20 text-gray-400 border border-gray-500">
                                    <i class="fas fa-user mr-1"></i>Bo'ydoq
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Qurollar (Toys) -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 backdrop-blur-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-white pb-2 border-b border-slate-700 flex-1">
                        <i class="fas fa-shield-alt mr-2"></i>Qurollar
                    </h2>
                    <span class="px-3 py-1 text-sm rounded-full bg-orange-500/20 text-orange-400 border border-orange-500 ml-4">
                        {{ $user->toys->count() }} ta
                    </span>
                </div>
                @if($user->toys->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($user->toys as $toy)
                            <div class="bg-slate-700/50 border border-slate-600 rounded-lg p-4 hover:border-orange-500 transition-all">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-white mb-1">
                                            <i class="fas fa-shield-alt text-orange-400 mr-2"></i>{{ $toy->name }}
                                        </h3>
                                        @if($toy->code)
                                        <p class="text-sm text-gray-400">
                                            <i class="fas fa-hashtag mr-1"></i>Kod: {{ $toy->code }}
                                        </p>
                                        @endif
                                    </div>
                                    @can('view-toys')
                                    <a href="{{ route('admin.toys.show', $toy) }}"
                                       class="p-2 bg-orange-600/20 hover:bg-orange-600/30 rounded-lg text-orange-400 transition-all"
                                       title="Batafsil">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endcan
                                </div>
                                <div class="grid grid-cols-2 gap-3 text-sm">
                                    @if($toy->type)
                                    <div>
                                        <label class="text-xs text-gray-400">Turi</label>
                                        <p class="text-white font-medium mt-1">{{ $toy->type }}</p>
                                    </div>
                                    @endif
                                    @if($toy->made_at)
                                    <div>
                                        <label class="text-xs text-gray-400">Ishlab chiqarilgan yili</label>
                                        <p class="text-white font-medium mt-1">{{ $toy->made_at }}</p>
                                    </div>
                                    @endif
                                    @if($toy->made_in)
                                    <div class="col-span-2">
                                        <label class="text-xs text-gray-400">Ishlab chiqarilgan joyi</label>
                                        <p class="text-white font-medium mt-1">{{ $toy->made_in }}</p>
                                    </div>
                                    @endif
                                    @if($toy->description)
                                    <div class="col-span-2">
                                        <label class="text-xs text-gray-400">Tavsif</label>
                                        <p class="text-white font-medium mt-1 text-sm">{{ Str::limit($toy->description, 100) }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <i class="fas fa-shield-alt text-4xl mb-3"></i>
                        <p class="text-sm">Qurollar biriktirilmagan</p>
                    </div>
                @endif
            </div>

            <!-- Activity Statistics Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Total Activities -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg p-4 text-white">
                    <div class="text-3xl font-bold">{{ $activityStats['total'] }}</div>
                    <div class="text-sm text-blue-100 mt-1">Jami Amallar</div>
                </div>

                <!-- Today Activities -->
                <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-lg p-4 text-white">
                    <div class="text-3xl font-bold">{{ $activityStats['today'] }}</div>
                    <div class="text-sm text-green-100 mt-1">Bugungi</div>
                </div>

                <!-- Week Activities -->
                <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-lg p-4 text-white">
                    <div class="text-3xl font-bold">{{ $activityStats['week'] }}</div>
                    <div class="text-sm text-purple-100 mt-1">Haftalik</div>
                </div>

                <!-- Login Count -->
                <div class="bg-gradient-to-br from-cyan-600 to-cyan-700 rounded-lg p-4 text-white">
                    <div class="text-3xl font-bold">{{ $activityStats['login'] }}</div>
                    <div class="text-sm text-cyan-100 mt-1">Kirishlar</div>
                </div>
            </div>

            <!-- Action Type Statistics -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-slate-800/50 border border-green-500/30 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-2xl font-bold text-white">{{ $activityStats['create'] }}</div>
                            <div class="text-sm text-gray-400">Yaratilgan</div>
                        </div>
                        <i class="fas fa-plus-circle text-3xl text-green-400"></i>
                    </div>
                </div>

                <div class="bg-slate-800/50 border border-blue-500/30 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-2xl font-bold text-white">{{ $activityStats['update'] }}</div>
                            <div class="text-sm text-gray-400">Yangilangan</div>
                        </div>
                        <i class="fas fa-edit text-3xl text-blue-400"></i>
                    </div>
                </div>

                <div class="bg-slate-800/50 border border-red-500/30 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-2xl font-bold text-white">{{ $activityStats['delete'] }}</div>
                            <div class="text-sm text-gray-400">O'chirilgan</div>
                        </div>
                        <i class="fas fa-trash text-3xl text-red-400"></i>
                    </div>
                </div>
            </div>

            <!-- Roles & Permissions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Roles Card -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 backdrop-blur-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-user-tag text-purple-400 mr-2"></i>Rollar
                        </h3>
                        <span class="px-3 py-1 text-sm rounded-full bg-purple-500/20 text-purple-400 border border-purple-500">
                            {{ $user->roles->count() }}
                        </span>
                    </div>
                    <div class="space-y-2">
                        @forelse($user->roles as $role)
                            <div class="p-3 bg-slate-700/50 border border-slate-600 rounded-lg">
                                <div class="font-semibold text-white">{{ $role->name }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $role->permissions->count() }} ta ruxsat</div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-gray-400">
                                <i class="fas fa-info-circle text-2xl mb-2"></i>
                                <p class="text-sm">Rol biriktirilmagan</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Permissions Card -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 backdrop-blur-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-key text-yellow-400 mr-2"></i>Ruxsatlar
                        </h3>
                        <span class="px-3 py-1 text-sm rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500">
                            {{ $user->getAllPermissions()->count() }}
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-2 max-h-64 overflow-y-auto">
                        @forelse($user->getAllPermissions() as $permission)
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500">
                                {{ $permission->name }}
                            </span>
                        @empty
                            <div class="w-full text-center py-6 text-gray-400">
                                <i class="fas fa-info-circle text-2xl mb-2"></i>
                                <p class="text-sm">Ruxsatlar mavjud emas</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Activity Logs Section -->
            <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm">
                <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-history text-cyan-400 mr-2"></i>
                        Barcha Harakatlar
                    </h3>
                    @can('delete-activity-logs')
                    <button onclick="deleteAllUserActivities({{ $user->id }})"
                            class="px-4 py-2 bg-red-600/20 border border-red-500/50 rounded-lg text-red-400 hover:bg-red-600/30 transition-all text-sm">
                        <i class="fas fa-trash-alt mr-2"></i>Barchasini O'chirish
                    </button>
                    @endcan
                </div>

                <div class="p-6">
                    @if($activities->count() > 0)
                        <div class="space-y-4">
                            @foreach($activities as $activity)
                                <div class="flex items-start space-x-4 p-4 bg-slate-900/50 border border-slate-700 rounded-lg hover:bg-slate-700/30 transition-all group">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center
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
                                        <p class="text-white font-medium">{{ $activity->description }}</p>
                                        <div class="flex flex-wrap items-center gap-4 mt-2 text-xs text-gray-400">
                                            <span><i class="fas fa-{{ $activity->device == 'Mobile' ? 'mobile-alt' : 'desktop' }} mr-1"></i>{{ $activity->device }}</span>
                                            <span><i class="fab fa-{{ strtolower($activity->browser) }} mr-1"></i>{{ $activity->browser }}</span>
                                            <span><i class="fas fa-network-wired mr-1"></i>{{ $activity->ip_address }}</span>
                                            <span><i class="fas fa-clock mr-1"></i>{{ $activity->created_at->format('d.m.Y H:i') }}</span>
                                        </div>
                                        @if($activity->properties && count($activity->properties) > 0)
                                        <div class="mt-3 p-3 bg-slate-800 border border-slate-600 rounded text-xs">
                                            <details>
                                                <summary class="cursor-pointer text-gray-400 hover:text-white">O'zgarishlarni ko'rish</summary>
                                                <pre class="mt-2 text-gray-300 overflow-auto">{{ json_encode($activity->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </details>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex-shrink-0 flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.activities.show', $activity) }}"
                                           class="p-2 bg-blue-600/20 hover:bg-blue-600/30 rounded-lg text-blue-400 transition-all"
                                           title="Batafsil">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('delete-activity-logs')
                                        <form action="{{ route('admin.activities.destroy', $activity) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Bu logni o\'chirmoqchimisiz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 bg-red-600/20 hover:bg-red-600/30 rounded-lg text-red-400 transition-all"
                                                    title="O'chirish">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $activities->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-history text-6xl text-gray-600 mb-4"></i>
                            <p class="text-gray-400 text-lg">Hozircha aktivlik yo'q</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@can('delete-activity-logs')
<script>
function deleteAllUserActivities(userId) {
    if (!confirm('Bu askarning BARCHA aktivliklarini o\'chirmoqchimisiz? Bu amalni qaytarib bo\'lmaydi!')) {
        return;
    }

    fetch(`/admin/users/${userId}/activities/delete-all`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Xatolik yuz berdi!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Xatolik yuz berdi!');
    });
}
</script>
@endcan

@if(session('success'))
<div class="fixed top-4 right-4 bg-green-500/20 border border-green-500 text-green-400 px-6 py-3 rounded-lg shadow-lg z-50">
    <i class="fas fa-check-circle mr-2"></i>
    {{ session('success') }}
</div>
@endif

@endsection
