@extends('layouts.admin')

@section('title', 'Rollar')

@section('content')
<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rollar') }}
        </h2>
        @can('create-roles')
        <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2"></i>Yangi Rol
        </a>
        @endcan
    </div>
</x-slot>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($roles as $role)
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $role->name }}</h3>
                <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                    {{ $role->permissions->count() }} ruxsat
                </span>
            </div>
            
            <div class="mb-4">
                <h4 class="text-sm font-medium text-gray-500 mb-2">Ruxsatlar:</h4>
                <div class="flex flex-wrap gap-1">
                    @forelse($role->permissions->take(5) as $permission)
                        <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">{{ $permission->name }}</span>
                    @empty
                        <span class="text-sm text-gray-400">Ruxsatlar yo'q</span>
                    @endforelse
                    @if($role->permissions->count() > 5)
                        <span class="px-2 py-1 text-xs text-gray-500">+{{ $role->permissions->count() - 5 }} yana</span>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <a href="{{ route('admin.roles.show', $role) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                    <i class="fas fa-eye mr-1"></i>Ko'rish
                </a>
                <div class="space-x-2">
                    @can('edit-roles')
                    <a href="{{ route('admin.roles.edit', $role) }}" class="text-yellow-600 hover:text-yellow-900">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endcan
                    @can('delete-roles')
                    @if($role->name !== 'super-admin')
                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

