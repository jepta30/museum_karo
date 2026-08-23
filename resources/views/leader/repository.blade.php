@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto h-full flex flex-col">
    
    <!-- HEADER -->
    <div class="mb-10">
        <h1 class="text-4xl md:text-5xl font-serif font-bold text-[#4a1b1b] mb-2">Repositori Institusi</h1>
        <p class="text-gray-600 font-medium">Penyimpanan pusat untuk dokumen legal, berita acara, dan arsip institusional resmi Museum Karo.</p>
    </div>

    <!-- 3 INFO CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Card 1 -->
        <div class="bg-[#fbf8f5] rounded-xl p-6 border border-[#f0e8df] relative overflow-hidden">
            <div class="flex items-center gap-2 mb-6 z-10 relative">
                <svg class="w-5 h-5 text-[#8b1c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                <p class="text-[11px] font-bold text-gray-600 uppercase tracking-widest">Total Dokumen Tersimpan</p>
            </div>
            <h2 class="text-5xl font-serif font-bold text-[#4a1b1b] z-10 relative">{{ number_format($totalDokumen) }}</h2>
            <!-- Dekorasi Kotak Kanan Atas -->
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#ece5dc] opacity-50 rounded-bl-3xl"></div>
        </div>

        <!-- Card 2 -->
        <div class="bg-[#fbf8f5] rounded-xl p-6 border border-[#f0e8df] relative overflow-hidden">
            <div class="flex items-center gap-2 mb-6 z-10 relative">
                <svg class="w-5 h-5 text-[#8b1c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-[11px] font-bold text-gray-600 uppercase tracking-widest">Berita Acara Baru (Bulan Ini)</p>
            </div>
            <div class="flex items-end gap-3 z-10 relative">
                <h2 class="text-5xl font-serif font-bold text-[#4a1b1b] leading-none">{{ $beritaAcaraBaru }}</h2>
                <span class="inline-flex px-2 py-0.5 bg-red-100 text-[#8b1c1c] rounded text-[10px] font-bold mb-1">+12%</span>
            </div>
            <!-- Dekorasi Kotak Kanan Atas -->
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#ece5dc] opacity-50 rounded-bl-3xl"></div>
        </div>

        <!-- Card 3 -->
        <div class="bg-[#fbf8f5] rounded-xl p-6 border border-[#f0e8df] relative overflow-hidden">
            <div class="flex items-center gap-2 mb-6 z-10 relative">
                <svg class="w-5 h-5 text-[#8b1c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                <p class="text-[11px] font-bold text-gray-600 uppercase tracking-widest">Dokumen Legal Aktif</p>
            </div>
            <h2 class="text-5xl font-serif font-bold text-[#4a1b1b] z-10 relative">15</h2>
            <!-- Dekorasi Kotak Kanan Atas -->
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#ece5dc] opacity-50 rounded-bl-3xl"></div>
        </div>
    </div>

    <!-- MAIN TABLE SECTION -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 flex-1 flex flex-col overflow-hidden mb-8">
        
        <!-- Filters Area -->
        <div class="p-6 border-b border-gray-100 flex flex-col lg:flex-row gap-4 items-center justify-between">
            <div class="relative w-full lg:w-1/2">
                <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" placeholder="Cari dokumen legal, SK, atau berita acara..." class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded text-sm text-gray-700 focus:outline-none focus:border-[#4a1b1b] focus:ring-1 focus:ring-[#4a1b1b] transition">
            </div>
            
            <div class="flex gap-3 w-full lg:w-auto">
                <select class="flex-1 lg:flex-none appearance-none px-4 py-3 bg-white border border-gray-200 rounded text-sm font-semibold text-gray-700 focus:outline-none pr-10 cursor-pointer" style="background-image: url('data:image/svg+xml;utf8,<svg fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' viewBox=\'0 0 24 24\' xmlns=\'http://www.w3.org/2000/svg\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M19 9l-7 7-7-7\'></path></svg>'); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px;">
                    <option>Semua Kategori</option>
                    <option>Berita Acara</option>
                    <option>Surat Keputusan</option>
                    <option>Laporan</option>
                </select>
                <select class="flex-1 lg:flex-none appearance-none px-4 py-3 bg-white border border-gray-200 rounded text-sm font-semibold text-gray-700 focus:outline-none pr-10 cursor-pointer" style="background-image: url('data:image/svg+xml;utf8,<svg fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' viewBox=\'0 0 24 24\' xmlns=\'http://www.w3.org/2000/svg\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M19 9l-7 7-7-7\'></path></svg>'); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px;">
                    <option>Tahun Ini</option>
                    <option>Tahun Lalu</option>
                </select>
                <button class="px-4 py-3 bg-white border border-gray-200 text-gray-700 font-semibold text-sm rounded hover:bg-gray-50 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filter Lainnya
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-white border-b border-gray-100">
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-700 uppercase tracking-widest w-2/5">Nama Dokumen</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-700 uppercase tracking-widest">Kategori</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-700 uppercase tracking-widest">Tanggal Unggah</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-700 uppercase tracking-widest">Ukuran</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-700 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($dokumenList as $doc)
                    <tr class="hover:bg-gray-50 transition group">
                        <td class="py-5 px-6 flex items-start gap-3">
                            <svg class="w-5 h-5 text-[#8b1c1c] mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <div>
                                <p class="font-bold text-[#4a1b1b] text-sm mb-0.5">{{ $doc['nama'] }}</p>
                                <p class="text-[11px] text-gray-400 font-medium">ID: {{ $doc['id_doc'] }}</p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <span class="inline-flex px-3 py-1 bg-[#ece5dc] text-gray-700 rounded-full text-[10px] font-bold">
                                {{ $doc['kategori'] }}
                            </span>
                        </td>
                        <td class="py-5 px-6 text-sm text-gray-600 font-medium">
                            {{ $doc['tanggal'] }}
                        </td>
                        <td class="py-5 px-6 text-sm text-gray-600 font-medium">
                            {{ $doc['ukuran'] }}
                        </td>
                        <td class="py-5 px-6 text-right">
                            <!-- Aksi kosong di desain, tapi disiapkan ruangnya -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="border-t border-gray-100 p-4 px-6 flex justify-between items-center bg-white text-sm">
            <p class="text-gray-500 font-medium">Menampilkan 1-3 dari 2,450 dokumen</p>
            <div class="flex items-center gap-1 text-gray-700 font-bold">
                <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-800 disabled:opacity-50" disabled>&lsaquo;</button>
                <button class="w-8 h-8 flex items-center justify-center bg-[#ece5dc] rounded">1</button>
                <button class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded">2</button>
                <button class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded">3</button>
                <span class="px-2 text-gray-400">...</span>
                <button class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded">245</button>
                <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-800">&rsaquo;</button>
            </div>
        </div>

    </div>
</div>
@endsection
