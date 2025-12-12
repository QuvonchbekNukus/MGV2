@extends('layouts.admin')

@section('title', 'Foydalanuvchini Tahrirlash')
@section('page-title', 'Foydalanuvchini Tahrirlash')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Foydalanuvchini Tahrirlash</h1>
            <p class="text-gray-400">{{ $user->name }} ma'lumotlarini yangilash</p>
        </div>
        <a href="{{ route('admin.users.show', $user) }}"
           class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-all">
            <i class="fas fa-arrow-left mr-2"></i>Orqaga
        </a>
    </div>

    <!-- Error Message -->
    @if(session('error'))
    <div class="bg-red-500/20 border border-red-500 rounded-lg p-4 text-red-400">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{ session('error') }}
    </div>
    @endif

    <!-- Form -->
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Asosiy Ma'lumotlar -->
        <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
            <h2 class="text-xl font-bold text-white mb-4 pb-2 border-b border-slate-700">
                <i class="fas fa-user mr-2 text-blue-400"></i>Asosiy Ma'lumotlar
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Ism -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-user mr-2 text-blue-400"></i>Ism *
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           required>
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Familiya -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-user mr-2 text-blue-400"></i>Familiya
                    </label>
                    <input type="text" name="second_name" value="{{ old('second_name', $user->second_name) }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors">
                    @error('second_name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Otasining ismi -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-user mr-2 text-blue-400"></i>Otasining ismi
                    </label>
                    <input type="text" name="third_name" value="{{ old('third_name', $user->third_name) }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors">
                    @error('third_name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-at mr-2 text-purple-400"></i>Username
                    </label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors">
                    @error('username')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-envelope mr-2 text-yellow-400"></i>Email *
                    </label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           required>
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telefon -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-phone mr-2 text-green-400"></i>Telefon
                    </label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors">
                    @error('phone')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jinsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-venus-mars mr-2 text-pink-400"></i>Jinsi
                    </label>
                    <select name="jinsi" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-green-500 transition-colors">
                        <option value="">-- Tanlang --</option>
                        <option value="erkak" {{ old('jinsi', $user->jinsi) == 'erkak' ? 'selected' : '' }}>Erkak</option>
                        <option value="ayol" {{ old('jinsi', $user->jinsi) == 'ayol' ? 'selected' : '' }}>Ayol</option>
                    </select>
                    @error('jinsi')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Manzil -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-map-marker-alt mr-2 text-red-400"></i>Manzil
                    </label>
                    <textarea name="address" rows="3"
                              class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Harbiy Ma'lumotlar -->
        <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
            <h2 class="text-xl font-bold text-white mb-4 pb-2 border-b border-slate-700">
                <i class="fas fa-shield-alt mr-2 text-orange-400"></i>Harbiy Ma'lumotlar
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Unvon -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-star mr-2 text-yellow-400"></i>Unvon
                    </label>
                    <input type="text" name="rank" value="{{ old('rank', $user->rank) }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Masalan: Kapitan">
                    @error('rank')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lavozim -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-briefcase mr-2 text-blue-400"></i>Lavozim
                    </label>
                    <input type="text" name="job_title" value="{{ old('job_title', $user->job_title) }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Masalan: Komandir">
                    @error('job_title')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Guruh -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-users mr-2 text-purple-400"></i>Guruh
                    </label>
                    <select name="id_group" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-green-500 transition-colors">
                        <option value="">-- Guruhni tanlang --</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id_group }}" {{ old('id_group', $user->id_group) == $group->id_group ? 'selected' : '' }}>
                                {{ $group->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_group')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Vazifa va Mas'uliyat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-tasks mr-2 text-cyan-400"></i>Vazifa va Mas'uliyat
                    </label>
                    <textarea name="job_responsibility" rows="3"
                              class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                              placeholder="Vazifa va mas'uliyatni kiriting">{{ old('job_responsibility', $user->job_responsibility) }}</textarea>
                    @error('job_responsibility')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Shaxsiy Ma'lumotlar -->
        <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
            <h2 class="text-xl font-bold text-white mb-4 pb-2 border-b border-slate-700">
                <i class="fas fa-id-card mr-2 text-green-400"></i>Shaxsiy Ma'lumotlar
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pasport Seriyasi -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-id-card mr-2 text-blue-400"></i>Pasport Seriyasi
                    </label>
                    <input type="text" name="passport_seria" value="{{ old('passport_seria', $user->passport_seria) }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Masalan: AB">
                    @error('passport_seria')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pasport Raqami -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-hashtag mr-2 text-purple-400"></i>Pasport Raqami
                    </label>
                    <input type="text" name="passport_code" value="{{ old('passport_code', $user->passport_code) }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Masalan: 1234567">
                    @error('passport_code')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ma'lumoti -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-graduation-cap mr-2 text-yellow-400"></i>Ma'lumoti
                    </label>
                    <input type="text" name="degree" value="{{ old('degree', $user->degree) }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Masalan: Oliy">
                    @error('degree')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bo'y (sm) -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-ruler-vertical mr-2 text-green-400"></i>Bo'y (sm)
                    </label>
                    <input type="number" name="height" value="{{ old('height', $user->height) }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Masalan: 175" min="0" max="300">
                    @error('height')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Vazn (kg) -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-weight mr-2 text-orange-400"></i>Vazn (kg)
                    </label>
                    <input type="number" name="weight" value="{{ old('weight', $user->weight) }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Masalan: 75" min="0" max="300">
                    @error('weight')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Guvohnoma Raqami -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-certificate mr-2 text-cyan-400"></i>Guvohnoma Raqami
                    </label>
                    <input type="text" name="license_code" value="{{ old('license_code', $user->license_code) }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Guvohnoma raqami">
                    @error('license_code')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Oilaviy Holati -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-heart mr-2 text-pink-400"></i>Oilaviy Holati
                    </label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center p-3 bg-slate-700 border border-slate-600 rounded-lg cursor-pointer hover:border-pink-500 transition-all {{ old('is_married', $user->is_married) ? 'border-pink-500 bg-pink-500 bg-opacity-10' : '' }}">
                            <input type="checkbox" name="is_married" value="1"
                                   class="w-5 h-5 text-pink-600 bg-slate-600 border-slate-500 rounded focus:ring-pink-500 focus:ring-2"
                                   {{ old('is_married', $user->is_married) ? 'checked' : '' }}>
                            <span class="ml-3 text-white">Uylangan</span>
                        </label>
                    </div>
                    @error('is_married')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Parol va Tizim Sozlamalari -->
        <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
            <h2 class="text-xl font-bold text-white mb-4 pb-2 border-b border-slate-700">
                <i class="fas fa-cog mr-2 text-gray-400"></i>Parol va Tizim Sozlamalari
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Yangi Parol -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-lock mr-2 text-yellow-400"></i>Yangi Parol
                    </label>
                    <input type="password" name="password"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Bo'sh qoldiring agar o'zgartirmasangiz">
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parol Tasdiqlash -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-lock mr-2 text-yellow-400"></i>Parolni Tasdiqlash
                    </label>
                    <input type="password" name="password_confirmation"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Parolni qayta kiriting">
                </div>

                <!-- Faol holat -->
                <div class="md:col-span-2">
                    <label class="flex items-center p-4 bg-slate-700 border border-slate-600 rounded-lg cursor-pointer hover:border-green-500 transition-all w-fit {{ old('is_active', $user->is_active) ? 'border-green-500 bg-green-500 bg-opacity-10' : '' }}">
                        <input type="checkbox" name="is_active" value="1"
                               class="w-5 h-5 text-green-600 bg-slate-600 border-slate-500 rounded focus:ring-green-500 focus:ring-2"
                               {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <span class="ml-3 text-white font-medium">
                            <i class="fas fa-toggle-on mr-2 text-green-400"></i>Faol foydalanuvchi
                        </span>
                    </label>
                    @error('is_active')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Rollar -->
        <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
            <h2 class="text-xl font-bold text-white mb-4 pb-2 border-b border-slate-700">
                <i class="fas fa-user-tag mr-2 text-purple-400"></i>Rollar *
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($roles as $role)
                <label class="flex items-center p-4 bg-slate-700 border border-slate-600 rounded-lg cursor-pointer hover:border-purple-500 transition-all {{ $user->hasRole($role->name) ? 'border-purple-500 bg-purple-500 bg-opacity-10' : '' }}">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                           class="w-5 h-5 text-purple-600 bg-slate-600 border-slate-500 rounded focus:ring-purple-500 focus:ring-2"
                           {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                    <span class="ml-3 text-white font-medium">{{ $role->name }}</span>
                </label>
                @endforeach
            </div>
            @error('roles')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-slate-700">
            <a href="{{ route('admin.users.show', $user) }}"
               class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-all">
                <i class="fas fa-arrow-left mr-2"></i>Orqaga
            </a>
            <button type="submit"
                    class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all shadow-lg hover:shadow-green-500/50">
                <i class="fas fa-save mr-2"></i>Yangilash
            </button>
        </div>
    </form>
</div>
@endsection
