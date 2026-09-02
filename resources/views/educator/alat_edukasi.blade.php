@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-[#4a1b1b] mb-2">Alat Edukasi</h1>
            <p class="text-gray-600">Kelola dan publikasikan materi pembelajaran untuk pengunjung dan institusi.</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-[#fdfbf9] border border-[#f2ebe3] rounded-lg p-4 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0">
            <a href="?kategori=semua" class="px-4 py-1.5 rounded-full border {{ request('kategori') == 'semua' || !request('kategori') ? 'border-[#8b1c1c] bg-[#fdf9f4] text-[#8b1c1c] font-semibold' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50' }} text-sm transition whitespace-nowrap">Semua</a>
            @foreach($kategoris as $kat)
                <a href="?kategori={{ urlencode($kat->nama) }}" class="px-4 py-1.5 rounded-full border {{ request('kategori') == $kat->nama ? 'border-[#8b1c1c] bg-[#fdf9f4] text-[#8b1c1c] font-semibold' : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50' }} text-sm transition whitespace-nowrap">{{ $kat->nama }}</a>
            @endforeach
        </div>
        <div>
            <form action="{{ route('educator.alat_edukasi') }}" method="GET" class="flex items-center">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <div class="relative">
                    <select name="status" onchange="this.form.submit()" class="appearance-none bg-[#fdf9f4] border border-[#f0e3d3] text-gray-700 py-1.5 pl-4 pr-10 rounded text-sm focus:outline-none focus:ring-1 focus:ring-museum-red focus:border-museum-red cursor-pointer">
                        <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Status: Semua</option>
                        <option value="draf" {{ request('status') == 'draf' ? 'selected' : '' }}>Status: Draf</option>
                        <option value="terpublikasi" {{ request('status') == 'terpublikasi' ? 'selected' : '' }}>Status: Terpublikasi</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        @forelse($moduls as $modul)
            <div class="bg-white border border-[#f2ebe3] rounded-lg overflow-hidden shadow-sm flex flex-col group hover:shadow-md transition duration-300">
                <!-- Image -->
                <div class="relative h-48 bg-gray-100 overflow-hidden">
                    @if($modul->koleksi && $modul->koleksi->path_foto)
                        <img src="{{ Storage::url($modul->koleksi->path_foto) }}" alt="{{ $modul->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif

                    <!-- Badge -->
                    <div class="absolute top-3 right-3">
                        @if($modul->status === 'diterbitkan')
                            <span class="bg-white/90 backdrop-blur-sm text-[#8b1c1c] text-[10px] font-bold px-2.5 py-1 rounded shadow-sm uppercase tracking-wider flex items-center gap-1.5 border border-[#8b1c1c]/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#8b1c1c] animate-pulse"></span>
                                TERPUBLIS
                            </span>
                        @elseif($modul->status === 'draf')
                            <span class="bg-white/90 backdrop-blur-sm text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                DRAF
                            </span>
                        @else
                            <span class="bg-white/90 backdrop-blur-sm text-gray-700 text-[10px] font-bold px-2.5 py-1 rounded shadow-sm uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                DIPROSES
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Content -->
                <div class="p-5 flex flex-col flex-grow">
                    @if($modul->status === 'diterbitkan')
                        <a href="{{ route('educator.modul.show', $modul->id) }}" class="text-xl font-serif text-gray-900 font-bold mb-2 leading-tight group-hover:text-museum-red transition">
                            {{ $modul->judul }}
                        </a>
                    @else
                        <a href="{{ route('educator.modul.edit', $modul->id) }}" class="text-xl font-serif text-gray-900 font-bold mb-2 leading-tight group-hover:text-museum-red transition">
                            {{ $modul->judul }}
                        </a>
                    @endif
                    
                    @php
                        $kontenData = json_decode($modul->konten, true);
                        $preview = is_array($kontenData) ? ($kontenData['deskripsi_umum'] ?? '') : $modul->konten;
                    @endphp
                    <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed mb-6 flex-grow">
                        {{ strip_tags($preview) ?: 'Belum ada deskripsi.' }}
                    </p>

                    <!-- Footer Info -->
                    <div class="flex items-center justify-between text-[11px] text-gray-500 font-medium pt-4 border-t border-gray-100 mt-auto">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span>{{ $modul->koleksi->kategori->nama ?? 'Umum' }}</span>
                        </div>
                        <div>
                            Diperbarui: {{ $modul->updated_at->translatedFormat('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-[#fdfbf9] border border-[#f2ebe3] border-dashed rounded-xl">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum Ada Alat Edukasi</h3>
                <p class="text-sm text-gray-500">Mulai buat modul pembelajaran dari koleksi budaya museum.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($moduls->hasPages())
        <div class="mb-16">
            {{ $moduls->links() }}
        </div>
    @endif

</div>
@endsection
