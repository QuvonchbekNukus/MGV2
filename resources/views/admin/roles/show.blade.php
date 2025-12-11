@extends('layouts.admin')

@section('title', 'Rol Ma\'lumotlari')

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Rol Ma\'lumotlari') }}
    </h2>
</x-slot>

<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="mb-6">
                <h3 class="text-sm font-medium text-gray-500">Rol Nomi</h3>
                <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $role->name }}</p>
            </div>

            <div class="mb-6 pt-6 border-t border-gray-200">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium text-gray-500">Ruxsatlar</h3>
                    <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                        {{ $role->permissions->count() }} ta ruxsat
                    </span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @forelse($role->permissions as $permission)
                        <span class="px-3 py-1 text-sm rounded-full bg-purple-100 text-purple-800">{{ $permission->name }}</span>
                    @empty
                        <span class="text-gray-500">Ruxsatlar biriktirilmagan</span>
                    @endforelse
                </div>
            </div>

            <div class="pt-6 border-t border-gray-200">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium text-gray-500">Foydalanuvchilar</h3>
                    <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">
                        {{ $role->users->count() }} ta foydalanuvchi
                    </span>
                </div>
                @if($role->users->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($role->users as $user)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                        <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500">Bu rolda askarlar yo'q</p>
                @endif
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-gray-200 mt-6">
                <a href="{{ route('admin.roles.index') }}" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left mr-2"></i>Orqaga
                </a>
                @can('edit-roles')
                <a href="{{ route('admin.roles.edit', $role) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-edit mr-2"></i>Tahrirlash
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection

