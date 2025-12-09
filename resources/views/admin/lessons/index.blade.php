@extends('layouts.admin')

@section('title', 'Darslar')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white orbitron">
                <i class="fas fa-book text-blue-400 mr-3"></i>Darslar
            </h1>
            <p class="text-gray-400 mt-2">Barcha darslarni boshqarish</p>
        </div>
        <a href="{{ route('admin.lessons.create') }}"
           class="px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 rounded-lg text-white font-semibold transition-all">
            <i class="fas fa-plus mr-2"></i>Yangi Dars
        </a>
    </div>

    <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm overflow-hidden">
        @if($lessons->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-900/50 border-b border-slate-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Mavzu</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Guruh</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Instructor</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Sana</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Vaqt</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Amallar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @foreach($lessons as $lesson)
                    <tr class="hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 text-white font-medium">{{ $lesson->topic }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $lesson->group->name }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $lesson->instructor->name }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $lesson->lesson_date->format('d.m.Y') }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $lesson->start_at }} - {{ $lesson->end_at }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('admin.lessons.show', $lesson) }}" class="text-blue-400 hover:text-blue-300">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.lessons.edit', $lesson) }}" class="text-yellow-400 hover:text-yellow-300">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" style="display: inline;">
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
            {{ $lessons->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <i class="fas fa-inbox text-6xl text-gray-600 mb-4"></i>
            <p class="text-gray-400">Darslar topilmadi</p>
        </div>
        @endif
    </div>
</div>
@endsection
