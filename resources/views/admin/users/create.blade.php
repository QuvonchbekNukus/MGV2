@extends('layouts.admin')

@section('title', 'Yangi Askar')
@section('page-title', 'Yangi Askar')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Yangi Askar Qo'shish</h1>
        <p class="text-gray-400">Tizimga yangi askar qo'shish va rol biriktirish</p>
    </div>

    <!-- Form Card -->
    <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700">
        <div class="p-8">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <!-- Asosiy ma'lumotlar -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-white mb-4 pb-2 border-b border-slate-700">
                        <i class="fas fa-user mr-2"></i>Asosiy Ma'lumotlar
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Ism -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-user mr-2"></i>Ism *
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                                   placeholder="Ism kiriting"
                                   required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Familiya -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-user mr-2"></i>Familiya
                            </label>
                            <input type="text" name="second_name" value="{{ old('second_name') }}"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   placeholder="Familiya kiriting">
                        </div>

                        <!-- Otasining ismi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-user mr-2"></i>Otasining ismi
                            </label>
                            <input type="text" name="third_name" value="{{ old('third_name') }}"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   placeholder="Otasining ismini kiriting">
                        </div>

                        <!-- Username -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-at mr-2"></i>Username
                            </label>
                            <input type="text" name="username" value="{{ old('username') }}"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('username') border-red-500 @enderror"
                                   placeholder="username">
                            @error('username')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-envelope mr-2"></i>Email *
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                                   placeholder="email@example.com"
                                   required>
                            @error('email')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Telefon -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-phone mr-2"></i>Telefon
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   placeholder="+998 90 123 45 67">
                        </div>

                        <!-- Jinsi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-venus-mars mr-2"></i>Jinsi
                            </label>
                            <select name="jinsi"
                                    class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                <option value="">Tanlang</option>
                                <option value="erkak" {{ old('jinsi') == 'erkak' ? 'selected' : '' }}>Erkak</option>
                                <option value="ayol" {{ old('jinsi') == 'ayol' ? 'selected' : '' }}>Ayol</option>
                            </select>
                        </div>

                        <!-- Parol -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-lock mr-2"></i>Parol *
                            </label>
                            <input type="password" name="password"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                                   placeholder="••••••••"
                                   required>
                            @error('password')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Parol Tasdiqlash -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-lock mr-2"></i>Parolni Tasdiqlash *
                            </label>
                            <input type="password" name="password_confirmation"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   placeholder="••••••••"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Harbiy ma'lumotlar -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-white mb-4 pb-2 border-b border-slate-700">
                        <i class="fas fa-shield-alt mr-2"></i>Harbiy Ma'lumotlar
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Unvon -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-star mr-2"></i>Unvon
                            </label>
                            <input type="text" name="rank" value="{{ old('rank') }}"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   placeholder="Masalan: Serjant">
                        </div>

                        <!-- Lavozim -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-briefcase mr-2"></i>Lavozim
                            </label>
                            <input type="text" name="job_title" value="{{ old('job_title') }}"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   placeholder="Masalan: Komandir">
                        </div>

                        <!-- Guruh -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-users mr-2"></i>Guruh
                            </label>
                            <select name="id_group"
                                    class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                <option value="">Guruh tanlang</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id_group }}" {{ old('id_group') == $group->id_group ? 'selected' : '' }}>
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Vazifa -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-tasks mr-2"></i>Vazifa va Mas'uliyat
                            </label>
                            <textarea name="job_responsibility" rows="3"
                                      class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                      placeholder="Vazifa va mas'uliyatni kiriting">{{ old('job_responsibility') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Shaxsiy ma'lumotlar -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-white mb-4 pb-2 border-b border-slate-700">
                        <i class="fas fa-id-card mr-2"></i>Shaxsiy Ma'lumotlar
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pasport seriyasi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-id-card mr-2"></i>Pasport Seriyasi
                            </label>
                            <input type="text" name="passport_seria" value="{{ old('passport_seria') }}"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   placeholder="Masalan: AB">
                        </div>

                        <!-- Pasport raqami -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-hashtag mr-2"></i>Pasport Raqami
                            </label>
                            <input type="text" name="passport_code" value="{{ old('passport_code') }}"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   placeholder="Masalan: 1234567">
                        </div>

                        <!-- Ma'lumoti -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-graduation-cap mr-2"></i>Ma'lumoti
                            </label>
                            <input type="text" name="degree" value="{{ old('degree') }}"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   placeholder="Masalan: Oliy">
                        </div>

                        <!-- Manzil -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-map-marker-alt mr-2"></i>Manzil
                            </label>
                            <textarea name="address" rows="2"
                                      class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                      placeholder="To'liq manzil kiriting">{{ old('address') }}</textarea>
                        </div>

                        <!-- Bo'y -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-ruler-vertical mr-2"></i>Bo'y (sm)
                            </label>
                            <input type="number" name="height" value="{{ old('height') }}"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   placeholder="Masalan: 175"
                                   min="0" max="300">
                        </div>

                        <!-- Vazn -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-weight mr-2"></i>Vazn (kg)
                            </label>
                            <input type="number" name="weight" value="{{ old('weight') }}"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   placeholder="Masalan: 75"
                                   min="0" max="300">
                        </div>

                        <!-- Guvohnoma raqami -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-certificate mr-2"></i>Guvohnoma Raqami
                            </label>
                            <input type="text" name="license_code" value="{{ old('license_code') }}"
                                   class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   placeholder="Guvohnoma raqami">
                        </div>
                    </div>
                </div>

                <!-- Qo'shimcha -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-white mb-4 pb-2 border-b border-slate-700">
                        <i class="fas fa-cog mr-2"></i>Qo'shimcha
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Uylangan -->
                        <div>
                            <label class="flex items-center p-4 bg-slate-700 border border-slate-600 rounded-lg cursor-pointer hover:border-green-500 transition-all w-fit">
                                <input type="checkbox" name="is_married" value="1"
                                       class="w-5 h-5 text-green-600 bg-slate-600 border-slate-500 rounded focus:ring-green-500 focus:ring-2"
                                       {{ old('is_married') ? 'checked' : '' }}>
                                <span class="ml-3 text-white font-medium">
                                    <i class="fas fa-heart mr-2 text-pink-400"></i>Uylangan
                                </span>
                            </label>
                        </div>

                        <!-- Faol holat -->
                        <div>
                            <label class="flex items-center p-4 bg-slate-700 border border-slate-600 rounded-lg cursor-pointer hover:border-green-500 transition-all w-fit">
                                <input type="checkbox" name="is_active" value="1"
                                       class="w-5 h-5 text-green-600 bg-slate-600 border-slate-500 rounded focus:ring-green-500 focus:ring-2"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="ml-3 text-white font-medium">
                                    <i class="fas fa-toggle-on mr-2 text-green-400"></i>Faol askar
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Rollar -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-white mb-4 pb-2 border-b border-slate-700">
                        <i class="fas fa-user-tag mr-2"></i>Rollar
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($roles as $role)
                        <label class="flex items-center p-4 bg-slate-700 border border-slate-600 rounded-lg cursor-pointer hover:border-green-500 transition-all">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                   class="w-5 h-5 text-green-600 bg-slate-600 border-slate-500 rounded focus:ring-green-500 focus:ring-2"
                                   {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                            <span class="ml-3 text-white font-medium">{{ $role->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('roles')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-700">
                    <a href="{{ route('admin.users.index') }}"
                       class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-gray-300 rounded-lg font-medium transition-all">
                        <i class="fas fa-arrow-left mr-2"></i>Orqaga
                    </a>
                    <button type="submit"
                            class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all shadow-lg hover:shadow-green-500/50">
                        <i class="fas fa-save mr-2"></i>Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
