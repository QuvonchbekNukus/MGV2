@extends('layouts.admin')

@section('title', 'Ruxsat Ma\'lumotlari')

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Ruxsat Ma\'lumotlari') }}
    </h2>
</x-slot>

<div class="max-w-6xl mx-auto space-y-6">
    <!-- Asosiy Ma'lumotlar -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Ruxsat Nomi</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $permission->name }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Guard Name</h3>
                    <p class="text-lg text-gray-900">{{ $permission->guard_name }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Yaratilgan</h3>
                    <p class="text-lg text-gray-900">{{ $permission->created_at->format('d.m.Y H:i') }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Oxirgi yangilanish</h3>
                    <p class="text-lg text-gray-900">{{ $permission->updated_at->format('d.m.Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistika Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Rollar soni -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Bog'langan Rollar</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $roles->count() }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <i class="fas fa-user-tag text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Foydalanuvchilar soni -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Bog'langan Askarlar</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $users->count() }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-users text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jami ta'sir -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Jami Ta'sir</p>
                        <p class="text-3xl font-bold text-gray-900">
                            {{ $roles->sum(function($role) { return $role->users->count(); }) + $users->count() }}
                        </p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <i class="fas fa-chart-line text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bog'langan Rollar -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Bog'langan Rollar</h3>
                <span class="px-3 py-1 text-sm rounded-full bg-purple-100 text-purple-800">
                    {{ $roles->count() }} ta rol
                </span>
            </div>
            
            @if($roles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($roles as $role)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold text-gray-900">{{ $role->name }}</h4>
                        <a href="{{ route('admin.roles.show', $role) }}" 
                           class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-users mr-2"></i>
                        <span>{{ $role->users->count() }} ta foydalanuvchi</span>
                    </div>
                    <div class="mt-2 text-xs text-gray-400">
                        {{ $role->permissions->count() }} ta ruxsat
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-info-circle text-4xl mb-3"></i>
                <p>Bu ruxsat hech qaysi rolga biriktirilmagan</p>
            </div>
            @endif
        </div>
    </div>

    <!-- To'g'ridan-to'g'ri Bog'langan Foydalanuvchilar -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">To'g'ridan-to'g'ri Bog'langan Askarlar</h3>
                <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                    {{ $users->count() }} ta foydalanuvchi
                </span>
            </div>
            
            @if($users->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($users as $user)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">{{ $user->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            <div class="mt-2 flex flex-wrap gap-1">
                                @foreach($user->roles as $userRole)
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700">
                                        {{ $userRole->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        <a href="{{ route('admin.users.show', $user) }}" 
                           class="text-blue-600 hover:text-blue-900 ml-4">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-info-circle text-4xl mb-3"></i>
                <p>Bu ruxsat hech qaysi foydalanuvchiga to'g'ridan-to'g'ri biriktirilmagan</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.permissions.index') }}" 
                   class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left mr-2"></i>Orqaga
                </a>
                <div class="flex items-center space-x-3">
                    @can('assign-permissions')
                    <a href="{{ route('admin.permissions.edit', $permission) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-edit mr-2"></i>Tahrirlash
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

