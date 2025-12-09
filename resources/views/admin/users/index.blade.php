@extends('layouts.admin')

@section('title', 'Foydalanuvchilar')
@section('page-title', 'Foydalanuvchilar')

@section('content')
<!-- Header Section -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-white mb-2">Foydalanuvchilar</h1>
        <p class="text-gray-400">Tizim foydalanuvchilarini boshqarish</p>
    </div>
    @can('create-users')
    <a href="{{ route('admin.users.create') }}" 
       class="px-6 py-3 bg-green-600 hover:bg-green-700 rounded-lg text-white font-medium transition-all shadow-lg hover:shadow-green-500/50">
        <i class="fas fa-user-plus mr-2"></i>Yangi Foydalanuvchi
    </a>
    @endcan
</div>

<!-- Users Table -->
<div class="bg-slate-800 rounded-xl shadow-lg overflow-hidden border border-slate-700">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-700">
            <thead class="bg-slate-750">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                        <i class="fas fa-hashtag mr-2"></i>ID
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                        <i class="fas fa-user mr-2"></i>Foydalanuvchi
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                        <i class="fas fa-envelope mr-2"></i>Email
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                        <i class="fas fa-phone mr-2"></i>Telefon
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                        <i class="fas fa-user-tag mr-2"></i>Rollar
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                        <i class="fas fa-toggle-on mr-2"></i>Holat
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                        <i class="fas fa-cogs mr-2"></i>Amallar
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @forelse($users as $user)
                <tr class="hover:bg-slate-700 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-gray-300 font-mono">{{ $user->id }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-300">{{ $user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-300">{{ $user->phone ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-wrap gap-1">
                            @foreach($user->roles as $role)
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-500 bg-opacity-20 text-blue-400 border border-blue-500">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->is_active)
                            <span class="px-3 py-1 text-xs rounded-full bg-green-500 bg-opacity-20 text-green-400 border border-green-500 font-medium">
                                <i class="fas fa-check-circle mr-1"></i>Faol
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-red-500 bg-opacity-20 text-red-400 border border-red-500 font-medium">
                                <i class="fas fa-times-circle mr-1"></i>Nofaol
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.users.show', $user) }}" 
                               class="p-2 bg-blue-500 bg-opacity-20 text-blue-400 rounded-lg hover:bg-opacity-30 transition-all"
                               title="Ko'rish">
                                <i class="fas fa-eye"></i>
                            </a>
                            @can('edit-users')
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="p-2 bg-yellow-500 bg-opacity-20 text-yellow-400 rounded-lg hover:bg-opacity-30 transition-all"
                               title="Tahrirlash">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @can('delete-users')
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 bg-red-500 bg-opacity-20 text-red-400 rounded-lg hover:bg-opacity-30 transition-all"
                                        title="O'chirish"
                                        onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-users text-gray-600 text-5xl mb-4"></i>
                            <p class="text-gray-400 text-lg">Foydalanuvchilar topilmadi</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-slate-700">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
