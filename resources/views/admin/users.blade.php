@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-10">
    <!-- Header Section -->
    <div class="mb-8 flex justify-between items-end">
        <div>
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Karo Cultural Museum</p>
            <h1 class="text-3xl font-serif font-bold text-[#4a1c1c]">Manajemen Akun & Keamanan</h1>
        </div>
        <div class="flex items-center gap-4">
            <button class="text-gray-500 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </button>
            <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden border-2 border-white shadow-sm flex items-center justify-center font-bold text-gray-500">
                AD
            </div>
        </div>
    </div>

    <!-- Cards Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <!-- Card 1 -->
        <div class="bg-[#fdfbf9] border border-gray-200 rounded-xl p-6 relative">
            <svg class="w-16 h-16 absolute right-6 top-6 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Total Pengguna Aktif</h3>
            <div class="flex items-baseline gap-2 mb-6">
                <span class="text-5xl font-serif font-bold text-gray-900">{{ $totalAktif }}</span>
                <span class="text-sm font-medium text-gray-500">Staf Museum</span>
            </div>
            
        </div>

        <!-- Card 2 -->
        <div class="bg-[#fdfbf9] border border-red-100 rounded-xl p-6 relative">
            <svg class="w-16 h-16 absolute right-6 top-6 text-red-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Aktivitas Ditandai</h3>
            <div class="flex items-baseline gap-2 mb-6">
                <span class="text-5xl font-serif font-bold text-red-700">{{ $peringatan }}</span>
                <span class="text-sm font-medium text-gray-500">Peringatan 24 jam terakhir</span>
            </div>
            <a href="#" class="text-sm font-bold text-[#62231c] hover:text-red-800 flex items-center gap-1 transition">
                Tinjau Log 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8">
        <!-- Left: Daftar Pengguna -->
        <div class="col-span-1">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-serif font-bold text-[#4a1c1c]">Daftar Pengguna</h2>
                <a href="{{ route('admin.roles') }}" class="px-4 py-2 bg-[#4c1d1d] text-white text-sm font-semibold rounded hover:bg-red-900 transition flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Tambah Staf
                </a>
            </div>

            <div class="bg-[#fdfbf9] border border-orange-100 rounded-xl overflow-hidden shadow-sm">
                <table class="w-full text-left text-sm text-gray-700">
                    <thead class="text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-orange-100 bg-orange-50/50">
                        <tr>
                            <th class="px-6 py-4">Nama / Kontak</th>
                            <th class="px-6 py-4">Peran</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Login Terakhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-orange-100">
                        @foreach($users as $user)
                        <tr class="hover:bg-white transition">
                            <td class="px-6 py-4 flex items-center gap-4">
                                <div class="w-10 h-10 rounded bg-[#eee3db] flex items-center justify-center font-bold text-[#62231c] shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                    <div class="text-[11px] text-gray-500">{{ $user->email }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 font-medium capitalize">
                                {{ $user->peran === 'pimpinan' ? 'Direktur' : ($user->peran === 'kurator' ? 'Kurator Utama' : $user->peran) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_active)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold uppercase rounded-full tracking-wide">Aktif</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-200 text-gray-600 text-[10px] font-bold uppercase rounded-full tracking-wide">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-[11px] text-gray-500 leading-tight">
                                @if($user->last_login_at)
                                    {{ $user->last_login_at->isToday() ? 'Hari ini' : ($user->last_login_at->isYesterday() ? 'Kemarin' : $user->last_login_at->format('d M Y')) }},<br>
                                    {{ $user->last_login_at->format('H:i') }}
                                @else
                                    Belum pernah<br>login
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-orange-100 flex items-center justify-between text-xs text-gray-500 bg-orange-50/30">
                    <span>Menampilkan {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} pengguna</span>
                    <div class="flex gap-2">
                        <a href="{{ $users->previousPageUrl() }}" class="px-3 py-1.5 border border-gray-300 rounded hover:bg-gray-50 font-medium flex items-center gap-1 {{ $users->onFirstPage() ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            Prev
                        </a>
                        <a href="{{ $users->nextPageUrl() }}" class="px-3 py-1.5 border border-gray-300 rounded hover:bg-gray-50 font-medium flex items-center gap-1 {{ !$users->hasMorePages() ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                            Next
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
