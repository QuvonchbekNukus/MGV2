@extends('layouts.admin')

@section('title', 'Foydalanuvchini Tahrirlash')
@section('page-title', 'Foydalanuvchini Tahrirlash')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Foydalanuvchini Tahrirlash</h1>
        <p class="text-gray-400">{{ $user->name }} ma'lumotlarini yangilash</p>
    </div>

    <!-- Form Card -->
    <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700">
        <div class="p-8">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Ism -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-user mr-2"></i>Ism *
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror" 
                               required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-envelope mr-2"></i>Email *
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror" 
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
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                               class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    </div>

                    <!-- Yangi Parol -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-lock mr-2"></i>Yangi Parol
                        </label>
                        <input type="password" name="password" 
                               class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror" 
                               placeholder="Bo'sh qoldiring agar o'zgartirmasangiz">
                        @error('password')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Parol Tasdiqlash -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-lock mr-2"></i>Parolni Tasdiqlash
                        </label>
                        <input type="password" name="password_confirmation" 
                               class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    </div>
                </div>

                <!-- Manzil -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-map-marker-alt mr-2"></i>Manzil
                    </label>
                    <textarea name="address" rows="3" 
                              class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">{{ old('address', $user->address) }}</textarea>
                </div>

                <!-- Rollar -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-300 mb-3">
                        <i class="fas fa-user-tag mr-2"></i>Rollar *
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($roles as $role)
                        <label class="flex items-center p-4 bg-slate-700 border border-slate-600 rounded-lg cursor-pointer hover:border-green-500 transition-all {{ $user->hasRole($role->name) ? 'border-green-500 bg-green-500 bg-opacity-10' : '' }}">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                   class="w-5 h-5 text-green-600 bg-slate-600 border-slate-500 rounded focus:ring-green-500 focus:ring-2" 
                                   {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                            <span class="ml-3 text-white font-medium">{{ $role->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('roles')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Faol holat -->
                <div class="mt-6">
                    <label class="flex items-center p-4 bg-slate-700 border border-slate-600 rounded-lg cursor-pointer hover:border-green-500 transition-all w-fit {{ $user->is_active ? 'border-green-500 bg-green-500 bg-opacity-10' : '' }}">
                        <input type="checkbox" name="is_active" value="1" 
                               class="w-5 h-5 text-green-600 bg-slate-600 border-slate-500 rounded focus:ring-green-500 focus:ring-2" 
                               {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <span class="ml-3 text-white font-medium">
                            <i class="fas fa-toggle-on mr-2 text-green-400"></i>Faol foydalanuvchi
                        </span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-700">
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-gray-300 rounded-lg font-medium transition-all">
                        <i class="fas fa-arrow-left mr-2"></i>Orqaga
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all shadow-lg hover:shadow-green-500/50">
                        <i class="fas fa-save mr-2"></i>Yangilash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
