@extends('layouts.admin')

@section('title', 'Guruh Jurnali')
@section('page-title', 'Guruh Jurnali: ' . $group->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            @can('view-groups')
            <a href="{{ route('admin.groups.index') }}" class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            @endcan
            <div>
                <h1 class="text-3xl font-bold text-white">
                    <i class="fas fa-book text-pink-400 mr-3"></i>Guruh Jurnali
                </h1>
                <p class="text-gray-400 mt-2">{{ $group->name }}</p>
            </div>
        </div>
        @if(auth()->user()->can('view-lessons') || auth()->user()->id_group == $group->id_group)
        <a href="{{ route('admin.lessons.create') }}"
           class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all">
            <i class="fas fa-plus mr-2"></i>Yangi Dars Qo'shish
        </a>
        @endif
    </div>

    <!-- Group Info -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 backdrop-blur-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <div class="text-sm text-gray-400 mb-1">Guruh Nomi</div>
                <div class="text-white font-semibold">{{ $group->name }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-400 mb-1">Guruh Turi</div>
                <div class="text-white font-semibold">{{ $group->type ?? '-' }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-400 mb-1">Jami Darslar</div>
                <div class="text-white font-semibold">{{ $lessonsByMonth->sum(function($month) { return $month['lessons']->count(); }) }} ta</div>
            </div>
        </div>
    </div>

    <!-- Lessons by Month -->
    @if($lessonsByMonth->count() > 0)
        @foreach($lessonsByMonth as $monthData)
            <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm overflow-hidden">
                <!-- Month Header -->
                <div class="bg-gradient-to-r from-pink-600/20 to-purple-600/20 border-b border-slate-700 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-calendar-alt text-pink-400 mr-3"></i>
                        {{ $monthData['month'] }}
                        <span class="ml-3 text-sm font-normal text-gray-400">
                            ({{ $monthData['lessons']->count() }} ta dars)
                        </span>
                    </h2>
                </div>

                <!-- Lessons Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-900/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Sana</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Mavzu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">O'qituvchi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Vaqt</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Davomiyligi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Amallar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @php
                                $weekDays = [
                                    'Monday' => 'Dushanba',
                                    'Tuesday' => 'Seshanba',
                                    'Wednesday' => 'Chorshanba',
                                    'Thursday' => 'Payshanba',
                                    'Friday' => 'Juma',
                                    'Saturday' => 'Shanba',
                                    'Sunday' => 'Yakshanba'
                                ];
                            @endphp
                            @foreach($monthData['lessons'] as $lesson)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-white font-medium">{{ $lesson->lesson_date->format('d.m.Y') }}</div>
                                    <div class="text-gray-400 text-xs">{{ $weekDays[$lesson->lesson_date->format('l')] ?? $lesson->lesson_date->format('l') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-white font-medium">{{ $lesson->topic }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-300">{{ $lesson->instructor->name }}</div>
                                    @if($lesson->instructor->second_name || $lesson->instructor->third_name)
                                        <div class="text-gray-500 text-xs">
                                            {{ trim(($lesson->instructor->second_name ?? '') . ' ' . ($lesson->instructor->third_name ?? '')) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-gray-300">
                                        <i class="fas fa-clock text-blue-400 mr-1"></i>
                                        {{ $lesson->start_at }} - {{ $lesson->end_at }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-gray-300">
                                        <i class="fas fa-hourglass-half text-green-400 mr-1"></i>
                                        {{ $lesson->lesson_duration }} daqiqa
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    @can('view-lessons')
                                    <a href="{{ route('admin.lessons.show', $lesson) }}"
                                       class="text-blue-400 hover:text-blue-300"
                                       title="Ko'rish">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endcan
                                    @if(auth()->user()->can('edit-lessons') || $lesson->id_user == auth()->id())
                                    <a href="{{ route('admin.lessons.edit', $lesson) }}"
                                       class="text-yellow-400 hover:text-yellow-300"
                                       title="Tahrirlash">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    @can('edit-lessons')
                                    <form action="{{ route('admin.lessons.destroy', $lesson) }}"
                                          method="POST"
                                          style="display: inline;"
                                          onsubmit="return confirm('O\'chirmoqchimisiz?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="text-red-400 hover:text-red-300"
                                                title="O'chirish">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @else
        <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-12 text-center backdrop-blur-sm">
            <i class="fas fa-inbox text-6xl text-gray-600 mb-4"></i>
            <p class="text-gray-400 text-lg">Bu guruhda hech qanday dars yo'q</p>
        </div>
    @endif
</div>
@endsection

