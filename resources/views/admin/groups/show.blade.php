@extends('layouts.admin')

@section('title', 'Guruh - ' . $group->name)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-white orbitron">{{ $group->name }}</h1>
            <p class="text-gray-400 mt-2">{{ $group->type ?? '-' }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.groups.edit', $group) }}" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-500 rounded-lg text-white transition-colors">
                <i class="fas fa-edit mr-2"></i>Tahrirlash
            </a>
            <form action="{{ route('admin.groups.destroy', $group) }}" method="POST" style="display: inline;">
                @csrf @method('DELETE')
                <button onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')"
                    class="px-4 py-2 bg-red-600 hover:bg-red-500 rounded-lg text-white transition-colors">
                    <i class="fas fa-trash mr-2"></i>O'chirish
                </button>
            </form>
        </div>
    </div>

    <!-- Info -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-white mb-4">Ma'lumot</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-400 text-sm">Nomi</p>
                <p class="text-white font-medium">{{ $group->name }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Turi</p>
                <p class="text-white font-medium">{{ $group->type ?? '-' }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-400 text-sm">Tavsif</p>
                <p class="text-white">{{ $group->description ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Users -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-white mb-4">
            <i class="fas fa-users text-blue-400 mr-2"></i>Askarlar ({{ $group->users->count() }})
        </h3>
        @if($group->users->count() > 0)
        <div class="space-y-2">
            @foreach($group->users as $user)
            <div class="flex justify-between items-center p-3 bg-slate-900/30 rounded border border-slate-700">
                <div>
                    <p class="text-white font-medium">{{ $user->name }}</p>
                    <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-400">Bu guruhda hech qanday foydalanuvchi yo'q</p>
        @endif
    </div>

    <!-- Lessons -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-white mb-4">
            <i class="fas fa-book text-green-400 mr-2"></i>Darslar ({{ $group->lessons->count() }})
        </h3>
        @if($group->lessons->count() > 0)
        <div class="space-y-2">
            @foreach($group->lessons as $lesson)
            <div class="flex justify-between items-center p-3 bg-slate-900/30 rounded border border-slate-700">
                <div>
                    <p class="text-white font-medium">{{ $lesson->topic }}</p>
                    <p class="text-gray-400 text-sm">{{ $lesson->lesson_date->format('d.m.Y') }} {{ $lesson->start_at }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-400">Bu guruhda hech qanday dars yo'q</p>
        @endif
    </div>
</div>
@endsection
