@extends('layouts.admin')

@section('title', 'Yangi Ruxsat')

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Yangi Ruxsat Yaratish') }}
    </h2>
</x-slot>

<div class="max-w-2xl mx-auto">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Ruxsat Nomi *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                           placeholder="masalan: view-users, create-posts" 
                           class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <p class="mt-1 text-sm text-gray-500">Masalan: view-users, create-posts, edit-settings</p>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.permissions.index') }}" class="text-gray-600 hover:text-gray-900">
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

