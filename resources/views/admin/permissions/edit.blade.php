@extends('layouts.admin')

@section('title', 'Ruxsatni Tahrirlash')

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Ruxsatni Tahrirlash') }}
    </h2>
</x-slot>

<div class="max-w-2xl mx-auto">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Ogohlantirish -->
            <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Diqqat!</strong> Permission nomini o'zgartirish barcha role va foydalanuvchilarga ta'sir qiladi.
                            Agar bu permission kodda ishlatilsa, xato yuz berishi mumkin.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Ruxsat Nomi *
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $permission->name) }}" 
                           placeholder="masalan: view-users, create-posts" 
                           class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm @error('name') border-red-500 @enderror" 
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Format: action-resource (masalan: view-users, create-posts, edit-settings)
                    </p>
                </div>

                <!-- Qo'shimcha ma'lumotlar -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Ma'lumotlar</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Guard:</span>
                            <span class="ml-2 font-medium text-gray-900">{{ $permission->guard_name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Yaratilgan:</span>
                            <span class="ml-2 font-medium text-gray-900">{{ $permission->created_at->format('d.m.Y') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Rollarda:</span>
                            <span class="ml-2 font-medium text-gray-900">{{ $permission->roles()->count() }} ta</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Foydalanuvchilarda:</span>
                            <span class="ml-2 font-medium text-gray-900">{{ $permission->users()->count() }} ta</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.permissions.index') }}" 
                       class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-2"></i>Orqaga
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-save mr-2"></i>Yangilash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

