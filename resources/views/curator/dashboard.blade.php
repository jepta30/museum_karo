@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-12">
    <!-- Breadcrumb & Header -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-serif text-[#4a1b1b]">Museum Karo - Ruang Kerja Kurator</h1>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Menunggu Kurasi -->
        <div class="bg-[#fdf6ec] border border-[#f9eedd] rounded-lg p-6 relative overflow-hidden shadow-sm">
            <p class="text-[11px] font-bold text-[#d95c14] uppercase tracking-wider mb-2">Menunggu Kurasi</p>
            <h2 class="text-4xl font-serif font-bold text-[#d95c14]">{{ $countMenunggu }}</h2>
            <div class="absolute right-4 top-4 text-[#f3d9c6]">
                <svg class="w-16 h-16 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
        </div>

        <!-- Dalam Penelitian -->
        <div class="bg-[#f0f5ff] border border-[#e2eafc] rounded-lg p-6 relative overflow-hidden shadow-sm">
            <p class="text-[11px] font-bold text-[#1e56a0] uppercase tracking-wider mb-2">Dalam Penelitian</p>
            <h2 class="text-4xl font-serif font-bold text-[#1e56a0]">{{ $countPenelitian }}</h2>
            <div class="absolute right-4 top-4 text-[#c8d9f4]">
                <svg class="w-16 h-16 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
            </div>
        </div>

        <!-- Rekomendasi Selesai -->
        <div class="bg-[#eef9ee] border border-[#d8f0d8] rounded-lg p-6 relative overflow-hidden shadow-sm">
            <p class="text-[11px] font-bold text-[#1b5e20] uppercase tracking-wider mb-2">Rekomendasi Selesai</p>
            <h2 class="text-4xl font-serif font-bold text-[#1b5e20]">{{ $countSelesai }}</h2>
            <div class="absolute right-4 top-4 text-[#c1e6c1]">
                <svg class="w-16 h-16 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-xl shadow-sm border border-[#f2ebe3] overflow-hidden p-8">
        <h2 class="text-3xl font-serif font-bold text-[#1b1b18] mb-6">Antrean Kurasi Koleksi Budaya</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fdfbf9] border-b border-[#f2ebe3]">
                        <th class="py-4 px-4 font-bold text-[12px] text-gray-500 uppercase tracking-wider">ID Koleksi</th>
                        <th class="py-4 px-4 font-bold text-[12px] text-gray-500 uppercase tracking-wider">Nama Koleksi Budaya</th>
                        <th class="py-4 px-4 font-bold text-[12px] text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
                        <th class="py-4 px-4 font-bold text-[12px] text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-4 font-bold text-[12px] text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2ebe3]">
                    @forelse($koleksi as $item)
                        @php
                            $isSedangDiteliti = ($item->status === 'menunggu_kurasi' && ($item->sejarah_asal_usul || $item->kondisi_kuratorial));
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-4 text-sm text-gray-500 font-medium">#ART-{{ \Carbon\Carbon::parse($item->tanggal_terima)->format('y') }}-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-4 px-4 text-sm text-gray-900 font-bold">{{ $item->nama_sementara }}</td>
                            <td class="py-4 px-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($item->tanggal_terima)->translatedFormat('d M Y') }}</td>
                            <td class="py-4 px-4">
                                @if($item->status === 'menunggu_kurasi' && !$isSedangDiteliti)
                                    <span class="bg-[#fdf6ec] text-[#d95c14] text-[11px] font-bold px-3 py-1 rounded-full border border-[#f9eedd]">Menunggu Kurasi</span>
                                @elseif($isSedangDiteliti)
                                    <span class="bg-[#f0f5ff] text-[#1e56a0] text-[11px] font-bold px-3 py-1 rounded-full border border-[#e2eafc]">Sedang Diteliti</span>
                                @elseif($item->status === 'menunggu_persetujuan')
                                    <span class="bg-[#eef9ee] text-[#1b5e20] text-[11px] font-bold px-3 py-1 rounded-full border border-[#d8f0d8]">Siap Diajukan</span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 text-[11px] font-bold px-3 py-1 rounded-full border border-gray-200">Selesai</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-right">
                                @if($item->status === 'menunggu_kurasi' && !$isSedangDiteliti)
                                    <a href="{{ route('curator.kurasi', ['id' => $item->id]) }}" class="text-sm font-bold text-[#8b1c1c] hover:underline">Tinjau</a>
                                @elseif($isSedangDiteliti)
                                    <a href="{{ route('curator.kurasi', ['id' => $item->id]) }}" class="text-sm font-bold text-[#8b1c1c] hover:underline">Lanjutkan</a>
                                @else
                                    <a href="{{ route('curator.kurasi', ['id' => $item->id]) }}" class="text-sm font-bold text-gray-500 hover:underline">Lihat Detail</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">Belum ada antrean kurasi koleksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $koleksi->links() }}
        </div>
    </div>
</div>
@endsection
