@extends('layouts.admin')

@section('title', 'Guruhni Tahrirlash')

@section('content')
<div class="space-y-6 max-w-2xl">
    <div>
        <h1 class="text-3xl font-bold text-white orbitron">
            <i class="fas fa-edit text-yellow-400 mr-3"></i>Guruhni Tahrirlash
        </h1>
    </div>

    <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6">
        <form action="{{ route('admin.groups.update', $group) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Nomi *</label>
                <input type="text" name="name" value="{{ old('name', $group->name) }}" required
                    class="w-full px-4 py-2 bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-green-500 focus:ring-1 focus:ring-green-500">
                @error('name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Turi</label>
                <input type="text" name="type" value="{{ old('type', $group->type) }}"
                    class="w-full px-4 py-2 bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-green-500 focus:ring-1 focus:ring-green-500">
                @error('type') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Tavsif</label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-2 bg-slate-900 border border-slate-600 rounded-lg text-white focus:border-green-500 focus:ring-1 focus:ring-green-500">{{ old('description', $group->description) }}</textarea>
                @error('description') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-6 py-2 bg-yellow-600 hover:bg-yellow-500 rounded-lg text-white font-medium transition-colors">
                    <i class="fas fa-save mr-2"></i>Yangilash
                </button>
                <a href="{{ route('admin.groups.index') }}" class="px-6 py-2 bg-slate-700 hover:bg-slate-600 rounded-lg text-white transition-colors">
                    Bekor
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
