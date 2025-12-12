@extends('layouts.admin')

@section('title', 'Darsni Tahrirlash')
@section('page-title', 'Darsni Tahrirlash')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        @if(auth()->user()->can('view-lessons'))
            <a href="{{ route('admin.lessons.show', $lesson) }}" class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
        @elseif(auth()->user()->group)
            <a href="{{ route('admin.group-journals.show', auth()->user()->group) }}" class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
        @endif
        <div>
            <h1 class="text-3xl font-bold text-white">
                <i class="fas fa-edit text-blue-400 mr-3"></i>Darsni Tahrirlash
            </h1>
            <p class="text-gray-400 mt-2">{{ $lesson->topic }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
        <form action="{{ route('admin.lessons.update', $lesson) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            <!-- Topic -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-book mr-2 text-blue-400"></i>Mavzu
                </label>
                <input type="text" name="topic" value="{{ old('topic', $lesson->topic) }}"
                       class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                       placeholder="Masalan: Harbiy tarix asoslari" required>
                @error('topic')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Group -->
            @if(auth()->user()->can('view-lessons'))
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-users mr-2 text-purple-400"></i>Guruh
                </label>
                <select name="id_group" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-green-500 transition-colors" required>
                    @foreach($groups as $group)
                        <option value="{{ $group->id_group }}" {{ old('id_group', $lesson->id_group) == $group->id_group ? 'selected' : '' }}>
                            {{ $group->name }}
                        </option>
                    @endforeach
                </select>
                @error('id_group')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            @else
                <input type="hidden" name="id_group" value="{{ auth()->user()->id_group }}">
            @endif

            <!-- Instructor -->
            @if(auth()->user()->can('view-lessons'))
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-user mr-2 text-yellow-400"></i>O'qituvchi
                </label>
                <select name="id_user" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-green-500 transition-colors" required>
                    @foreach($instructors as $instructor)
                        <option value="{{ $instructor->id }}" {{ old('id_user', $lesson->id_user) == $instructor->id ? 'selected' : '' }}>
                            {{ $instructor->name }} ({{ $instructor->email }})
                        </option>
                    @endforeach
                </select>
                @error('id_user')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            @else
                <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
            @endif

            <!-- Lesson Date -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-calendar mr-2 text-red-400"></i>Dars Sanasi
                </label>
                <input type="date" name="lesson_date" value="{{ old('lesson_date', $lesson->lesson_date?->format('Y-m-d')) }}"
                       class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-green-500 transition-colors"
                       required>
                @error('lesson_date')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Start Time -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-play mr-2 text-green-400"></i>Boshlanish Vaqti
                    </label>
                    <input type="time" name="start_at" value="{{ old('start_at', $lesson->start_at ? \Carbon\Carbon::parse($lesson->start_at)->format('H:i') : '') }}"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-green-500 transition-colors"
                           required>
                    @error('start_at')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lesson Duration -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-clock mr-2 text-cyan-400"></i>Davomiyligi (daqiqa)
                    </label>
                    <input type="number" name="lesson_duration" value="{{ old('lesson_duration', $lesson->lesson_duration) }}" min="1"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Masalan: 90" required>
                    @error('lesson_duration')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 rounded-lg text-white font-semibold transition-all">
                    <i class="fas fa-save mr-2"></i>Yangilash
                </button>
                <a href="{{ route('admin.lessons.show', $lesson) }}" class="flex-1 px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white font-semibold text-center transition-all">
                    <i class="fas fa-times mr-2"></i>Bekor qilish
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
