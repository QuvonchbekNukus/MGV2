@extends('layouts.admin')

@section('title', 'Qurolni Tahrirlash')
@section('page-title', 'Qurolni Tahrirlash')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.toys.show', $toy) }}" class="text-gray-400 hover:text-white transition-colors">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-white">
                <i class="fas fa-edit text-blue-400 mr-3"></i>Qurolni Tahrirlash
            </h1>
            <p class="text-gray-400 mt-2">{{ $toy->name }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
        <form action="{{ route('admin.toys.update', $toy) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-shield-alt mr-2 text-orange-400"></i>Nomi
                </label>
                <input type="text" name="name" value="{{ old('name', $toy->name) }}"
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
                <input type="text" name="code" value="{{ old('code', $toy->code) }}"
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
                    <input type="text" name="type" value="{{ old('type', $toy->type) }}"
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
                    <input type="text" name="made_in" value="{{ old('made_in', $toy->made_in) }}"
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
                <input type="number" name="made_at" value="{{ old('made_at', $toy->made_at) }}" min="1900" max="{{ date('Y') }}"
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
                <div class="dropdown relative">
                    <input type="text"
                           class="jAuto w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Ism yoki familiya yozing..."
                           autocomplete="off"
                           value="{{ old('id_user') ? \App\Models\User::find(old('id_user'))?->name . ' ' . (\App\Models\User::find(old('id_user'))?->second_name ?? '') . ' ' . (\App\Models\User::find(old('id_user'))?->third_name ?? '') : ($toy->user ? trim($toy->user->name . ' ' . ($toy->user->second_name ?? '') . ' ' . ($toy->user->third_name ?? '')) : '') }}">
                    <input type="hidden" name="id_user" id="selected_user_id" value="{{ old('id_user', $toy->id_user) }}">
                    <div class="dropdown-menu absolute z-50 w-full mt-1 bg-slate-800 border border-slate-600 rounded-lg shadow-xl max-h-60 overflow-y-auto hidden">
                        <i class="hasNoResults block px-4 py-2 text-gray-400 text-sm">Hech narsa topilmadi</i>
                        <div class="list-autocomplete">
                            @foreach($users as $user)
                                <button type="button"
                                        class="dropdown-item w-full text-left px-4 py-3 text-white hover:bg-slate-700 transition-colors border-b border-slate-700 last:border-b-0 hidden"
                                        data-id="{{ $user->id }}"
                                        data-value="{{ trim($user->name . ' ' . ($user->second_name ?? '') . ' ' . ($user->third_name ?? '')) }}">
                                    {{ trim($user->name . ' ' . ($user->second_name ?? '') . ' ' . ($user->third_name ?? '')) }}
                                </button>
                            @endforeach
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
                          placeholder="Qurol haqida batafsil ma'lumot...">{{ old('description', $toy->description) }}</textarea>
                @error('description')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 rounded-lg text-white font-semibold transition-all">
                    <i class="fas fa-save mr-2"></i>Yangilash
                </button>
                <a href="{{ route('admin.toys.show', $toy) }}" class="flex-1 px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white font-semibold text-center transition-all">
                    <i class="fas fa-times mr-2"></i>Bekor qilish
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.list-autocomplete {
    padding: 0;
}
.list-autocomplete em {
    font-style: normal;
    background-color: #10b981;
    color: #fff;
    padding: 2px 0;
}
.hasNoResults {
    color: #9ca3af;
    display: none;
}
.dropdown.open .dropdown-menu {
    display: block !important;
}
.dropdown-item {
    cursor: pointer;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function createAuto(input) {
        var dropdown = input.closest('.dropdown');
        var listContainer = dropdown.querySelector('.list-autocomplete');
        var listItems = listContainer.querySelectorAll('.dropdown-item');
        var hasNoResults = dropdown.querySelector('.hasNoResults');
        var hiddenInput = dropdown.querySelector('input[type="hidden"]');
        var dropdownMenu = dropdown.querySelector('.dropdown-menu');

        // Store original text for each item
        listItems.forEach(function(item) {
            item.dataset.originalText = item.textContent.trim();
        });

        input.addEventListener('input', function(e) {
            if (e.keyCode === 13 || e.key === 'Enter') {
                dropdown.classList.remove('open', 'in');
                return;
            }
            if (e.keyCode === 9 || e.key === 'Tab') {
                return;
            }

            var query = input.value.toLowerCase().trim();

            if (query.length > 0) {
                dropdown.classList.add('open', 'in');
                dropdownMenu.classList.remove('hidden');

                var visibleCount = 0;

                listItems.forEach(function(item) {
                    var text = item.dataset.originalText.toLowerCase();

                    if (text.indexOf(query) > -1) {
                        var textStart = text.indexOf(query);
                        var textEnd = textStart + query.length;
                        var originalText = item.dataset.originalText;
                        var htmlR = originalText.substring(0, textStart) +
                                   '<em>' + originalText.substring(textStart, textEnd) + '</em>' +
                                   originalText.substring(textEnd);
                        item.innerHTML = htmlR;
                        item.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                    }
                });

                if (visibleCount > 0) {
                    hasNoResults.style.display = 'none';
                } else {
                    hasNoResults.style.display = 'block';
                }
            } else {
                listItems.forEach(function(item) {
                    item.classList.add('hidden');
                });
                dropdown.classList.remove('open', 'in');
                dropdownMenu.classList.add('hidden');
                hasNoResults.style.display = 'block';
            }
        });

        listItems.forEach(function(item) {
            item.addEventListener('click', function(e) {
                var txt = this.dataset.originalText;
                input.value = txt;
                hiddenInput.value = this.dataset.id;
                dropdown.classList.remove('open', 'in');
                dropdownMenu.classList.add('hidden');
            });
        });

        // Focus event
        input.addEventListener('focus', function() {
            if (this.value) {
                this.select();
            }
        });

        // Click outside to close
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('open', 'in');
                dropdownMenu.classList.add('hidden');
            }
        });
    }

    // Initialize all autocomplete inputs
    document.querySelectorAll('.jAuto').forEach(function(input) {
        createAuto(input);
    });
});
</script>
@endpush
@endsection
