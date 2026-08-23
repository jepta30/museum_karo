@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Breadcrumb & Header -->
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-500 mb-4">
            <a href="{{ route('educator.koleksi') }}" class="hover:text-museum-red flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Pustaka
            </a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">{{ $koleksi->nomor_inventaris_final ?? $koleksi->draf_nomor_inventaris }}</span>
        </div>
        
        <h1 class="text-3xl font-serif font-bold text-gray-900 leading-tight mb-2">{{ $koleksi->nama_sementara }}</h1>
        <div class="flex items-center gap-4 text-sm">
            <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                {{ $koleksi->kategori->nama ?? 'Umum' }}
            </span>
            <span class="text-gray-500 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Disetujui pada: {{ $koleksi->updated_at->translatedFormat('d F Y') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content Area -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Image Viewer -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm relative group">
                @if($koleksi->path_foto)
                    <img src="{{ Storage::url($koleksi->path_foto) }}" alt="{{ $koleksi->nama_sementara }}" class="w-full h-auto max-h-[500px] object-contain bg-gray-100">
                    <a href="{{ Storage::url($koleksi->path_foto) }}" download class="absolute bottom-4 right-4 bg-black/70 text-white p-3 rounded-full hover:bg-museum-red transition opacity-0 group-hover:opacity-100 backdrop-blur-sm shadow-lg" title="Unduh Gambar Resolusi Tinggi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>
                @else
                    <div class="w-full h-64 bg-gray-100 flex items-center justify-center text-gray-400">
                        <span class="flex flex-col items-center gap-2">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                            Tidak ada foto tersedia
                        </span>
                    </div>
                @endif
            </div>

            <!-- Kuratorial Notes (Crucial for Educator) -->
            <div class="bg-[#fdf9f4] rounded-xl p-6 border border-[#f0e3d3]">
                <h3 class="text-lg font-serif font-bold text-[#6d3e3e] mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Catatan Kuratorial & Deskripsi
                </h3>
                <div class="prose prose-sm text-gray-700 max-w-none">
                    <p class="leading-relaxed whitespace-pre-wrap">{{ $koleksi->deskripsi ?? $koleksi->kondisi_kuratorial ?? 'Belum ada catatan kuratorial rinci untuk artefak ini.' }}</p>
                </div>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="space-y-6">
            <!-- Action Card -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                <h3 class="text-sm font-bold text-gray-900 mb-3">Siapkan Materi Edukasi</h3>
                <p class="text-xs text-gray-500 mb-4 leading-relaxed">Jadikan data mentah artefak ini sebagai modul edukasi terstruktur untuk dibaca pengunjung.</p>
                
                <form action="{{ route('educator.modul.create') }}" method="GET">
                    <input type="hidden" name="koleksi_id" value="{{ $koleksi->id }}">
                    <button type="submit" class="w-full bg-museum-red text-white font-semibold py-2.5 rounded-lg hover:bg-red-900 transition flex justify-center items-center gap-2 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Mulai Buat Modul
                    </button>
                </form>
            </div>

            <!-- Metadata List -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                <div class="bg-gray-50 border-b border-gray-200 px-5 py-3">
                    <h3 class="font-semibold text-gray-800">Metadata Artefak</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    <div class="px-5 py-3 flex flex-col gap-1">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Nomor Inventaris (NIK)</span>
                        <span class="text-sm font-mono text-gray-800">{{ $koleksi->nomor_inventaris_final ?? $koleksi->draf_nomor_inventaris ?? '-' }}</span>
                    </div>
                    
                    <div class="px-5 py-3 flex flex-col gap-1">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Bahan / Material</span>
                        <span class="text-sm text-gray-800">{{ collect([$koleksi->bahan_utama, $koleksi->bahan_tambahan])->filter()->join(', ') ?: 'Tidak diketahui' }}</span>
                    </div>

                    <div class="px-5 py-3 flex flex-col gap-1">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Dimensi</span>
                        <span class="text-sm text-gray-800">
                            @if($koleksi->panjang || $koleksi->lebar || $koleksi->tinggi)
                                {{ $koleksi->panjang ?? 0 }} x {{ $koleksi->lebar ?? 0 }} x {{ $koleksi->tinggi ?? 0 }} cm
                            @else
                                Tidak dicatat
                            @endif
                            @if($koleksi->berat) ({{ $koleksi->berat }} gr) @endif
                        </span>
                    </div>

                    <div class="px-5 py-3 flex flex-col gap-1">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Asal / Tempat Temuan</span>
                        <span class="text-sm text-gray-800">{{ $koleksi->tempat_pembuatan ?? 'Tidak diketahui' }}</span>
                    </div>

                    <div class="px-5 py-3 flex flex-col gap-1">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Kondisi Fisik</span>
                        <span class="text-sm text-gray-800">{{ $koleksi->kondisi_awal ?? 'Tidak diketahui' }}</span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
