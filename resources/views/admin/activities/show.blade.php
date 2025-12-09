@extends('layouts.admin')

@section('title', 'Activity Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white orbitron">
                <i class="fas fa-info-circle text-green-400 mr-3"></i>Activity Details
            </h1>
            <p class="text-gray-400 mt-2">Harakatning batafsil ma'lumoti</p>
        </div>
        <a href="{{ route('admin.activities.index') }}" 
           class="px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white transition-all">
            <i class="fas fa-arrow-left mr-2"></i>Orqaga
        </a>
    </div>

    <!-- Main Info -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 backdrop-blur-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Action -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Amal Turi</label>
                <span class="inline-flex px-4 py-2 rounded-lg text-sm font-semibold
                    @if($activity->action_color == 'green') bg-green-500/20 text-green-400
                    @elseif($activity->action_color == 'blue') bg-blue-500/20 text-blue-400
                    @elseif($activity->action_color == 'red') bg-red-500/20 text-red-400
                    @elseif($activity->action_color == 'purple') bg-purple-500/20 text-purple-400
                    @elseif($activity->action_color == 'cyan') bg-cyan-500/20 text-cyan-400
                    @else bg-gray-500/20 text-gray-400
                    @endif">
                    <i class="fas {{ $activity->action_icon }} mr-2"></i>
                    {{ ucfirst($activity->action) }}
                </span>
            </div>

            <!-- User -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Foydalanuvchi</label>
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 bg-green-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-green-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <div class="text-white font-semibold">{{ $activity->user?->name ?? 'Unknown' }}</div>
                        <div class="text-sm text-gray-400">{{ $activity->user?->email ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-sm text-gray-400 mb-2">Tavsif</label>
                <div class="px-4 py-3 bg-slate-900 border border-slate-600 rounded-lg text-white">
                    {{ $activity->description }}
                </div>
            </div>

            <!-- Subject -->
            @if($activity->subject_type)
            <div>
                <label class="block text-sm text-gray-400 mb-2">Model</label>
                <div class="px-4 py-3 bg-slate-900 border border-slate-600 rounded-lg text-white font-mono text-sm">
                    {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                </div>
            </div>
            @endif

            <!-- Date -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Sana va Vaqt</label>
                <div class="px-4 py-3 bg-slate-900 border border-slate-600 rounded-lg text-white">
                    {{ $activity->created_at->format('d M Y, H:i:s') }}
                    <span class="text-sm text-gray-400">({{ $activity->created_at->diffForHumans() }})</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Device Info -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 backdrop-blur-sm">
        <h3 class="text-lg font-bold text-white mb-4 flex items-center">
            <i class="fas fa-laptop text-green-400 mr-2"></i>
            Qurilma Ma'lumotlari
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Device -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Qurilma</label>
                <div class="px-4 py-3 bg-slate-900 border border-slate-600 rounded-lg text-white">
                    <i class="fas fa-{{ $activity->device == 'Mobile' ? 'mobile-alt' : ($activity->device == 'Tablet' ? 'tablet-alt' : 'desktop') }} mr-2 text-green-400"></i>
                    {{ $activity->device }}
                </div>
            </div>

            <!-- Browser -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Brauzer</label>
                <div class="px-4 py-3 bg-slate-900 border border-slate-600 rounded-lg text-white">
                    <i class="fab fa-{{ strtolower($activity->browser) }} mr-2 text-green-400"></i>
                    {{ $activity->browser }}
                </div>
            </div>

            <!-- Platform -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Platforma</label>
                <div class="px-4 py-3 bg-slate-900 border border-slate-600 rounded-lg text-white">
                    <i class="fab fa-{{ $activity->platform == 'Windows' ? 'windows' : ($activity->platform == 'MacOS' ? 'apple' : 'linux') }} mr-2 text-green-400"></i>
                    {{ $activity->platform }}
                </div>
            </div>

            <!-- IP Address -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">IP Manzil</label>
                <div class="px-4 py-3 bg-slate-900 border border-slate-600 rounded-lg text-white font-mono text-sm">
                    {{ $activity->ip_address }}
                </div>
            </div>
        </div>

        <!-- User Agent -->
        @if($activity->user_agent)
        <div class="mt-4">
            <label class="block text-sm text-gray-400 mb-2">User Agent</label>
            <div class="px-4 py-3 bg-slate-900 border border-slate-600 rounded-lg text-gray-400 font-mono text-xs break-all">
                {{ $activity->user_agent }}
            </div>
        </div>
        @endif
    </div>

    <!-- Properties -->
    @if($activity->properties && count($activity->properties) > 0)
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 backdrop-blur-sm">
        <h3 class="text-lg font-bold text-white mb-4 flex items-center">
            <i class="fas fa-code text-green-400 mr-2"></i>
            O'zgarishlar
        </h3>
        
        @if(isset($activity->properties['old']) && isset($activity->properties['new']))
            <!-- Update: Old vs New -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Old Values -->
                <div>
                    <h4 class="text-sm font-semibold text-red-400 mb-2">
                        <i class="fas fa-minus-circle mr-1"></i>Eski Qiymatlar
                    </h4>
                    <div class="bg-slate-900 border border-slate-600 rounded-lg p-4">
                        <pre class="text-xs text-gray-300 overflow-auto">{{ json_encode($activity->properties['old'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>

                <!-- New Values -->
                <div>
                    <h4 class="text-sm font-semibold text-green-400 mb-2">
                        <i class="fas fa-plus-circle mr-1"></i>Yangi Qiymatlar
                    </h4>
                    <div class="bg-slate-900 border border-slate-600 rounded-lg p-4">
                        <pre class="text-xs text-gray-300 overflow-auto">{{ json_encode($activity->properties['new'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            </div>
        @else
            <!-- Other properties -->
            <div class="bg-slate-900 border border-slate-600 rounded-lg p-4">
                <pre class="text-xs text-gray-300 overflow-auto">{{ json_encode($activity->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        @endif
    </div>
    @endif

    <!-- Actions -->
    <div class="flex justify-between">
        <a href="{{ route('admin.activities.index') }}" 
           class="px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white transition-all">
            <i class="fas fa-arrow-left mr-2"></i>Orqaga
        </a>

        @can('delete-activity-logs')
        <form action="{{ route('admin.activities.destroy', $activity) }}" 
              method="POST" 
              onsubmit="return confirm('Logni o\'chirmoqchimisiz?')">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="px-6 py-3 bg-red-600 hover:bg-red-500 rounded-lg text-white transition-all">
                <i class="fas fa-trash mr-2"></i>O'chirish
            </button>
        </form>
        @endcan
    </div>
</div>
@endsection

