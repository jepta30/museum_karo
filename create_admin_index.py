content = """@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto pb-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-serif font-bold text-gray-900 mb-1">Daftar Koleksi Budaya Publik</h1>
            <p class="text-gray-600 text-sm">Manajemen koleksi budaya yang langsung tampil di halaman pengunjung.</p>
        </div>
        
        <div class="flex gap-4">
            <form action="{{ route('admin.koleksi') }}" method="GET" class="relative w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama koleksi..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-museum-red focus:ring-1 focus:ring-museum-red text-sm">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
            <a href="{{ route('admin.koleksi.create') }}" class="flex items-center gap-2 bg-[#8b1c1c] text-white px-4 py-2 rounded-md font-semibold text-sm hover:bg-[#6a1515] transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Koleksi Budaya
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs text-gray-500 uppercase tracking-wider">
                        <th class="p-4 font-semibold">Foto Utama</th>
                        <th class="p-4 font-semibold">Nama / Judul Koleksi</th>
                        <th class="p-4 font-semibold">Kategori</th>
                        <th class="p-4 font-semibold">Nomor Koleksi</th>
                        <th class="p-4 font-semibold">Tanggal Publikasi</th>
                        <th class="p-4 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($koleksi as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4">
                                <div class="w-16 h-16 rounded border border-gray-200 overflow-hidden bg-gray-100 flex items-center justify-center">
                                    @if($item->koleksi && $item->koleksi->path_foto)
                                        <img src="{{ Storage::url($item->koleksi->path_foto) }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4">
                                <p class="font-bold text-gray-900 text-sm">{{ $item->judul }}</p>
                                <p class="text-xs text-gray-500 mt-0.5 truncate max-w-xs">{{ json_decode($item->konten)->deskripsi_umum ?? '' }}</p>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded text-xs font-semibold uppercase tracking-wider">
                                    {{ $item->koleksi->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="p-4 text-sm font-medium text-gray-700">
                                {{ $item->koleksi->nomor_inventaris_final ?? '-' }}
                            </td>
                            <td class="p-4 text-sm text-gray-600">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    Dipublikasikan
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">
                                Tidak ada data koleksi budaya yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($koleksi->hasPages())
        <div class="p-4 border-t border-gray-200">
            {{ $koleksi->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
"""
with open('resources/views/admin/koleksi/index.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
