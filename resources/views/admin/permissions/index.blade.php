@extends('layouts.admin')

@section('title', 'Ruxsatlar')

@section('content')
<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ruxsatlar') }}
        </h2>
        @can('assign-permissions')
        <a href="{{ route('admin.permissions.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2"></i>Yangi Ruxsat
        </a>
        @endcan
    </div>
</x-slot>

<div class="space-y-6">
    @foreach($permissions as $group => $groupPermissions)
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 capitalize">{{ $group }}</h3>
                <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-700">
                    {{ $groupPermissions->count() }} ta ruxsat
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($groupPermissions as $permission)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <span class="text-sm text-gray-700 font-medium">{{ $permission->name }}</span>
                    <div class="flex items-center space-x-2">
                        <!-- Ko'rish -->
                        <a href="{{ route('admin.permissions.show', $permission) }}" 
                           class="text-blue-600 hover:text-blue-900 text-sm"
                           title="Ko'rish">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <!-- Tahrirlash -->
                        @can('assign-permissions')
                        <a href="{{ route('admin.permissions.edit', $permission) }}" 
                           class="text-yellow-600 hover:text-yellow-900 text-sm"
                           title="Tahrirlash">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        
                        <!-- O'chirish -->
                        @can('assign-permissions')
                        <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-600 hover:text-red-900 text-sm" 
                                    title="O'chirish"
                                    onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?\n\nBu ruxsat {{ $permission->roles()->count() }} ta rolga va {{ $permission->users()->count() }} ta foydalanuvchiga biriktirilgan.')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

