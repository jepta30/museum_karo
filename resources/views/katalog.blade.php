@extends('layouts.public')

@section('title', 'Katalog Koleksi Museum')

@section('content')
<div class="bg-[#faf7f2] border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-12 md:py-16">
        <h1 class="text-3xl md:text-4xl font-serif font-bold text-[#4a1c1c] text-center mb-4">Katalog Koleksi Museum</h1>
        <p class="text-gray-600 text-center max-w-2xl mx-auto text-sm md:text-base leading-relaxed">
            Eksplorasi jejak sejarah dan kekayaan budaya peninggalan leluhur suku Karo melalui koleksi artefak dan benda pusaka yang telah direstorasi dan didokumentasikan.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 py-10 min-h-screen">
    
    <!-- Filter dan Pencarian -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm mb-10">
        <form action="{{ route('katalog') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama koleksi atau deskripsi..." class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-[#8b1c1c] focus:border-[#8b1c1c] bg-gray-50">
                </div>
            </div>

            <div class="md:w-64">
                <select name="kategori" class="block w-full py-2.5 px-3 border border-gray-300 rounded-lg text-sm focus:ring-[#8b1c1c] focus:border-[#8b1c1c] bg-gray-50 text-gray-700">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori->id }}" {{ $kategoriId == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-[#4a1c1c] text-white font-semibold text-sm rounded-lg hover:bg-[#3a1515] transition shadow-sm">
                    Terapkan Filter
                </button>
            </div>
            
            @if($search || $kategoriId)
            <div>
                <a href="{{ route('katalog') }}" class="w-full md:w-auto px-6 py-2.5 bg-gray-100 text-gray-700 font-semibold text-sm rounded-lg hover:bg-gray-200 transition text-center block">
                    Reset
                </a>
            </div>
            @endif

        </form>
    </div>

    <!-- Daftar Koleksi -->
    @if($modulEdukasi->isEmpty())
        <div class="bg-white border border-gray-200 rounded-xl p-12 text-center shadow-sm">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak ada koleksi ditemukan</h3>
            <p class="text-gray-500 text-sm max-w-md mx-auto">Kami tidak dapat menemukan koleksi yang sesuai dengan kata kunci atau filter pencarian Anda. Silakan coba kata kunci lain.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($modulEdukasi as $modul)
            <a href="{{ url('/koleksi/' . $modul->id) }}" class="group bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-lg transition duration-300 block">
                <div class="aspect-[4/3] bg-gray-100 relative overflow-hidden">
                    @if($modul->koleksi->path_foto)
                        <img src="{{ Storage::url($modul->koleksi->path_foto) }}" alt="{{ $modul->koleksi->nama_sementara }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 bg-white/90 backdrop-blur text-[#8b1c1c] text-[10px] font-bold tracking-wider uppercase rounded">
                            {{ $modul->koleksi->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                    </div>
                </div>
                
                <div class="p-5">
                    <h3 class="font-serif font-bold text-gray-900 text-lg mb-2 group-hover:text-[#8b1c1c] transition line-clamp-1">
                        {{ $modul->judul }}
                    </h3>
                    
                    @php
                        $kontenData = json_decode($modul->konten, true);
                        $deskripsi_umum = is_array($kontenData) ? ($kontenData['deskripsi_umum'] ?? '') : $modul->konten;
                    @endphp
                    
                    <p class="text-gray-500 text-sm line-clamp-2 mb-4 leading-relaxed">
                        {{ Str::limit(strip_tags($deskripsi_umum), 100) }}
                    </p>
                    
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            No. Inv: {{ $modul->koleksi->nomor_inventaris_final ?? 'Belum ada' }}
                        </div>
                        <div class="text-[#8b1c1c] opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-10 flex justify-center">
            {{ $modulEdukasi->appends(['search' => $search, 'kategori' => $kategoriId])->links() }}
        </div>
    @endif
</div>
@endsection
