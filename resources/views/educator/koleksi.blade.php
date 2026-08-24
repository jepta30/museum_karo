@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-museum-red mb-2">Pustaka Koleksi Budaya</h1>
            <p class="text-gray-600">Jelajahi dan pilih koleksi budaya yang telah disetujui untuk diubah menjadi materi edukasi.</p>
        </div>
        
        <form action="{{ route('educator.koleksi') }}" method="GET" class="relative w-72">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari koleksi budaya atau NIK..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-museum-red focus:ring-1 focus:ring-museum-red text-sm">
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
    </div>

    @if($koleksi->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($koleksi as $item)
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition group flex flex-col">
                <a href="{{ route('educator.koleksi.show', $item->id) }}" class="aspect-w-4 aspect-h-3 bg-gray-100 relative block">
                    @if($item->path_foto)
                        <img src="{{ Storage::url($item->path_foto) }}" alt="{{ $item->nama_sementara }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-48 flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div class="absolute top-2 right-2 bg-white/90 backdrop-blur text-[10px] font-bold px-2 py-1 rounded text-gray-700 shadow-sm uppercase">
                        {{ $item->kategori->nama ?? 'Tidak Ada Kategori' }}
                    </div>
                </a>
                <div class="p-4 flex flex-col flex-grow">
                    <div class="text-xs font-mono text-museum-red mb-1">{{ $item->nomor_inventaris_final ?? $item->draf_nomor_inventaris ?? 'Menunggu NIK' }}</div>
                    <a href="{{ route('educator.koleksi.show', $item->id) }}" class="font-bold text-gray-900 leading-tight mb-2 flex-grow hover:text-museum-red transition">{{ $item->nama_sementara }}</a>
                    
                    <div class="mt-4 flex gap-2">
                        @if($item->modul)
                            @if($item->modul->status === 'draf')
                                <div class="w-full py-1.5 bg-orange-100 text-orange-800 text-xs font-semibold rounded text-center border border-orange-200">
                                    Status: Draf
                                </div>
                            @else
                                <div class="w-full py-1.5 bg-green-100 text-green-800 text-xs font-semibold rounded text-center border border-green-200">
                                    Terverifikasi
                                </div>
                            @endif
                        @else
                            <form action="{{ route('educator.modul.create') }}" method="GET" class="w-full">
                                <input type="hidden" name="koleksi_id" value="{{ $item->id }}">
                                <button type="submit" class="w-full py-1.5 bg-museum-red text-white text-xs font-semibold rounded hover:bg-red-900 transition text-center">
                                    Buat Modul
                                </button>
                            </form>
                        @endif
                        <a href="{{ Storage::url($item->path_foto) }}" download class="px-3 py-1.5 border border-gray-300 text-gray-600 rounded hover:bg-gray-50 flex items-center justify-center shrink-0" title="Unduh Aset">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $koleksi->links() }}
        </div>
    @else
        <div class="text-center py-20 bg-gray-50 border border-gray-200 border-dashed rounded-xl">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Pustaka Kosong</h3>
            <p class="text-gray-500">Belum ada koleksi budaya yang disetujui atau cocok dengan pencarian Anda.</p>
        </div>
    @endif
</div>
@endsection
