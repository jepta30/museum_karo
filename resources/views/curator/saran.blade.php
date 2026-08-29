@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto pb-10 mt-6 px-4">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif font-bold text-[#4a1c1c] mb-2">Kesan & Pesan</h1>
            <p class="text-gray-600 text-sm">Masukan, saran, dan pesan dari pengunjung website Museum Pusaka Karo.</p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-gray-800">Daftar Kesan & Pesan</h3>
            <span class="bg-gray-200 text-gray-700 text-xs font-bold px-3 py-1 rounded-full">{{ $saranPesan->total() }} Pesan</span>
        </div>
        
        @if($saranPesan->isEmpty())
            <div class="p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Pesan</h3>
                <p class="text-gray-500 text-sm">Saat ini belum ada saran dan pesan dari pengunjung.</p>
            </div>
        @else
            <div class="divide-y divide-gray-100">
                @foreach($saranPesan as $saran)
                <div class="p-6 hover:bg-gray-50 transition">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-[#f7f2ed] flex items-center justify-center text-[#8b1c1c] font-bold shrink-0">
                            {{ substr($saran->nama, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="font-bold text-gray-900">{{ $saran->nama }}</h4>
                                <span class="text-xs text-gray-500">{{ $saran->created_at->diffForHumans() }}</span>
                            </div>
                            @if($saran->email)
                            <div class="text-xs text-gray-500 mb-3 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $saran->email }}
                            </div>
                            @endif
                            
                            <div class="bg-white border border-gray-200 rounded-lg p-4 text-sm text-gray-700 leading-relaxed mt-2 shadow-sm relative">
                                <div class="absolute -top-2 left-4 w-4 h-4 bg-white border-t border-l border-gray-200 transform rotate-45"></div>
                                {{ $saran->pesan }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $saranPesan->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
