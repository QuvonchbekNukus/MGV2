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
                <select name="id_user" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-green-500 transition-colors">
                    <option value="">-- Javobgar shaxsni tanlang (ixtiyoriy) --</option>
                    @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}" {{ old('id_user', $toy->id_user) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
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
@endsection
