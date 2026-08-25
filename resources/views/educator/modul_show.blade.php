@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-12">
    <!-- Breadcrumb & Header -->
    <div class="mb-8 border-b border-[#f2ebe3] pb-6">
        <div class="flex items-center gap-3 mb-4">
            <span class="bg-gray-100 text-gray-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Modul Edukasi</span>
            <span class="text-gray-700 text-xs font-bold flex items-center gap-1.5 uppercase tracking-wider">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Terpublikasi
            </span>
        </div>
        
        <h1 class="text-4xl md:text-5xl font-serif font-bold text-gray-900 mb-8 leading-tight">{{ $modul->judul }}</h1>
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <!-- Meta Info -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-6 sm:gap-10">
                <div class="flex items-start gap-3">
                    <div class="text-gray-400 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Disumbangkan Oleh</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $koleksi->nama_penyerah ?? 'Tidak Diketahui' }}</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3">
                    <div class="text-gray-400 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">Terakhir Diperbarui</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $modul->updated_at->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <form action="{{ route('educator.modul.unpublish', $modul->id) }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Anda yakin ingin membatalkan publikasi modul ini? Modul akan kembali menjadi status Draf.')" 
                            class="px-5 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded transition shadow-sm">
                        Batalkan Publikasi
                    </button>
                </form>
                <a href="{{ route('educator.modul.edit', $modul->id) }}" class="px-5 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded transition shadow-sm">
                    Edit Modul
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Deskripsi -->
            <section>
                <h2 class="text-3xl font-serif font-bold text-[#4a1b1b] mb-6">Deskripsi</h2>
                <div class="text-gray-700 leading-loose space-y-4">
                    {!! nl2br(e($deskripsi_umum)) !!}
                </div>
            </section>

            <!-- Sejarah & Makna -->
            @if(trim($sejarah_makna))
            <section>
                <h2 class="text-3xl font-serif font-bold text-[#4a1b1b] mb-6">Sejarah & Makna</h2>
                <div class="text-gray-700 leading-loose space-y-4">
                    {!! nl2br(e($sejarah_makna)) !!}
                </div>
            </section>
            @endif
        </div>

        <!-- Sidebar / Artefak Terkait -->
        <div class="lg:col-span-1">
            <h3 class="text-xl font-serif font-bold text-[#4a1b1b] mb-6">Koleksi Budaya Terkait</h3>
            
            @if($koleksi)
            <div class="bg-white border border-[#f2ebe3] rounded-lg overflow-hidden shadow-sm group">
                <div class="h-48 bg-gray-100 overflow-hidden">
                    @if($koleksi->path_foto)
                        <img src="{{ Storage::url($koleksi->path_foto) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <h4 class="font-bold text-gray-900 text-sm leading-tight">{{ $koleksi->nama_sementara }}</h4>
                        @if($koleksi->no_registrasi)
                            <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded whitespace-nowrap">{{ $koleksi->no_registrasi }}</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-600 leading-relaxed line-clamp-3">
                        {{ $koleksi->deskripsi ?? $koleksi->kondisi_kuratorial ?? 'Tidak ada catatan kuratorial.' }}
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
