@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-10">
    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-3xl font-serif font-bold text-[#2d2d2d] mb-2">Selamat Datang, Staff Register</h1>
        <p class="text-gray-500">Kelola registrasi koleksi baru dan pantau status kurasi hari ini.</p>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Card 1: Menunggu Penelitian -->
        <div class="bg-[#fff9eb] border border-[#fce9c2] rounded-xl p-6">
            <h3 class="text-sm font-bold text-[#e05d2d] mb-4">Menunggu Penelitian</h3>
            <p class="text-5xl font-serif font-bold text-[#e05d2d]">{{ $menungguCount }}</p>
        </div>
        
        <!-- Card 2: Sedang Dinilai -->
        <div class="bg-[#f0f6fd] border border-[#d2e6fa] rounded-xl p-6">
            <h3 class="text-sm font-bold text-[#1f69b8] mb-4">Sedang Dinilai</h3>
            <p class="text-5xl font-serif font-bold text-[#1f69b8]">{{ $dinilaiCount }}</p>
        </div>

        <!-- Card 3: Selesai Dinilai -->
        <div class="bg-[#eaf5eb] border border-[#c3e3c6] rounded-xl p-6">
            <h3 class="text-sm font-bold text-[#2d7f38] mb-4">Selesai Dinilai</h3>
            <p class="text-5xl font-serif font-bold text-[#2d7f38]">{{ $selesaiCount }}</p>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-serif font-bold text-[#2d2d2d]">Aktivitas Terbaru</h2>
            <a href="{{ route('registrar.create') }}" class="text-sm font-bold text-[#653333] hover:underline flex items-center gap-1">
                Pendaftaran Baru <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="bg-[#fbf8f5] border-b border-[#f0e8df]">
                            <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest w-1/5">Nomor Induk Koleksi</th>
                            <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest w-1/4">Nama Koleksi</th>
                            <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest">Tanggal Masuk</th>
                            <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest">Status</th>
                            <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($aktivitasTerbaru as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6 text-sm font-bold text-gray-700">
                                {{ $item->batch_id ?? $item->draf_nomor_inventaris ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-800">
                                {{ $item->nama_sementara }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($item->tanggal_terima)->translatedFormat('d M Y') }}
                            </td>
                            <td class="py-4 px-6">
                                @if($item->status === 'menunggu_kurasi')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-[#fff9eb] text-[#e05d2d] border border-[#fce9c2]">
                                        Menunggu Penelitian
                                    </span>
                                @elseif($item->status === 'menunggu_persetujuan')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-[#f0f6fd] text-[#1f69b8] border border-[#d2e6fa]">
                                        Sedang Dinilai
                                    </span>
                                @elseif(in_array($item->status, ['disetujui', 'dipublikasi']))
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-[#eaf5eb] text-[#2d7f38] border border-[#c3e3c6]">
                                        Selesai Dinilai
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                        Diarsipkan
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($item->status === 'menunggu_kurasi')
                                    <a href="{{ route('registrar.show', $item->id) }}" class="text-gray-400 hover:text-gray-700" title="Lihat Detail Pendaftaran">
                                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                @else
                                    <a href="{{ route('registrar.show', $item->id) }}" class="text-gray-400 hover:text-gray-700" title="Lihat Detail Pendaftaran">
                                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 px-6 text-center text-sm text-gray-500">
                                Belum ada aktivitas pendaftaran.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
