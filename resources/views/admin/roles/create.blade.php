@extends('layouts.admin')

@section('title', 'Yangi Rol')

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Yangi Rol Yaratish') }}
    </h2>
</x-slot>

<div class="max-w-3xl mx-auto">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Rol Nomi *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                           class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Ruxsatlar</label>
                    @foreach($permissions as $group => $groupPermissions)
                    <div class="mb-4 p-4 border border-gray-200 rounded-lg">
                        <h4 class="font-medium text-gray-900 mb-3 capitalize">{{ $group }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($groupPermissions as $permission)
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                                       {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.roles.index') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-2"></i>Orqaga
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

