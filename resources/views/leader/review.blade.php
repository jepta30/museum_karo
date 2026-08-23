@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <a href="{{ route('leader.dashboard') }}" class="text-sm font-semibold text-gray-500 hover:text-[#4a1b1b] flex items-center gap-1 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Antrean
        </a>
        <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">Tinjau Rekomendasi Koleksi</h1>
        <p class="text-gray-600 text-sm">Validasi dokumen dan sahkan nomor induk koleksi tetap.</p>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        
        <!-- Header Info (Artifact) -->
        <div class="p-8 border-b border-gray-100 flex flex-col md:flex-row gap-8 items-start">
            <div class="w-40 h-40 bg-gray-100 rounded-md overflow-hidden shrink-0 border border-gray-200">
                <img src="{{ asset('storage/' . $collection->path_foto) }}" alt="Foto" class="w-full h-full object-cover">
            </div>
            <div class="flex-1">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-600 rounded text-[10px] font-bold uppercase tracking-wider mb-3">Kategori: {{ $collection->kategori->nama ?? 'Umum' }}</span>
                        <h2 class="text-3xl font-serif font-bold text-[#4a1b1b] mb-2">{{ $collection->nama_sementara }}</h2>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 bg-red-100/50 text-[#8b1c1c] rounded text-[10px] font-bold uppercase tracking-wider border border-red-200/50">
                        Menunggu Tanda Tangan
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-6 mt-6">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Didaftarkan Oleh</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $collection->nama_penyerah }} (Registrar)</p>
                        <p class="text-xs text-gray-500">{{ $collection->created_at->translatedFormat('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Direkomendasikan Oleh</p>
                        <p class="text-sm font-semibold text-gray-800">Tim Kurator</p>
                        <p class="text-xs text-gray-500">{{ $collection->updated_at->translatedFormat('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Riset Kurator -->
        <div class="p-8 bg-[#fcfaf8] border-b border-gray-100">
            <h3 class="text-lg font-serif font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Hasil Riset & Signifikansi Historis
            </h3>
            
            <div class="space-y-6">
                <div>
                    <p class="text-[11px] font-bold text-gray-500 mb-2 uppercase tracking-widest">Konteks Historis</p>
                    <div class="bg-white p-5 rounded border border-gray-200 text-sm text-gray-700 leading-relaxed">
                        {{ $collection->sejarah_asal_usul }}
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-[11px] font-bold text-gray-500 mb-2 uppercase tracking-widest">Kondisi Awal (Pendaftar)</p>
                        <div class="bg-white p-4 rounded border border-gray-200 text-sm text-gray-700">
                            {{ $collection->kondisi_awal ?: '-' }}
                        </div>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-500 mb-2 uppercase tracking-widest">Catatan Kuratorial</p>
                        <div class="bg-white p-4 rounded border border-gray-200 text-sm text-gray-700">
                            {{ $collection->kondisi_kuratorial ?: '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approval Form -->
        <div class="p-8">
            <h3 class="text-lg font-serif font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#8b1c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Otorisasi Pimpinan
            </h3>

            <form action="{{ route('leader.approve', $collection->id) }}" method="POST">
                @csrf
                
                <div class="bg-[#fbf7f5] border border-[#ecdce0] rounded-md p-6 mb-8">
                    <p class="text-xs text-gray-600 mb-4 font-medium">Berdasarkan hasil rekomendasi kurator, draf nomor inventaris untuk koleksi ini adalah <span class="font-bold text-[#8b1c1c]">{{ $collection->draf_nomor_inventaris }}</span>. Anda dapat menyetujui draf ini atau mengubahnya sebelum finalisasi.</p>
                    
                    <label class="block text-[11px] font-bold text-gray-700 mb-2">Nomor Induk Koleksi (NIK) Tetap <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_inventaris_final" required value="{{ $collection->draf_nomor_inventaris }}" class="w-full md:w-1/2 p-3 border border-gray-300 rounded text-sm bg-white focus:outline-none focus:border-[#8b1c1c] focus:ring-1 focus:ring-[#8b1c1c] font-bold text-[#4a1b1b]">
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between pt-4 border-t border-gray-100 gap-4">
                    <p class="text-xs text-gray-500 italic">Dengan menekan tombol Setujui, dokumen Berita Acara Serah Terima akan sah secara institusional.</p>
                    
                    <div class="flex gap-3 w-full md:w-auto">
                        <a href="{{ route('leader.dashboard') }}" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded text-sm font-bold hover:bg-gray-50 transition text-center w-full md:w-auto">Batal</a>
                        <button type="submit" class="px-8 py-3 bg-[#4a1b1b] text-white border border-[#4a1b1b] rounded text-sm font-bold hover:bg-black transition flex items-center justify-center gap-2 w-full md:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Tandatangani & Setujui
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</div>
@endsection
