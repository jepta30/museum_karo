@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-10">
    <!-- Breadcrumb -->
    <div class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('curator.dashboard') }}" class="hover:text-museum-red">Ruang Kerja Kurator</a>
        <span class="mx-2">/</span>
        <span class="text-gray-800 font-medium">{{ $selectedCollection->nama_sementara }}</span>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Header Item -->
    <div class="flex flex-col md:flex-row gap-6 mb-8 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <div class="w-32 h-32 md:w-40 md:h-40 bg-gray-100 rounded-lg overflow-hidden shrink-0 border border-gray-200">
            @if($selectedCollection->path_foto)
                <img src="{{ Storage::url($selectedCollection->path_foto) }}" alt="Foto" class="w-full h-full object-cover">
            @else
                <svg class="w-full h-full text-gray-300 p-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
            @endif
        </div>
        <div class="flex-1 flex flex-col justify-center">
            <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">{{ $selectedCollection->nama_sementara }}</h1>
            <p class="text-sm text-gray-500 mb-4">Diserahkan oleh <span class="font-bold text-gray-700">{{ $selectedCollection->nama_penyerah ?? 'Tidak diketahui' }}</span> pada {{ \Carbon\Carbon::parse($selectedCollection->tanggal_terima)->translatedFormat('d M Y') }}</p>
            
            <div class="flex gap-4">
                <div class="bg-gray-50 px-3 py-2 border border-gray-200 rounded">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Status Saat Ini</p>
                    <p class="text-sm font-semibold text-gray-800">{{ str_replace('_', ' ', Str::title($selectedCollection->status)) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Awal dari Pendaftar (Read Only) -->
    <div class="bg-[#fdf9f4] border border-[#f0e3d3] rounded-xl shadow-sm mb-10 overflow-hidden">
        <div class="bg-[#f0e3d3] px-6 py-4">
            <h3 class="font-serif font-bold text-[#6d3e3e]">Informasi Pra-Registrasi</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pekerjaan / Latar Belakang Penyerah</p>
                <p class="text-sm text-gray-800">{{ $selectedCollection->pekerjaan_penyerah ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Alamat Penyerah</p>
                <p class="text-sm text-gray-800">{{ $selectedCollection->alamat_penyerah ?? '-' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Klaim Asal Usul Sejarah (Dari Penyerah)</p>
                <p class="text-sm text-gray-800 bg-white p-4 rounded border border-gray-200 min-h-[60px]">
                    {{ $selectedCollection->klaim_asal_usul ?? 'Tidak ada data klaim yang dicatat.' }}
                </p>
            </div>
            <div class="md:col-span-2">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Kondisi Saat Diterima</p>
                <p class="text-sm text-gray-800 bg-white p-4 rounded border border-gray-200">
                    {{ $selectedCollection->kondisi_awal ?? 'Tidak dicatat.' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Form Riset & Kurasi -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden relative">
        @if($selectedCollection->status === 'menunggu_persetujuan' || $selectedCollection->status === 'disetujui' || $selectedCollection->status === 'dipublikasi')
            <div class="absolute inset-0 bg-white bg-opacity-70 z-10 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow border border-gray-200 text-center max-w-sm">
                    <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-gray-800 font-bold mb-1">Riset Sudah Diajukan</p>
                    <p class="text-sm text-gray-500 mb-4">Koleksi budaya ini sedang atau sudah diproses oleh Pimpinan. Form dikunci.</p>
                    
                    @if($selectedCollection->status === 'disetujui' || $selectedCollection->status === 'dipublikasi')
                        <a href="{{ route('curator.berita_acara', $selectedCollection->id) }}" class="inline-block px-4 py-2 bg-museum-red text-white text-sm font-semibold rounded hover:bg-red-800 transition">
                            Unduh Berita Acara
                        </a>
                    @endif
                </div>
            </div>
        @endif

        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="font-serif font-bold text-xl text-[#1a237e]">Borang Riset & Analisis Kuratorial</h3>
        </div>
        
        <form action="{{ route('curator.update', $selectedCollection->id) }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kategori / Jenis Koleksi</label>
                    <select name="kategori_id" required class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-museum-red focus:border-museum-red text-sm bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ ($selectedCollection->kategori_id == $cat->id) ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Draf Nomor Induk Koleksi (NIK)</label>
                    <input type="text" name="draf_nomor_inventaris" value="{{ old('draf_nomor_inventaris', $selectedCollection->draf_nomor_inventaris) }}" class="w-full px-4 py-2 border border-gray-300 rounded bg-gray-50 focus:ring-museum-red focus:border-museum-red text-sm font-mono text-gray-700">
                    <p class="text-[10px] text-gray-500 mt-1">Digenerate otomatis (YY.TahunKe.NoUrut). Bisa disesuaikan manual.</p>
                </div>
            </div>

            <div class="space-y-8 mb-8">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sejarah & Latar Belakang (Hasil Riset)</label>
                    <textarea name="sejarah_asal_usul" rows="6" placeholder="Masukkan narasi sejarah berdasarkan riset..." class="w-full px-4 py-3 border border-gray-300 rounded focus:ring-museum-red focus:border-museum-red text-sm resize-y leading-relaxed">{{ old('sejarah_asal_usul', $selectedCollection->sejarah_asal_usul) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kondisi Kuratorial & Analisis Artefak</label>
                    <textarea name="kondisi_kuratorial" rows="6" placeholder="Bahan, teknik pembuatan, ukiran, atau kerusakan yang teridentifikasi..." class="w-full px-4 py-3 border border-gray-300 rounded focus:ring-museum-red focus:border-museum-red text-sm resize-y leading-relaxed">{{ old('kondisi_kuratorial', $selectedCollection->kondisi_kuratorial) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('curator.dashboard') }}" class="px-5 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded transition">
                    Kembali
                </a>
                <button type="submit" name="action" value="draft" class="px-5 py-2 bg-white text-gray-800 border border-gray-300 text-sm font-semibold rounded hover:bg-gray-50 transition shadow-sm">
                    Simpan Draf
                </button>
                <button type="submit" name="action" value="submit" class="px-5 py-2 bg-museum-red text-white text-sm font-semibold rounded hover:bg-red-800 transition shadow-sm">
                    Kirim Rekomendasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
