@extends('layouts.admin')

@section('title', 'Activity Logs')

@section('content')
<div class="space-y-6">
    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-green-500/20 border border-green-500/50 rounded-lg p-4 text-green-400 flex items-center justify-between"
         id="successAlert">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-3 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="document.getElementById('successAlert').remove()"
                class="text-green-400 hover:text-green-300">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-4 text-red-400 flex items-center justify-between"
         id="errorAlert">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
        <button onclick="document.getElementById('errorAlert').remove()"
                class="text-red-400 hover:text-red-300">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('info'))
    <div class="bg-blue-500/20 border border-blue-500/50 rounded-lg p-4 text-blue-400 flex items-center justify-between"
         id="infoAlert">
        <div class="flex items-center">
            <i class="fas fa-info-circle mr-3 text-lg"></i>
            <span>{{ session('info') }}</span>
        </div>
        <button onclick="document.getElementById('infoAlert').remove()"
                class="text-blue-400 hover:text-blue-300">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white orbitron">
                <i class="fas fa-history text-green-400 mr-3"></i>Activity Logs
            </h1>
            <p class="text-gray-400 mt-2">Tizimda amalga oshirilgan barcha amallar jurnali</p>
        </div>

        @can('delete-activity-logs')
        <div>
            <button onclick="document.getElementById('cleanupModal').classList.remove('hidden')"
                    class="px-6 py-3 bg-red-600/20 border border-red-500/50 rounded-lg text-red-400 hover:bg-red-600/30 transition-all">
                <i class="fas fa-trash-alt mr-2"></i>
                Eski Loglarni O'chirish
            </button>
        </div>
        @endcan
    </div>

    <!-- Filters -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 backdrop-blur-sm">
        <form method="GET" action="{{ route('admin.activities.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Qidiruv</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Tavsifda qidirish..."
                       class="w-full px-4 py-2 bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-green-500 focus:ring-1 focus:ring-green-500">
            </div>

            <!-- User Filter -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Foydalanuvchi</label>
                <select name="user_id"
                        class="w-full px-4 py-2 bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-green-500 focus:ring-1 focus:ring-green-500">
                    <option value="">Hammasi</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Filter -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Amal</label>
                <select name="action"
                        class="w-full px-4 py-2 bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-green-500 focus:ring-1 focus:ring-green-500">
                    <option value="">Hammasi</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ ucfirst($action) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date From -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Sana (dan)</label>
                <input type="date"
                       name="date_from"
                       value="{{ request('date_from') }}"
                       class="w-full px-4 py-2 bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-green-500 focus:ring-1 focus:ring-green-500">
            </div>

            <!-- Date To -->
            <div>
                <label class="block text-sm text-gray-400 mb-2">Sana (gacha)</label>
                <input type="date"
                       name="date_to"
                       value="{{ request('date_to') }}"
                       class="w-full px-4 py-2 bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-green-500 focus:ring-1 focus:ring-green-500">
            </div>

            <!-- Buttons -->
            <div class="flex items-end gap-2 md:col-span-2 lg:col-span-2">
                <button type="submit"
                        class="flex-1 px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 rounded-lg text-white font-semibold transition-all">
                    <i class="fas fa-filter mr-2"></i>Filtr
                </button>
                <a href="{{ route('admin.activities.index') }}"
                   class="px-6 py-2 bg-slate-700 hover:bg-slate-600 rounded-lg text-white transition-all">
                    <i class="fas fa-redo mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Activity List -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm overflow-hidden">
        @if($activities->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-900/50 border-b border-slate-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Amal
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Tavsif
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Foydalanuvchi
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Qurilma
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                IP Address
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Vaqt
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                Amallar
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @foreach($activities as $activity)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($activity->action_color == 'green') bg-green-500/20 text-green-400
                                        @elseif($activity->action_color == 'blue') bg-blue-500/20 text-blue-400
                                        @elseif($activity->action_color == 'red') bg-red-500/20 text-red-400
                                        @elseif($activity->action_color == 'purple') bg-purple-500/20 text-purple-400
                                        @elseif($activity->action_color == 'cyan') bg-cyan-500/20 text-cyan-400
                                        @else bg-gray-500/20 text-gray-400
                                        @endif">
                                        <i class="fas {{ $activity->action_icon }} mr-1"></i>
                                        {{ ucfirst($activity->action) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-white">{{ $activity->description }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-green-500/20 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-green-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-white">{{ $activity->user?->name ?? 'Unknown' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-400">
                                        <i class="fas fa-{{ $activity->device == 'Mobile' ? 'mobile-alt' : ($activity->device == 'Tablet' ? 'tablet-alt' : 'desktop') }} mr-1"></i>
                                        {{ $activity->device }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $activity->browser }} / {{ $activity->platform }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-400 font-mono">{{ $activity->ip_address }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                    <div>{{ $activity->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $activity->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.activities.show', $activity) }}"
                                           class="text-blue-400 hover:text-blue-300 transition-colors"
                                           title="Batafsil">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('delete-activity-logs')
                                            <button type="button"
                                                    onclick="openDeleteModal({{ $activity->id }}, '{{ addslashes($activity->description) }}')"
                                                    class="text-red-400 hover:text-red-300 transition-colors"
                                                    title="O'chirish">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-slate-900/50 border-t border-slate-700">
                {{ $activities->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <i class="fas fa-history text-6xl text-gray-600 mb-4"></i>
                <p class="text-gray-400 text-lg">Hech qanday aktivlik topilmadi</p>
            </div>
        @endif
    </div>
</div>

<!-- Cleanup Modal -->
<div id="cleanupModal"
     class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center"
     onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-slate-800 border border-slate-700 rounded-lg p-6 max-w-md w-full mx-4" onclick="event.stopPropagation()">
        <h3 class="text-xl font-bold text-white mb-4">
            <i class="fas fa-trash-alt text-red-400 mr-2"></i>
            Eski Loglarni O'chirish
        </h3>
        <p class="text-gray-400 text-sm mb-4">
            Belgilangan kundan eski barcha activity loglar o'chiriladi. Bu amalni qaytarib bo'lmaydi!
        </p>
        <form action="{{ route('admin.activities.cleanup') }}" method="POST" onsubmit="if (!confirm('Haqiqatan ham o\'chirmoqchimisiz?\n\nBu amalni qaytarib bo\'lmaydi!')) return false;">
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-gray-400 mb-2">Necha kundan eski loglarni o'chirish?</label>
                <input type="number"
                       name="days"
                       value="30"
                       min="0"
                       max="3650"
                       class="w-full px-4 py-2 bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-green-500 focus:ring-1 focus:ring-green-500"
                       required>
                <p class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-info-circle mr-1"></i>
                    Masalan: 30 kun yoki undan eski. 0 = barcha loglar o'chib ketadi
                </p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button"
                        onclick="document.getElementById('cleanupModal').classList.add('hidden')"
                        class="px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-lg text-white transition-colors">
                    Bekor qilish
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 hover:bg-red-500 rounded-lg text-white transition-colors">
                    <i class="fas fa-trash-alt mr-2"></i>O'chirish
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Single Log Modal -->
<div id="deleteModal"
     class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-slate-800 border border-slate-700 rounded-lg p-6 max-w-md w-full mx-4 animate-scale-in">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center mr-4">
                <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
            </div>
            <h3 class="text-xl font-bold text-white">
                Logni O'chirish
            </h3>
        </div>

        <p class="text-gray-400 text-sm mb-4">
            Quyidagi activity logni o'chirmoqchimisiz?
        </p>

        <div class="bg-slate-900/50 border border-slate-700 rounded-lg p-4 mb-6">
            <p class="text-white text-sm" id="deleteLogDescription"></p>
        </div>

        <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-3 mb-6">
            <p class="text-yellow-400 text-xs">
                <i class="fas fa-info-circle mr-1"></i>
                Bu amalni qaytarib bo'lmaydi!
            </p>
        </div>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-3">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-lg text-white transition-colors">
                    <i class="fas fa-times mr-2"></i>Bekor qilish
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 hover:bg-red-500 rounded-lg text-white transition-colors">
                    <i class="fas fa-trash-alt mr-2"></i>Ha, O'chirish
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openDeleteModal(activityId, description) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const descElement = document.getElementById('deleteLogDescription');

    // Set form action
    form.action = `/admin/activities/${activityId}`;

    // Set description
    descElement.textContent = description;

    // Show modal
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
}
</script>

<style>
@keyframes scale-in {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-scale-in {
    animation: scale-in 0.2s ease-out;
}
</style>
@endsection

