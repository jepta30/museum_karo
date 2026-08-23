@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto h-full flex flex-col">
    
    <!-- HEADER -->
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-[#4a1b1b] mb-2">Portal Pimpinan</h1>
            <p class="text-gray-600 font-medium">Ringkasan operasional dan persetujuan institusional.</p>
        </div>
        <div class="text-right pb-1">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Status Sistem</p>
            <p class="text-sm font-semibold text-gray-700 flex items-center gap-2 justify-end">
                <span class="w-2 h-2 rounded-full bg-green-500 block"></span> Sinkronisasi Aktif
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-md text-sm font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <!-- CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
        
        <!-- Card 1 -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative overflow-hidden flex flex-col justify-center min-h-[140px]">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2 z-10 relative">Total Koleksi Budaya Terdata</p>
            <h2 class="text-5xl font-serif font-bold text-gray-900 mb-2 z-10 relative">{{ number_format($totalKoleksi) }}</h2>
            <p class="text-sm font-semibold text-green-600 flex items-center gap-1 z-10 relative">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +{{ $bulanIni }} bulan ini
            </p>
            <!-- Watermark Icon -->
            <svg class="absolute -right-6 -bottom-6 w-40 h-40 text-gray-50 opacity-50 z-0" fill="currentColor" viewBox="0 0 24 24"><path d="M4 10v7h3v-7H4zm6 0v7h3v-7h-3zM2 22h19v-3H2v3zm14-12v7h3v-7h-3zm-4.5-9L2 6v2h19V6l-9.5-5z"></path></svg>
        </div>

        <!-- Card 2 -->
        <div class="lg:col-span-2 bg-[#f4efe8] rounded-r-xl border-l-4 border-museum-red shadow-sm p-6 flex flex-col justify-center min-h-[140px]">
            <p class="text-[11px] font-bold text-[#8b1c1c] uppercase tracking-widest mb-2">Menunggu Persetujuan</p>
            <h2 class="text-5xl font-serif font-bold text-[#4a1b1b] mb-2">{{ $menungguPersetujuanCount }}</h2>
            <p class="text-sm font-bold text-gray-600 flex items-center gap-1">
                ! Tindakan diperlukan
            </p>
        </div>
        
    </div>

    <!-- TABLE SECTION -->
    <div class="flex-1 flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-serif font-bold text-gray-800">Antrean Persetujuan</h3>
            <a href="#" class="text-sm font-bold text-[#4a1b1b] hover:underline flex items-center gap-1">
                Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fcfaf8] border-b border-gray-100">
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest w-1/3">Dokumen / Budaya</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest">Jenis Laporan</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest">Diajukan Oleh</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest">Status</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-500 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($antreanPersetujuan as $item)
                    <tr class="hover:bg-gray-50 transition group">
                        <td class="py-5 px-6">
                            <p class="font-serif font-bold text-[#4a1b1b] text-base mb-1">{{ $item->nama_sementara }}</p>
                            <p class="text-xs text-gray-500 font-medium">(Registrasi #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }})</p>
                        </td>
                        <td class="py-5 px-6">
                            <p class="text-sm font-semibold text-gray-700">Berita Acara Serah Terima</p>
                        </td>
                        <td class="py-5 px-6">
                            <p class="text-sm font-semibold text-gray-700">Tim Kurator</p>
                            <p class="text-[10px] text-gray-400 mt-0.5 uppercase tracking-wide">Pembaruan: {{ $item->updated_at->format('d/m/Y') }}</p>
                        </td>
                        <td class="py-5 px-6">
                            <span class="inline-flex items-center px-3 py-1 bg-red-100/50 text-[#8b1c1c] rounded text-[10px] font-bold uppercase tracking-wider border border-red-200/50">
                                Menunggu Tanda Tangan
                            </span>
                        </td>
                        <td class="py-5 px-6 text-right">
                            <a href="{{ route('leader.review', $item->id) }}" class="inline-block px-5 py-2 border border-gray-200 text-gray-700 font-bold text-xs rounded hover:bg-gray-50 hover:border-gray-300 transition">
                                Tinjau
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="font-serif text-lg">Tidak ada dokumen yang menunggu persetujuan.</p>
                        </td>
                    </tr>
                    @endforelse

                    <!-- Mock Row just to show alternative status like the image if empty -->
                    @if($antreanPersetujuan->isEmpty())
                    <tr class="hover:bg-gray-50 transition opacity-50">
                        <td class="py-5 px-6">
                            <p class="font-serif font-bold text-[#4a1b1b] text-base mb-1">Kain Uis Nipes (Restorasi)</p>
                            <p class="text-xs text-gray-500 font-medium">(Registrasi #8822)</p>
                        </td>
                        <td class="py-5 px-6">
                            <p class="text-sm font-semibold text-gray-700">Persetujuan Anggaran</p>
                        </td>
                        <td class="py-5 px-6">
                            <p class="text-sm font-semibold text-gray-700">Ibu Ginting (Konservasi)</p>
                        </td>
                        <td class="py-5 px-6">
                            <span class="inline-flex items-center px-3 py-1 bg-[#f4efe8] text-gray-600 rounded text-[10px] font-bold uppercase tracking-wider border border-[#ecdce0]">
                                Peninjauan Lanjutan
                            </span>
                        </td>
                        <td class="py-5 px-6 text-right">
                            <a href="#" class="inline-block px-5 py-2 border border-gray-200 text-gray-700 font-bold text-xs rounded hover:bg-gray-50 transition">
                                Tinjau
                            </a>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
