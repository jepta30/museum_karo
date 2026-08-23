@extends('layouts.app')

@section('content')
<div class="h-full flex flex-col md:flex-row gap-6 -m-4"> <!-- -m-4 to offset the main padding slightly for full height -->
    
    <!-- LEFT PANEL: Antrean Riset -->
    <div class="w-full md:w-1/3 lg:w-80 flex flex-col h-[calc(100vh-6rem)] border-r border-gray-200 pr-4">
        
        <div class="flex justify-between items-center mb-6 px-2">
            <h2 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Antrean Riset</h2>
            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-[10px] font-bold">{{ $pendingCollections->count() }} Item</span>
        </div>

        <div class="flex-1 overflow-y-auto space-y-3 pr-2 custom-scrollbar">
            @forelse($pendingCollections as $item)
            <a href="?id={{ $item->id }}" class="block p-4 rounded-md border {{ ($selectedCollection && $selectedCollection->id == $item->id) ? 'bg-[#fbf7f5] border-museum-red shadow-sm' : 'bg-white border-gray-200 hover:border-gray-300' }} transition">
                <div class="flex justify-between items-start mb-2">
                    <span class="text-[10px] font-bold text-gray-400">REF-{{ date('Y', strtotime($item->created_at)) }}-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[10px] text-gray-400">{{ $item->created_at->isToday() ? 'Hari ini' : ($item->created_at->isYesterday() ? 'Kemarin' : $item->created_at->diffForHumans()) }}</span>
                </div>
                <h3 class="font-serif font-bold text-gray-900 mb-1 leading-tight text-lg">{{ $item->nama_sementara }}</h3>
                <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-3">{{ $item->kondisi_awal }}</p>
                
                @if($item->status == 'menunggu_kurasi')
                    <span class="inline-block mt-3 px-2 py-1 bg-[#f5ebe6] text-[#785b4a] rounded text-[9px] font-bold uppercase tracking-wider">Menunggu Riset</span>
                @elseif($item->status == 'menunggu_persetujuan')
                    <!-- Item yang sudah dikirim ke pimpinan -->
                    <div class="mt-3 bg-[#fbf7f5] border border-[#ecdce0] p-2 rounded-md">
                        <p class="text-[9px] font-bold text-gray-500 mb-0.5 uppercase tracking-wider">Nomor Induk Koleksi (NIK) Sementara</p>
                        <p class="text-xs font-bold text-museum-red">{{ $item->draf_nomor_inventaris }}</p>
                    </div>
                    <span class="inline-block mt-3 px-2 py-1 bg-gray-100 text-gray-600 rounded text-[9px] font-bold uppercase tracking-wider">Menunggu Validasi</span>
                @elseif($item->status == 'disetujui')
                    <div class="mt-3 bg-green-50 border border-green-200 p-2 rounded-md">
                        <p class="text-[9px] font-bold text-green-700 mb-0.5 uppercase tracking-wider">Nomor Induk Koleksi (NIK) Tetap</p>
                        <p class="text-xs font-bold text-green-800">{{ $item->nomor_inventaris_final }}</p>
                    </div>
                    <span class="inline-block mt-3 px-2 py-1 bg-green-100 text-green-700 rounded text-[9px] font-bold uppercase tracking-wider">Disetujui Pimpinan</span>
                @endif
            </a>
            @empty
            <div class="text-center py-10 text-gray-400 text-sm">
                Tidak ada antrean riset.
            </div>
            @endforelse
        </div>
    </div>

    <!-- RIGHT PANEL: Main Form -->
    <div class="flex-1 h-[calc(100vh-6rem)] overflow-y-auto pl-2 pr-4 pb-10">
        
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($selectedCollection)
        <!-- Header Item -->
        <div class="flex flex-col md:flex-row gap-6 mb-10">
            <div class="w-32 h-32 md:w-40 md:h-40 bg-gray-100 rounded-md overflow-hidden shrink-0 border border-gray-200">
                <img src="{{ asset('storage/' . $selectedCollection->path_foto) }}" alt="Foto" class="w-full h-full object-cover">
            </div>
            <div class="flex-1 flex flex-col justify-center">
                <h1 class="text-4xl md:text-5xl font-serif font-bold text-gray-900 mb-3 leading-tight">{{ $selectedCollection->nama_sementara }}</h1>
                <p class="text-sm text-gray-600 mb-6">Artefak didaftarkan pada {{ $selectedCollection->created_at->translatedFormat('d F Y') }} oleh <span class="font-semibold">{{ $selectedCollection->nama_penyerah }}</span> (Pendaftar).</p>
                
                <div class="flex gap-4">
                    <div class="bg-[#fbf7f5] border border-[#ecdce0] p-3 rounded-md min-w-[120px]">
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">Status Saat Ini</p>
                        @if($selectedCollection->status == 'menunggu_kurasi')
                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Tugas Aktif</span>
                        @elseif($selectedCollection->status == 'menunggu_persetujuan')
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Menunggu Validasi Pimpinan</span>
                        @elseif($selectedCollection->status == 'disetujui')
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Tervalidasi (Final)</span>
                        @endif
                    </div>
                    <div class="bg-gray-50 border border-gray-200 p-3 rounded-md min-w-[120px]">
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">ID Pendaftaran</p>
                        <p class="text-sm text-gray-800 font-bold">REF-T-{{ date('Y', strtotime($selectedCollection->created_at)) }}-{{ str_pad($selectedCollection->id, 3, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 1: Data Registrar (Read Only) -->
        <div class="bg-[#fcfaf8] border border-gray-200 rounded-md p-6 md:p-8 mb-8">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                <h3 class="text-lg font-serif text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Data Awal Pendaftar
                </h3>
                <span class="px-3 py-1 bg-white text-gray-400 border border-gray-200 rounded text-[10px] font-bold uppercase tracking-widest">Referensi Saja</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-[11px] font-bold text-gray-500 mb-2">Deskripsi Fisik (Pendaftar)</p>
                    <div class="bg-white p-4 rounded border border-gray-100 text-sm text-gray-700 leading-relaxed min-h-[100px]">
                        {{ $selectedCollection->kondisi_awal ?: 'Tidak ada deskripsi fisik.' }}
                    </div>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-gray-500 mb-2">Asal Usul (Klaim Awal)</p>
                    <div class="bg-white p-4 rounded border border-gray-100 text-sm text-gray-700 leading-relaxed min-h-[100px]">
                        Disumbangkan oleh {{ $selectedCollection->nama_penyerah }}. {{ $selectedCollection->klaim_asal_usul }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Form Kurator -->
        <form action="{{ route('curator.update', $selectedCollection->id) }}" method="POST">
            @csrf
            
            <div class="border-t-2 border-museum-red pt-8">
                <h3 class="text-xl font-serif text-gray-900 flex items-center gap-2 mb-8">
                    <svg class="w-6 h-6 text-museum-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Klasifikasi & Riset Kurator
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-2">Kategori Utama Koleksi <span class="text-red-500">*</span></label>
                        <select name="kategori_id" required class="w-full p-3 border border-gray-200 rounded text-sm bg-[#fbf7f5] focus:bg-white focus:outline-none focus:border-museum-red transition" {{ $selectedCollection->status != 'menunggu_kurasi' ? 'disabled' : '' }}>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $selectedCollection->kategori_id == $category->id ? 'selected' : '' }}>{{ $category->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-2">Draf Nomor Inventaris <span class="text-red-500">*</span></label>
                        @if($selectedCollection->status == 'menunggu_kurasi')
                            <input type="text" name="draf_nomor_inventaris" required value="{{ $selectedCollection->draf_nomor_inventaris }}" class="w-full p-3 border border-gray-200 rounded text-sm bg-[#fbf7f5] focus:bg-white focus:outline-none focus:border-museum-red transition">
                            <p class="text-[9px] text-gray-400 mt-1">Format (Bisa Diedit): Tahun (2 Angka) . Tahun ke-berapa sejak 2009 . Jumlah Barang</p>
                        @else
                            <div class="bg-[#fbf7f5] border border-[#ecdce0] p-4 rounded-md">
                                <p class="text-[10px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Nomor Induk Koleksi (NIK) Tetap</p>
                                <p class="text-lg font-bold text-museum-red">{{ $selectedCollection->draf_nomor_inventaris }}</p>
                                <p class="text-[9px] text-gray-400 mt-2">Dihasilkan otomatis oleh sistem pada saat pengiriman.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-[11px] font-bold text-gray-700 mb-2">Konteks & Signifikansi Historis <span class="text-red-500">*</span></label>
                    <div class="border border-gray-200 rounded overflow-hidden">
                        <!-- Toolbar Mock -->
                        <div class="bg-[#f9f5f3] border-b border-gray-200 px-3 py-2 flex gap-4 text-gray-500">
                            <button type="button" class="font-serif font-bold hover:text-black">B</button>
                            <button type="button" class="font-serif italic hover:text-black">I</button>
                            <button type="button" class="hover:text-black"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg></button>
                        </div>
                        <textarea name="sejarah_asal_usul" rows="5" required class="w-full p-4 text-sm text-gray-800 bg-[#fcfaf8] focus:bg-white focus:outline-none" {{ $selectedCollection->status != 'menunggu_kurasi' ? 'readonly' : '' }}>{{ $selectedCollection->sejarah_asal_usul }}</textarea>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-[11px] font-bold text-gray-700 mb-2">Catatan Kondisi Fisik Kuratorial</label>
                    <textarea name="kondisi_kuratorial" rows="3" class="w-full p-4 border border-gray-200 rounded text-sm text-gray-800 bg-[#fcfaf8] focus:bg-white focus:outline-none transition" {{ $selectedCollection->status != 'menunggu_kurasi' ? 'readonly' : '' }}>{{ $selectedCollection->kondisi_kuratorial }}</textarea>
                </div>
                
                <!-- Buttons -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    @if($selectedCollection->status == 'menunggu_kurasi')
                        <div class="flex gap-3 ml-auto">
                            <button type="submit" name="action" value="draft" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded text-sm font-bold hover:bg-gray-50 transition">Simpan Draf</button>
                            <button type="submit" name="action" value="submit" class="px-6 py-2.5 bg-museum-red text-white border border-museum-red rounded text-sm font-bold hover:bg-red-900 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Kirim Rekomendasi ke Pimpinan
                            </button>
                        </div>
                    @elseif($selectedCollection->status == 'menunggu_persetujuan')
                        <div class="flex items-center gap-2 text-[#785b4a]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-xs font-bold w-32 leading-tight">Rekomendasi berhasil dikirim ke Pimpinan</p>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" disabled class="px-6 py-2.5 bg-[#fbf7f5] border border-[#ecdce0] text-gray-400 rounded text-xs font-bold cursor-not-allowed flex items-center gap-2 flex-col justify-center h-14 w-28 text-center leading-tight">
                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Unduh Berita Acara
                            </button>
                            <a href="{{ route('curator.dashboard') }}" class="px-6 py-2.5 bg-[#4a1515] text-white border border-[#4a1515] rounded text-xs font-bold hover:bg-black transition flex items-center gap-2 flex-col justify-center h-14 w-28 text-center leading-tight">
                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Kembali ke Antrean
                            </a>
                        </div>
                    @elseif($selectedCollection->status == 'disetujui')
                        <div class="flex items-center gap-2 text-green-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <p class="text-xs font-bold w-32 leading-tight">Berita Acara Resmi Telah Tersedia</p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('curator.berita_acara', $selectedCollection->id) }}" target="_blank" class="px-6 py-2.5 bg-green-50 border border-green-600 text-green-700 rounded text-xs font-bold hover:bg-green-100 transition flex items-center gap-2 flex-col justify-center h-14 w-28 text-center leading-tight">
                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Unduh Berita Acara
                            </a>
                            <a href="{{ route('curator.dashboard') }}" class="px-6 py-2.5 bg-[#4a1515] text-white border border-[#4a1515] rounded text-xs font-bold hover:bg-black transition flex items-center gap-2 flex-col justify-center h-14 w-28 text-center leading-tight">
                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Kembali ke Antrean
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </form>
        
        @else
        <div class="h-full flex flex-col items-center justify-center text-gray-400">
            <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <p class="text-lg font-serif">Pilih item dari antrean untuk memulai riset.</p>
        </div>
        @endif
    </div>
    
</div>

<style>
/* Custom Scrollbar for Antrean List */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #e5e7eb;
    border-radius: 10px;
}
</style>
@endsection
