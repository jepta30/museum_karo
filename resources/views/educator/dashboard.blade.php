@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-10">

    <!-- Header Section -->
    <div>
        <h1 class="text-3xl font-serif font-bold text-museum-red mb-2">Ruang Kerja Edukator</h1>
        <p class="text-gray-600">Kelola draf materi dan aset yang telah dikumpulkan.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl">
        <!-- Card 1 -->
        <div class="bg-[#fdf9f4] border border-[#f0e3d3] rounded-lg p-6 relative overflow-hidden shadow-sm">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Koleksi Budaya Terkumpul</h3>
            <div class="text-5xl font-serif font-bold text-[#6d3e3e] mb-4">{{ $koleksiTerkumpul ?: '142' }}</div>
            <div class="text-xs font-semibold flex items-center gap-1 text-green-600">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +{{ $koleksiMingguIni ?: '12' }} minggu ini
            </div>
            
            <div class="absolute -right-6 -bottom-6 text-[#f0e3d3] opacity-50">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L1 7v2h22V7L12 2zm-1 9v8h2v-8h-2zm-4 0v8h2v-8H7zm8 0v8h2v-8h-2zm-12 0v8h2v-8H3zm16 0v8h2v-8h-2zM2 20v2h20v-2H2z"></path>
                </svg>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-[#f9f5f0] border border-[#efe6dc] rounded-lg p-6 relative overflow-hidden shadow-sm">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Draf Koleksi Edukasi</h3>
            <div class="text-5xl font-serif font-bold text-[#6d3e3e] mb-4">{{ $drafMateri ?: '5' }}</div>
            <div class="text-xs font-semibold text-gray-600">
                {{ $siapDipublikasi ?: '2' }} siap dipublikasi
            </div>
            
            <div class="absolute -right-6 -bottom-6 text-[#efe6dc] opacity-60">
                <svg class="w-32 h-32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.5a11.952 11.952 0 00-6.824-2.999 12.083 12.083 0 01.665-6.479L12 14z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0v5.5"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Draf Materi Pembelajaran -->
    <div>
        <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-2">
            <h2 class="text-2xl font-serif text-[#6d3e3e]">Draf Materi Pembelajaran</h2>
            <a href="#" class="text-xs font-bold text-museum-red hover:underline uppercase tracking-wide">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($materiPembelajaran as $materi)
            <div class="bg-[#fcfaf8] border border-[#f2ebe3] rounded-lg overflow-hidden shadow-sm flex flex-col">
                <div class="h-48 bg-gray-200 relative">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($materi->judul) }}&background=E5D1D5&color=6d3e3e&size=400" alt="Cover" class="w-full h-full object-cover opacity-80">
                    <div class="absolute top-3 right-3 bg-black/60 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-sm">
                        {{ ucfirst($materi->status) }}
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-serif text-gray-900 mb-2 leading-tight">{{ $materi->judul }}</h3>
                    <p class="text-sm text-gray-600 mb-6 flex-grow leading-relaxed">{{ Str::limit($materi->konten ?? 'Belum ada konten materi.', 100) }}</p>
                    
                    <div class="flex items-center justify-between text-xs text-gray-500 font-medium mb-5">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Terkait Koleksi
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $materi->updated_at->diffForHumans() }}
                        </div>
                    </div>
                    
                    <button class="w-full py-2.5 border border-[#86515c] text-[#86515c] rounded font-semibold text-sm hover:bg-[#86515c] hover:text-white transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Lanjutkan Menyusun
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-2 text-center py-12 bg-[#fcfaf8] border border-[#f2ebe3] border-dashed rounded-lg">
                <p class="text-gray-500 font-medium">Belum ada draf materi pembelajaran.</p>
                <button class="mt-4 px-6 py-2 bg-museum-red text-white font-semibold rounded hover:bg-red-800 transition">
                    + Buat Draf Baru
                </button>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Aset Terbaru -->
    <div>
        <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-2">
            <h2 class="text-2xl font-serif text-[#6d3e3e]">Aset Terbaru</h2>
            <button class="flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-gray-900 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
        </div>

        <div class="bg-[#fdfaf7] border border-[#f2ebe3] rounded-lg overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-xs text-gray-500 font-bold uppercase tracking-wider border-b border-[#f2ebe3]">
                        <th class="px-6 py-4">NIK Artefak</th>
                        <th class="px-6 py-4">Nama Aset</th>
                        <th class="px-6 py-4">Format File</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2ebe3]">
                    @forelse($asetTerbaru as $aset)
                    <tr class="hover:bg-white transition">
                        <td class="px-6 py-4 text-gray-500 font-mono text-xs">{{ $aset->nomor_inventaris_final ?? $aset->draf_nomor_inventaris ?? '-' }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $aset->nama_sementara }}</td>
                        <td class="px-6 py-4">
                            @php
                                $ext = pathinfo($aset->path_foto, PATHINFO_EXTENSION);
                                $ext = $ext ? strtoupper($ext) : 'JPG';
                            @endphp
                            <span class="inline-block px-2.5 py-1 bg-gray-200 text-gray-700 text-[10px] font-bold rounded uppercase">{{ $ext }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-[11px] font-bold border border-blue-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Tersedia untuk Unduh
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ Storage::url($aset->path_foto) }}" download class="text-museum-red hover:text-red-900 font-medium text-xs flex items-center gap-1">
                                Unduh
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 font-medium">Belum ada aset terbaru yang disetujui.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
