@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto pb-10">
    <!-- Header with Back Button -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('registrar.dashboard') }}" class="p-2 bg-white border border-gray-200 rounded-full hover:bg-gray-50 transition">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-serif font-bold text-[#2d2d2d]">{{ $koleksi->nama_sementara }}</h1>
            <p class="text-gray-500 text-sm">ID Pendaftaran: {{ $koleksi->batch_id ?? $koleksi->draf_nomor_inventaris ?? '-' }}</p>
        </div>
    </div>

    <!-- Roadmap / Progress Tracker -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-8">
        <h2 class="text-lg font-bold text-gray-800 mb-6 font-serif">Status Kurasi Koleksi Budaya</h2>
        
        <div class="relative flex items-center justify-between">
            <!-- Line Behind -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-gray-200 rounded-full z-0"></div>
            
            @php
                $statusLevel = 1;
                if($koleksi->status == 'menunggu_persetujuan') $statusLevel = 2;
                if(in_array($koleksi->status, ['disetujui', 'dipublikasi'])) $statusLevel = 3;
            @endphp

            <!-- Progress Line -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-[#8b1c1c] rounded-full z-0 transition-all duration-500" 
                 style="width: {{ $statusLevel == 1 ? '0%' : ($statusLevel == 2 ? '50%' : '100%') }};"></div>

            <!-- Step 1: Pendaftaran (Menunggu Kurasi) -->
            <div class="relative z-10 flex flex-col items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $statusLevel >= 1 ? 'bg-[#8b1c1c] text-white shadow-md' : 'bg-white border-2 border-gray-300 text-gray-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div class="text-center">
                    <p class="text-xs font-bold {{ $statusLevel >= 1 ? 'text-gray-900' : 'text-gray-400' }}">Pendaftaran</p>
                    <p class="text-[10px] text-gray-500">Menunggu Penelitian</p>
                </div>
            </div>

            <!-- Step 2: Kurasi (Menunggu Persetujuan) -->
            <div class="relative z-10 flex flex-col items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $statusLevel >= 2 ? 'bg-[#8b1c1c] text-white shadow-md' : 'bg-white border-2 border-gray-300 text-gray-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div class="text-center">
                    <p class="text-xs font-bold {{ $statusLevel >= 2 ? 'text-gray-900' : 'text-gray-400' }}">Riset Kurator</p>
                    <p class="text-[10px] text-gray-500">Menunggu Persetujuan</p>
                </div>
            </div>

            <!-- Step 3: Disetujui (Selesai Dinilai) -->
            <div class="relative z-10 flex flex-col items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $statusLevel >= 3 ? 'bg-[#8b1c1c] text-white shadow-md' : 'bg-white border-2 border-gray-300 text-gray-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-center">
                    <p class="text-xs font-bold {{ $statusLevel >= 3 ? 'text-gray-900' : 'text-gray-400' }}">Disetujui Pimpinan</p>
                    <p class="text-[10px] text-gray-500">Selesai Dinilai</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Input Awal -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="border-b border-gray-100 px-8 py-5 bg-[#fbf8f5]">
            <h2 class="text-lg font-bold text-[#4a1b1b] font-serif">Data Awal Registrasi Koleksi Budaya</h2>
        </div>
        
        <div class="p-8 space-y-8">
            <!-- Informasi Penyerah -->
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Informasi Penyerah</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Nama Lengkap</p>
                        <p class="text-sm font-medium text-gray-900">{{ $koleksi->nama_penyerah }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Pekerjaan</p>
                        <p class="text-sm font-medium text-gray-900">{{ $koleksi->pekerjaan_penyerah ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Tempat, Tanggal Lahir</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $koleksi->tempat_lahir_penyerah ?? '-' }}, 
                            {{ $koleksi->tanggal_lahir_penyerah ? \Carbon\Carbon::parse($koleksi->tanggal_lahir_penyerah)->translatedFormat('d M Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Alamat</p>
                        <p class="text-sm font-medium text-gray-900">{{ $koleksi->alamat_penyerah ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Detail Koleksi -->
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Spesifikasi Koleksi Budaya</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Nama Koleksi (Sementara)</p>
                        <p class="text-sm font-medium text-gray-900">{{ $koleksi->nama_sementara }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Kategori / Jenis</p>
                        <p class="text-sm font-medium text-gray-900">
                            <span class="inline-flex px-2.5 py-1 rounded bg-gray-100 border border-gray-200 text-xs font-semibold">
                                {{ $koleksi->kategori->nama ?? 'Tidak Ada' }}
                            </span>
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 mb-1">Klaim Asal Usul / Cerita</p>
                        <p class="text-sm font-medium text-gray-900 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            {{ $koleksi->klaim_asal_usul ?? 'Belum ada data klaim sejarah awal.' }}
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 mb-1">Kondisi Saat Diterima</p>
                        <p class="text-sm font-medium text-gray-900 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            {{ $koleksi->kondisi_awal ?? 'Belum dideskripsikan kondisinya.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Foto -->
            @if($koleksi->path_foto)
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Lampiran Foto</h3>
                <div class="w-full md:w-1/2 aspect-[4/3] rounded-xl overflow-hidden border border-gray-200">
                    <img src="{{ Storage::url($koleksi->path_foto) }}" alt="Foto Koleksi Budaya" class="w-full h-full object-cover">
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
