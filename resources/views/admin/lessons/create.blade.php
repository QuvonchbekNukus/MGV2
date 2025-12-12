@extends('layouts.admin')

@section('title', 'Yangi Dars')
@section('page-title', 'Yangi Dars Yaratish')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        @if(auth()->user()->can('view-lessons'))
            <a href="{{ route('admin.lessons.index') }}" class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
        @elseif(auth()->user()->group)
            <a href="{{ route('admin.group-journals.show', auth()->user()->group) }}" class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
        @endif
        <div>
            <h1 class="text-3xl font-bold text-white">
                <i class="fas fa-plus text-green-400 mr-3"></i>Yangi Dars
            </h1>
            <p class="text-gray-400 mt-2">Yangi darsi qo'shish</p>
        </div>
    </div>

    <!-- Error Message -->
    @if(session('error'))
    <div class="bg-red-500/20 border border-red-500 rounded-lg p-4 text-red-400">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{ session('error') }}
    </div>
    @endif

    <!-- Form -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
        <form action="{{ route('admin.lessons.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Topic -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-book mr-2 text-blue-400"></i>Mavzu
                </label>
                <input type="text" name="topic" value="{{ old('topic') }}"
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
                    <option value="">-- Guruhni tanlang --</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id_group }}" {{ old('id_group') == $group->id_group ? 'selected' : '' }}>
                            {{ $group->name }}
                        </option>
                    @endforeach
                </select>
                @error('id_group')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            @else
                @if(auth()->user()->id_group)
                    <input type="hidden" name="id_group" value="{{ auth()->user()->id_group }}">
                @else
                    <div class="bg-red-500/20 border border-red-500 rounded-lg p-4 text-red-400">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Sizga guruh biriktirilmagan. Iltimos, avval guruh biriktiring.
                    </div>
                @endif
            @endif

            <!-- Instructor -->
            @if(auth()->user()->can('view-lessons'))
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-user mr-2 text-yellow-400"></i>O'qituvchi
                </label>
                <select name="id_user" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-green-500 transition-colors" required>
                    <option value="">-- O'qituvchini tanlang --</option>
                    @foreach($instructors as $instructor)
                        <option value="{{ $instructor->id }}" {{ old('id_user') == $instructor->id ? 'selected' : '' }}>
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
                <input type="date" name="lesson_date" value="{{ old('lesson_date') }}"
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
                    <input type="time" name="start_at" value="{{ old('start_at') }}"
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
                    <input type="number" name="lesson_duration" value="{{ old('lesson_duration') }}" min="1"
                           class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition-colors"
                           placeholder="Masalan: 90" required>
                    @error('lesson_duration')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 rounded-lg text-white font-semibold transition-all">
                    <i class="fas fa-save mr-2"></i>Saqlash
                </button>
                @if(auth()->user()->can('view-lessons'))
                    <a href="{{ route('admin.lessons.index') }}" class="flex-1 px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white font-semibold text-center transition-all">
                        <i class="fas fa-times mr-2"></i>Bekor qilish
                    </a>
                @elseif(auth()->user()->group)
                    <a href="{{ route('admin.group-journals.show', auth()->user()->group) }}" class="flex-1 px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white font-semibold text-center transition-all">
                        <i class="fas fa-times mr-2"></i>Bekor qilish
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
