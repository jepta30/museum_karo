@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto h-full flex flex-col">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-4">
        <div>
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-[#4a1b1b] mb-2">Alat Edukasi</h1>
            <p class="text-gray-600 font-medium">Ringkasan Eksekutif & Tinjauan Materi</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="#" class="px-5 py-2.5 border border-gray-400 text-[#4a1b1b] font-bold text-sm rounded hover:bg-gray-50 transition">
                Unduh Laporan
            </a>
            <a href="#" class="px-5 py-2.5 bg-[#4a1b1b] text-white font-bold text-sm rounded border border-[#4a1b1b] hover:bg-black transition">
                Tinjau Materi Menunggu
            </a>
        </div>
    </div>

    <!-- SECTION 1: Metrik Kinerja Edukasi -->
    <div class="mb-12">
        <h3 class="text-2xl font-serif font-bold text-gray-800 mb-6">Metrik Kinerja Edukasi</h3>
        <div class="flex gap-6 max-w-2xl">
            <!-- Card 1: Total Modul -->
            <div class="flex-1 bg-[#fbf8f5] rounded-xl p-6 border border-[#f0e8df] relative overflow-hidden">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[11px] font-bold text-gray-600 uppercase tracking-widest">Total Modul Diterbitkan</p>
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div class="flex items-end gap-3">
                    <h2 class="text-6xl font-serif font-bold text-[#4a1b1b] leading-none">{{ $totalDiterbitkan }}</h2>
                    <p class="text-sm font-semibold text-gray-500 pb-1">+3 bulan ini</p>
                </div>
            </div>

            <!-- Card 2: Menunggu Persetujuan -->
            <div class="flex-1 bg-[#fbf8f5] rounded-xl p-6 border border-[#f0e8df] relative overflow-hidden">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-[11px] font-bold text-gray-600 uppercase tracking-widest">Menunggu Persetujuan</p>
                    <svg class="w-5 h-5 text-[#8b1c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <div class="flex items-end gap-3">
                    <h2 class="text-6xl font-serif font-bold text-[#4a1b1b] leading-none">{{ $menungguPersetujuan }}</h2>
                    <p class="text-sm font-semibold text-gray-500 pb-1">Perlu ditinjau</p>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: Status Alat Edukasi Terkini -->
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-serif font-bold text-gray-800">Status Alat Edukasi Terkini</h3>
            <a href="#" class="text-sm font-bold text-[#4a1b1b] hover:underline">
                Lihat Semua Modul
            </a>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fcfaf8] border-b border-gray-100">
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest">Judul Modul</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest">Penulis</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest">Tanggal</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest">Status</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($modules as $modul)
                    <tr class="hover:bg-gray-50 transition group">
                        <td class="py-5 px-6">
                            <p class="font-bold text-gray-900 text-sm">{{ $modul->judul }}</p>
                        </td>
                        <td class="py-5 px-6">
                            <p class="text-sm text-gray-600">{{ $modul->penulis->name ?? 'Tim Edukasi' }}</p>
                        </td>
                        <td class="py-5 px-6">
                            <p class="text-sm text-gray-600">{{ $modul->created_at->format('d M Y') }}</p>
                        </td>
                        <td class="py-5 px-6">
                            @if($modul->status == 'diterbitkan')
                                <span class="inline-flex px-3 py-1 bg-gray-200/60 text-gray-600 rounded-full text-[10px] font-bold">
                                    Diterbitkan
                                </span>
                            @elseif($modul->status == 'menunggu_persetujuan')
                                <span class="inline-flex px-3 py-1 bg-red-100 text-[#8b1c1c] rounded-full text-[10px] font-bold">
                                    Menunggu Persetujuan
                                </span>
                            @else
                                <span class="inline-flex px-3 py-1 bg-gray-200/60 text-gray-600 rounded-full text-[10px] font-bold">
                                    Draf
                                </span>
                            @endif
                        </td>
                        <td class="py-5 px-6 text-right">
                            @if($modul->status == 'diterbitkan')
                                <a href="#" class="text-[#4a1b1b] font-bold text-xs hover:underline">Lihat Laporan</a>
                            @elseif($modul->status == 'menunggu_persetujuan')
                                <a href="#" class="text-[#4a1b1b] font-bold text-xs hover:underline">Tinjau Materi</a>
                            @else
                                <a href="#" class="text-[#4a1b1b] font-bold text-xs hover:underline">Lihat Detail</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- SECTION 3: Pengawasan Sumber Daya Kurikulum -->
    <div>
        <h3 class="text-2xl font-serif font-bold text-gray-800 mb-6">Pengawasan Sumber Daya Kurikulum</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Box 1: Gambar Resolusi Tinggi -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">
                <div class="w-full md:w-1/2 bg-gray-200 min-h-[240px] relative">
                    <!-- Placeholder using external museum-like image or color blocks -->
                    <div class="absolute inset-0 bg-[#4a1b1b] opacity-10"></div>
                    <!-- Create a collage effect with CSS -->
                    <div class="absolute top-4 left-4 right-4 bottom-4 bg-[#ece5dc] shadow-md transform -rotate-2 flex items-center justify-center p-2">
                        <div class="w-full h-full bg-[url('https://images.unsplash.com/photo-1579762593175-20226054cad0?q=80&w=600')] bg-cover bg-center"></div>
                    </div>
                    <div class="absolute top-8 left-8 right-8 bottom-8 bg-white shadow-lg transform rotate-3 flex items-center justify-center p-2">
                        <div class="w-full h-full bg-[url('https://images.unsplash.com/photo-1596464528148-52b86e0fc21c?q=80&w=600')] bg-cover bg-center"></div>
                    </div>
                </div>
                <div class="p-8 md:w-1/2 flex flex-col justify-between">
                    <div>
                        <h4 class="text-2xl font-serif font-bold text-[#4a1b1b] mb-3 leading-tight">Arsip Gambar<br>Resolusi Tinggi</h4>
                        <p class="text-gray-600 text-sm leading-relaxed mb-6">
                            Koleksi {{ number_format($totalImages) }}+ gambar artefak terverifikasi yang tersedia untuk disisipkan ke dalam modul edukasi.
                        </p>
                    </div>
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-[11px] font-bold text-gray-700 uppercase tracking-widest">Penggunaan Kapasitas</span>
                            <span class="text-sm font-bold text-gray-600">78%</span>
                        </div>
                        <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-[#4a1b1b] rounded-full" style="width: 78%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box 2: Rencana Pelajaran -->
            <div class="bg-[#fbf8f5] rounded-xl shadow-sm border border-[#f0e8df] p-8 flex flex-col justify-between relative overflow-hidden">
                <div>
                    <svg class="w-6 h-6 text-[#4a1b1b] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <h4 class="text-2xl font-serif font-bold text-gray-900 mb-3">Rencana Pelajaran</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Template standar kurikulum nasional
                    </p>
                </div>
                
                <div class="flex justify-between items-end mt-12">
                    <h2 class="text-6xl font-serif font-bold text-[#4a1b1b] leading-none">128</h2>
                    <a href="#" class="text-xs font-bold text-[#4a1b1b] hover:underline">Tinjau Katalog</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
