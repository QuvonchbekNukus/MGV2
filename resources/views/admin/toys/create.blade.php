@extends('layouts.admin')

@section('title', 'Yangi Qurol')
@section('page-title', 'Yangi Qurol Yaratish')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.toys.index') }}" class="text-gray-400 hover:text-white transition-colors">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-white">
                <i class="fas fa-plus text-green-400 mr-3"></i>Yangi Qurol
            </h1>
            <p class="text-gray-400 mt-2">Yangi qurol/qurollanish qo'shish</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
        <form action="{{ route('admin.toys.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-shield-alt mr-2 text-orange-400"></i>Nomi
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                       placeholder="Masalan: AK-47 Assault Rifle" required>
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Code -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-barcode mr-2 text-blue-400"></i>Kodi (Unique)
                </label>
                <input type="text" name="code" value="{{ old('code') }}"
                       class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                       placeholder="Masalan: AK47-001" required>
                @error('code')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-cube mr-2 text-purple-400"></i>Turi
                    </label>
                    <input type="text" name="type" value="{{ old('type') }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Masalan: Avtomatik Miltiq">
                    @error('type')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Made In -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-flag mr-2 text-red-400"></i>Istehsol Mamlakati
                    </label>
                    <input type="text" name="made_in" value="{{ old('made_in') }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Masalan: Rosiya">
                    @error('made_in')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Made At Year -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-calendar mr-2 text-cyan-400"></i>Istehsol Yili
                </label>
                <input type="number" name="made_at" value="{{ old('made_at') }}" min="1900" max="{{ date('Y') }}"
                       class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                       placeholder="Masalan: 1947">
                @error('made_at')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Responsible User -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-user-check mr-2 text-yellow-400"></i>Javobgar Shaxs
                </label>
                <div class="relative" x-data="userAutocomplete(@json(old('id_user') ? \App\Models\User::find(old('id_user')) : null))">
                    <input type="text" 
                           x-model="searchQuery"
                           @input="searchUsers()"
                           @keydown.arrow-down.prevent="navigateDown()"
                           @keydown.arrow-up.prevent="navigateUp()"
                           @keydown.enter.prevent="selectUser()"
                           @blur="handleBlur()"
                           placeholder="Ism, email yoki username yozing..."
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           autocomplete="off">
                    <input type="hidden" name="id_user" x-model="selectedUserId">
                    
                    <!-- Autocomplete Dropdown -->
                    <div x-show="showSuggestions && suggestions.length > 0" 
                         x-cloak
                         class="absolute z-50 w-full mt-1 bg-slate-800 border border-slate-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        <template x-for="(user, index) in suggestions" :key="user.id">
                            <div @click="selectUser(user)"
                                 @mouseenter="selectedIndex = index"
                                 :class="{
                                     'bg-slate-700': selectedIndex === index,
                                     'bg-slate-800': selectedIndex !== index
                                 }"
                                 class="px-4 py-3 cursor-pointer hover:bg-slate-700 transition-colors border-b border-slate-700 last:border-b-0">
                                <div class="font-medium text-white" x-text="user.full_name"></div>
                                <div class="text-sm text-gray-400" x-text="user.email"></div>
                                <div class="text-xs text-gray-500" x-show="user.username" x-text="'@' + user.username"></div>
                            </div>
                        </template>
                    </div>
                    
                    <!-- Selected User Display -->
                    <div x-show="selectedUser" class="mt-2 px-3 py-2 bg-green-500/20 border border-green-500/50 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-white font-medium" x-text="selectedUser.full_name"></div>
                                <div class="text-sm text-gray-400" x-text="selectedUser.email"></div>
                            </div>
                            <button type="button" @click="clearSelection()" class="text-red-400 hover:text-red-300">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @error('id_user')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-comment mr-2 text-pink-400"></i>Tavsifi
                </label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                          placeholder="Qurol haqida batafsil ma'lumot...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 rounded-lg text-white font-semibold transition-all">
                    <i class="fas fa-save mr-2"></i>Saqlash
                </button>
                <a href="{{ route('admin.toys.index') }}" class="flex-1 px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white font-semibold text-center transition-all">
                    <i class="fas fa-times mr-2"></i>Bekor qilish
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function userAutocomplete(initialUser = null) {
    return {
        searchQuery: initialUser ? (initialUser.name + ' ' + (initialUser.second_name || '') + ' ' + (initialUser.third_name || '')).trim() : '',
        suggestions: [],
        selectedUser: initialUser ? {
            id: initialUser.id,
            name: initialUser.name,
            second_name: initialUser.second_name,
            third_name: initialUser.third_name,
            email: initialUser.email,
            username: initialUser.username,
            full_name: (initialUser.name + ' ' + (initialUser.second_name || '') + ' ' + (initialUser.third_name || '')).trim()
        } : null,
        selectedUserId: initialUser ? initialUser.id : null,
        selectedIndex: -1,
        showSuggestions: false,
        searchTimeout: null,

        async searchUsers() {
            if (this.searchQuery.length < 2) {
                this.suggestions = [];
                this.showSuggestions = false;
                return;
            }

            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`{{ route('admin.users.search') }}?q=${encodeURIComponent(this.searchQuery)}`);
                    const data = await response.json();
                    this.suggestions = data;
                    this.showSuggestions = true;
                    this.selectedIndex = -1;
                } catch (error) {
                    console.error('Search error:', error);
                }
            }, 300);
        },

        selectUser(user = null) {
            if (user || (this.selectedIndex >= 0 && this.suggestions[this.selectedIndex])) {
                const selected = user || this.suggestions[this.selectedIndex];
                this.selectedUser = selected;
                this.selectedUserId = selected.id;
                this.searchQuery = selected.full_name;
                this.showSuggestions = false;
                this.suggestions = [];
            }
        },

        navigateDown() {
            if (this.selectedIndex < this.suggestions.length - 1) {
                this.selectedIndex++;
            }
        },

        navigateUp() {
            if (this.selectedIndex > 0) {
                this.selectedIndex--;
            }
        },

        clearSelection() {
            this.selectedUser = null;
            this.selectedUserId = null;
            this.searchQuery = '';
            this.suggestions = [];
            this.showSuggestions = false;
        },

        handleBlur() {
            // Blur event dan keyin biroz kutish (click event uchun)
            setTimeout(() => {
                this.showSuggestions = false;
            }, 200);
        }
    }
}
</script>
@endpush
@endsection
