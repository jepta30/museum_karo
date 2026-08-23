@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <div class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('educator.dashboard') }}" class="hover:text-museum-red">Dasbor</a>
        <span class="mx-2">/</span>
        @if($koleksi)
            <a href="{{ route('educator.koleksi.show', $koleksi->id) }}" class="hover:text-museum-red">{{ $koleksi->nama_sementara }}</a>
            <span class="mx-2">/</span>
        @endif
        <span class="text-gray-800 font-medium">Buat Draf Modul Edukasi</span>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="bg-[#fdf9f4] border-b border-[#f0e3d3] p-6">
            <h1 class="text-2xl font-serif font-bold text-[#6d3e3e]">Tulis Modul Edukasi Baru</h1>
            <p class="text-sm text-gray-600 mt-1">Buat narasi sejarah dan edukasi yang menarik untuk pengunjung museum.</p>
        </div>

        <form action="{{ route('educator.modul.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            @if($koleksi)
                <input type="hidden" name="koleksi_id" value="{{ $koleksi->id }}">
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex items-start gap-4">
                    <div class="w-16 h-16 bg-white rounded border border-gray-200 flex-shrink-0 overflow-hidden">
                        @if($koleksi->path_foto)
                            <img src="{{ Storage::url($koleksi->path_foto) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-full h-full text-gray-300 p-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                        @endif
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Artefak Terkait: {{ $koleksi->nama_sementara }}</h4>
                        <p class="text-xs text-gray-600 mt-1 leading-relaxed line-clamp-2">
                            {{ $koleksi->deskripsi ?? $koleksi->kondisi_kuratorial ?? 'Tidak ada catatan kuratorial rinci.' }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Judul Modul -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Judul Materi / Modul <span class="text-red-500">*</span></label>
                <input type="text" name="judul" required placeholder="Contoh: Kisah Uis Nipes dalam Upacara Adat..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm transition font-medium">
            </div>

            <!-- Konten Utama -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Isi Materi Edukasi <span class="text-red-500">*</span></label>
                <div class="border border-gray-300 rounded-md overflow-hidden focus-within:ring-1 focus-within:ring-museum-red focus-within:border-museum-red transition">
                    <!-- Basic formatting toolbar mockup (visual only for now) -->
                    <div class="bg-gray-50 border-b border-gray-300 px-3 py-2 flex items-center gap-2">
                        <button type="button" class="p-1.5 text-gray-500 hover:bg-gray-200 rounded"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6 4h12v3h-3v12h-2V7h-2v12H9V7H6z"></path></svg></button>
                        <button type="button" class="p-1.5 text-gray-500 hover:bg-gray-200 rounded"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M10 4v3h2.21l-3.42 8H6v3h8v-3h-2.21l3.42-8H18V4z"></path></svg></button>
                        <div class="w-px h-4 bg-gray-300 mx-1"></div>
                        <button type="button" class="p-1.5 text-gray-500 hover:bg-gray-200 rounded text-xs font-bold font-serif">A</button>
                    </div>
                    <textarea name="konten" required rows="15" placeholder="Tuliskan narasi yang edukatif, sejarah, filosofi, atau cara penggunaan artefak ini..." 
                              class="w-full px-4 py-4 border-none focus:ring-0 text-sm leading-relaxed resize-y"></textarea>
                </div>
                <p class="text-[11px] text-gray-500 mt-2">* Tulis dengan bahasa yang mudah dipahami oleh pengunjung umum atau pelajar.</p>
            </div>

            <!-- Aksi -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ url()->previous() }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-md transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-museum-red text-white text-sm font-semibold rounded-md shadow-sm hover:bg-red-900 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan sebagai Draf
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
