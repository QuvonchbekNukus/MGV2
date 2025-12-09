@extends('layouts.admin')

@section('title', $toy->name)
@section('page-title', 'Qurol Detallar')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.toys.index') }}" class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white">
                    <i class="fas fa-shield-alt text-orange-400 mr-3"></i>{{ $toy->name }}
                </h1>
                <p class="text-gray-400 mt-2">Qurol detallar va ma'lumotlari</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.toys.edit', $toy) }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 rounded-lg text-white font-semibold transition-all">
                <i class="fas fa-edit mr-2"></i>Tahrirlash
            </a>
            <form action="{{ route('admin.toys.destroy', $toy) }}" method="POST" style="display: inline;">
                @csrf @method('DELETE')
                <button onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')" class="px-6 py-3 bg-red-600 hover:bg-red-500 rounded-lg text-white font-semibold transition-all">
                    <i class="fas fa-trash mr-2"></i>O'chirish
                </button>
            </form>
        </div>
    </div>

    <!-- Information Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Toy Info -->
        <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
            <h2 class="text-lg font-bold text-white mb-4">
                <i class="fas fa-info-circle text-blue-400 mr-2"></i>Qurol Ma'lumotlari
            </h2>
            <div class="space-y-4">
                <div>
                    <p class="text-gray-400 text-sm">Nomi</p>
                    <p class="text-white font-medium">{{ $toy->name }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Kodi</p>
                    <p class="text-white font-medium">
                        <i class="fas fa-barcode mr-2 text-blue-400"></i>
                        {{ $toy->code }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Turi</p>
                    <p class="text-white font-medium">
                        <i class="fas fa-cube mr-2 text-purple-400"></i>
                        {{ $toy->type ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Manufacturing Info -->
        <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
            <h2 class="text-lg font-bold text-white mb-4">
                <i class="fas fa-industry text-yellow-400 mr-2"></i>Istehsol Ma'lumotlari
            </h2>
            <div class="space-y-4">
                <div>
                    <p class="text-gray-400 text-sm">Istehsol Mamlakati</p>
                    <p class="text-white font-medium">
                        <i class="fas fa-flag mr-2 text-red-400"></i>
                        {{ $toy->made_in ?? '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Istehsol Yili</p>
                    <p class="text-white font-medium">
                        <i class="fas fa-calendar mr-2 text-cyan-400"></i>
                        {{ $toy->made_at ?? '-' }}
                    </p>
                </div>
                @if($toy->user)
                <div>
                    <p class="text-gray-400 text-sm">Javobgar Shaxs</p>
                    <p class="text-white font-medium">
                        <i class="fas fa-user-check mr-2 text-green-400"></i>
                        <a href="{{ route('admin.users.show', $toy->user->id) }}" class="text-blue-400 hover:text-blue-300">
                            {{ $toy->user->name }}
                        </a>
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Description -->
    @if($toy->description)
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
        <h2 class="text-lg font-bold text-white mb-4">
            <i class="fas fa-comment text-pink-400 mr-2"></i>Tavsif
        </h2>
        <p class="text-gray-300 text-sm leading-relaxed">{{ $toy->description }}</p>
    </div>
    @endif

    <!-- Meta Information -->
    <div class="bg-slate-800/50 border border-slate-700 rounded-lg backdrop-blur-sm p-6">
        <h2 class="text-lg font-bold text-white mb-4">
            <i class="fas fa-history text-gray-400 mr-2"></i>Sistema Ma'lumotlari
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-400 text-sm">Yaratilgan Vaqti</p>
                <p class="text-white font-medium">{{ $toy->created_at?->format('d.m.Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Oxirgi O'zgarish</p>
                <p class="text-white font-medium">{{ $toy->updated_at?->format('d.m.Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
