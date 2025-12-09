@extends('layouts.admin')

@section('title', 'Qurollar')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white orbitron">
                <i class="fas fa-shield-alt text-red-400 mr-3"></i>Qurollar
            </h1>
            <p class="text-gray-400 mt-2">Barcha qurollarni boshqarish</p>
        </div>
        <a href="{{ route('admin.toys.create') }}"
           class="px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-500 hover:to-orange-500 rounded-lg text-white font-semibold transition-all">
            <i class="fas fa-plus mr-2"></i>Yangi Qurol
        </a>
    </div>

    <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm overflow-hidden">
        @if($toys->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-900/50 border-b border-slate-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Nomi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Kod</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Turi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Ish berilgan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Amallar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @foreach($toys as $toy)
                    <tr class="hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 text-white font-medium">{{ $toy->name }}</td>
                        <td class="px-6 py-4 text-gray-400 font-mono">{{ $toy->code }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $toy->type ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $toy->user?->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('admin.toys.show', $toy) }}" class="text-blue-400 hover:text-blue-300">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.toys.edit', $toy) }}" class="text-yellow-400 hover:text-yellow-300">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.toys.destroy', $toy) }}" method="POST" style="display: inline;">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('O\'chirmoqchimisiz?')" class="text-red-400 hover:text-red-300">
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
            {{ $toys->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <i class="fas fa-inbox text-6xl text-gray-600 mb-4"></i>
            <p class="text-gray-400">Qurollar topilmadi</p>
        </div>
        @endif
    </div>
</div>
@endsection
