@extends('layouts.admin')

@section('title', 'Guruhlar')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white orbitron">
                <i class="fas fa-users text-green-400 mr-3"></i>Guruhlar
            </h1>
            <p class="text-gray-400 mt-2">Barcha guruhlarni boshqarish</p>
        </div>
        <a href="{{ route('admin.groups.create') }}"
           class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 rounded-lg text-white font-semibold transition-all">
            <i class="fas fa-plus mr-2"></i>Yangi Guruh
        </a>
    </div>

    <!-- Table -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm overflow-hidden">
        @if($groups->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-900/50 border-b border-slate-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Nomi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Turi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Tavsif</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Amallar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @foreach($groups as $group)
                    <tr class="hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 text-white font-medium">{{ $group->name }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $group->type ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-400 text-sm">{{ Str::limit($group->description, 50) ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('admin.groups.show', $group) }}" class="text-blue-400 hover:text-blue-300">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.groups.edit', $group) }}" class="text-yellow-400 hover:text-yellow-300">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.groups.destroy', $group) }}" method="POST" style="display: inline;">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')" class="text-red-400 hover:text-red-300">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-slate-900/50 border-t border-slate-700">
            {{ $groups->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <i class="fas fa-inbox text-6xl text-gray-600 mb-4"></i>
            <p class="text-gray-400">Guruhlar topilmadi</p>
        </div>
        @endif
    </div>
</div>
@endsection
