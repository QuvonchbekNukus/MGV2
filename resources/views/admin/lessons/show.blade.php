@extends('layouts.admin')

@section('title', $lesson->topic)
@section('page-title', 'Dars Detallar')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.lessons.index') }}" class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white">
                    <i class="fas fa-book text-pink-400 mr-3"></i>{{ $lesson->topic }}
                </h1>
                <p class="text-gray-400 mt-2">Dars detallar va ma'lumotlari</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.lessons.edit', $lesson) }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 rounded-lg text-white font-semibold transition-all">
                <i class="fas fa-edit mr-2"></i>Tahrirlash
            </a>
            <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" style="display: inline;">
                @csrf @method('DELETE')
                <button onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')" class="px-6 py-3 bg-red-600 hover:bg-red-500 rounded-lg text-white font-semibold transition-all">
                    <i class="fas fa-trash mr-2"></i>O'chirish
                </button>
            </form>
        </div>
    </div>

    <!-- Information Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Lesson Info -->
        <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
            <h2 class="text-lg font-bold text-white mb-4">
                <i class="fas fa-info-circle text-blue-400 mr-2"></i>Dars Ma'lumotlari
            </h2>
            <div class="space-y-4">
                <div>
                    <p class="text-gray-400 text-sm">Mavzu</p>
                    <p class="text-white font-medium">{{ $lesson->topic }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Sanasi</p>
                    <p class="text-white font-medium">
                        <i class="fas fa-calendar mr-2 text-red-400"></i>
                        {{ $lesson->lesson_date?->format('d.m.Y') ?? '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Davomiyligi</p>
                    <p class="text-white font-medium">
                        <i class="fas fa-clock mr-2 text-cyan-400"></i>
                        {{ $lesson->lesson_duration ?? '-' }} daqiqa
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Vaqti</p>
                    <p class="text-white font-medium">
                        <i class="fas fa-play mr-2 text-green-400"></i>
                        {{ $lesson->start_at }} - {{ $lesson->end_at }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Group & Instructor -->
        <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
            <h2 class="text-lg font-bold text-white mb-4">
                <i class="fas fa-users text-purple-400 mr-2"></i>Guruh va O'qituvchi
            </h2>
            <div class="space-y-4">
                <div>
                    <p class="text-gray-400 text-sm">Guruh</p>
                    <p class="text-white font-medium">
                        <i class="fas fa-users mr-2 text-indigo-400"></i>
                        <a href="{{ route('admin.groups.show', $lesson->group->id_group) }}" class="text-blue-400 hover:text-blue-300">
                            {{ $lesson->group->name }}
                        </a>
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">O'qituvchi</p>
                    <p class="text-white font-medium">
                        <i class="fas fa-user mr-2 text-yellow-400"></i>
                        <a href="{{ route('admin.users.show', $lesson->instructor->id) }}" class="text-blue-400 hover:text-blue-300">
                            {{ $lesson->instructor->name }}
                        </a>
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Email</p>
                    <p class="text-white font-medium text-sm">{{ $lesson->instructor->email }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Meta Information -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
        <h2 class="text-lg font-bold text-white mb-4">
            <i class="fas fa-history text-gray-400 mr-2"></i>Sistema Ma'lumotlari
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-400 text-sm">Yaratilgan Vaqti</p>
                <p class="text-white font-medium">{{ $lesson->created_at?->format('d.m.Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Oxirgi O'zgarish</p>
                <p class="text-white font-medium">{{ $lesson->updated_at?->format('d.m.Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
