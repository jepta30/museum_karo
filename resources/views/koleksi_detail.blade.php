@extends('layouts.public')

@section('title', $modul->judul . ' - Museum Pusaka Karo')

@push('styles')
<style>
    .koleksi-hero {
        background: linear-gradient(135deg, #4a0f0f 0%, #7a1b1b 100%);
        padding: 60px 5% 100px;
        color: white;
        text-align: center;
        position: relative;
    }
    .koleksi-hero::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 40px;
        background: #faf7f2;
        border-radius: 40px 40px 0 0;
    }
    .koleksi-badge {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #c9a84c;
        margin-bottom: 10px;
        display: inline-block;
    }
    .koleksi-title {
        font-family: 'Playfair Display', serif;
        font-size: 38px;
        margin-bottom: 15px;
    }
</style>
@endpush

@section('content')

<div class="koleksi-hero">
    <span class="koleksi-badge bg-black/20 px-4 py-1.5 rounded-full backdrop-blur-sm border border-white/10">{{ $koleksi->kategori->nama_kategori ?? 'Umum' }}</span>
    <h1 class="koleksi-title">{{ $modul->judul }}</h1>
    <div class="flex items-center justify-center gap-1.5 text-white/80 text-sm font-medium">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
        Museum Pusaka Karo
    </div>
</div>

<div class="container mx-auto px-6 lg:px-12 pb-20 -mt-12 relative z-10">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Left: Image -->
        <div class="lg:col-span-2 bg-white rounded-2xl overflow-hidden flex items-center justify-center p-4 lg:p-8 border border-gray-200 shadow-sm min-h-[400px]">
            @if($koleksi && $koleksi->path_foto)
                <img src="{{ Storage::url($koleksi->path_foto) }}" alt="{{ $modul->judul }}" class="max-w-full max-h-[600px] object-contain rounded-lg shadow-md">
            @else
                <div class="text-gray-400 flex flex-col items-center">
                    <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                    <p class="font-medium">Foto Koleksi Belum Tersedia</p>
                </div>
            @endif
        </div>

        <!-- Right: Info Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 sticky top-8">
                <h3 class="font-bold text-gray-900 text-lg mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#8b1c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Informasi Utama
                </h3>
                
                <div class="space-y-6">
                    <div class="flex justify-between items-center border-b border-dashed border-gray-200 pb-4">
                        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Jenis Koleksi</span>
                        <span class="text-sm font-bold text-gray-900 text-right">{{ $koleksi->kategori->nama_kategori ?? 'Umum' }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center border-b border-dashed border-gray-200 pb-4">
                        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Nama Pemilik/Penitip</span>
                        <span class="text-sm font-bold text-gray-900 text-right">{{ $koleksi->nama_penyerah ?? '-' }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center border-b border-dashed border-gray-200 pb-4">
                        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Lokasi</span>
                        <span class="text-sm font-bold text-gray-900 text-right">Museum Pusaka Karo</span>
                    </div>
                    
                    <div class="flex justify-between items-center border-b border-dashed border-gray-200 pb-4">
                        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Asal</span>
                        @php
                            $asal = 'Tidak Diketahui';
                            if ($koleksi->tempat_lahir_penyerah) {
                                $asal = $koleksi->tempat_lahir_penyerah;
                            } elseif ($koleksi->alamat_penyerah) {
                                $parts = explode(',', $koleksi->alamat_penyerah);
                                $asal = trim(end($parts));
                            }
                        @endphp
                        <span class="text-sm font-bold text-gray-900 text-right">{{ $asal }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center border-b border-dashed border-gray-200 pb-4">
                        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status Fisik</span>
                        <span class="text-[10px] font-bold text-gray-700 bg-gray-100 px-3 py-1 rounded uppercase tracking-wider">{{ $koleksi->kondisi_awal ?? 'TIDAK DIKETAHUI' }}</span>
                    </div>
                </div>
                
                <div class="mt-8">
                    <a href="{{ route('peta') }}" class="block w-full py-3.5 bg-black text-white text-center text-xs font-bold uppercase tracking-wider rounded-lg hover:bg-gray-800 transition shadow-sm">
                        Lihat Peta Persebaran
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200 mb-8 flex gap-8 px-2 overflow-x-auto" id="tab-buttons">
        <button onclick="switchTab('deskripsi')" id="btn-deskripsi" class="tab-btn pb-4 text-sm font-bold text-gray-900 border-b-2 border-[#8b1c1c] uppercase tracking-wider whitespace-nowrap transition-colors">Deskripsi</button>
        <button onclick="switchTab('sejarah')" id="btn-sejarah" class="tab-btn pb-4 text-sm font-bold text-gray-400 hover:text-gray-700 uppercase tracking-wider whitespace-nowrap border-b-2 border-transparent transition-colors">Sejarah</button>
        <button onclick="switchTab('galeri')" id="btn-galeri" class="tab-btn pb-4 text-sm font-bold text-gray-400 hover:text-gray-700 uppercase tracking-wider whitespace-nowrap border-b-2 border-transparent transition-colors">Galeri Media</button>
        <button onclick="switchTab('komentar')" id="btn-komentar" class="tab-btn pb-4 text-sm font-bold text-gray-400 hover:text-gray-700 uppercase tracking-wider whitespace-nowrap border-b-2 border-transparent transition-colors">Komentar</button>
    </div>

    <!-- Content Area -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 lg:p-12 shadow-sm text-gray-700 leading-relaxed max-w-4xl min-h-[200px]">
        <!-- Deskripsi Content -->
        <div id="content-deskripsi" class="tab-content text-lg leading-loose">
            @if($deskripsi_umum)
                {!! nl2br(e($deskripsi_umum)) !!}
            @else
                <p class="text-gray-400 italic">Belum ada deskripsi yang ditambahkan untuk koleksi ini.</p>
            @endif
        </div>

        <!-- Sejarah Content -->
        <div id="content-sejarah" class="tab-content hidden text-lg leading-loose">
            @if($sejarah_makna)
                {!! nl2br(e($sejarah_makna)) !!}
            @elseif($koleksi && $koleksi->sejarah_asal_usul)
                {!! nl2br(e($koleksi->sejarah_asal_usul)) !!}
            @else
                <p class="text-gray-400 italic">Belum ada data sejarah yang ditambahkan untuk koleksi ini.</p>
            @endif
        </div>

        <!-- Galeri Content -->
        <div id="content-galeri" class="tab-content hidden">
            @if($modul->galeri && $modul->galeri->count() > 0)
                <div class="columns-1 sm:columns-2 md:columns-3 gap-6 space-y-6">
                    @foreach($modul->galeri as $item)
                        <div class="break-inside-avoid relative rounded-xl overflow-hidden shadow-sm group">
                            @if($item->tipe === 'video')
                                <video src="{{ Storage::url($item->path_file) }}" controls class="w-full bg-black"></video>
                                <div class="absolute top-2 left-2 bg-black/60 text-white text-[10px] font-bold px-2 py-1 rounded">VIDEO</div>
                            @else
                                <div class="cursor-pointer overflow-hidden" onclick="openLightbox('{{ Storage::url($item->path_file) }}')">
                                    <img src="{{ Storage::url($item->path_file) }}" alt="Galeri Koleksi" class="w-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="italic">Belum ada foto atau video pada galeri ini.</p>
                </div>
            @endif
        </div>

        <!-- Komentar Content -->
        <div id="content-komentar" class="tab-content hidden space-y-8">
            
            @if(session('success_komentar'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-md text-sm mb-6 font-medium">
                    {{ session('success_komentar') }}
                </div>
            @endif

            @if($komentars->isEmpty())
                <p class="text-gray-500 italic mb-6">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
            @else
                <div class="space-y-6 mb-8">
                    @foreach($komentars as $komentar)
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                            <h4 class="font-bold text-gray-900">{{ $komentar->nama }}</h4>
                            <span class="text-xs text-gray-400">{{ $komentar->created_at->diffForHumans() }}</span>
                            <p class="text-sm md:text-base text-gray-700 mt-3 leading-relaxed">{{ $komentar->isi_komentar }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="bg-[#faf7f2] border border-[#f2ebe3] p-8 rounded-2xl">
                <h3 class="text-xl font-serif font-bold text-gray-900 mb-6">Tinggalkan Jejak / Pertanyaan</h3>
                
                <form action="{{ route('koleksi.komentar', $modul->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Nama Anda *</label>
                            <input type="text" name="nama" required placeholder="Cth: Budi Tarigan" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-[#8b1c1c] focus:border-[#8b1c1c]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Email (Opsional)</label>
                            <input type="email" name="email" placeholder="Tidak akan dipublikasikan" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-[#8b1c1c] focus:border-[#8b1c1c]">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Isi Komentar *</label>
                        <textarea name="isi_komentar" required rows="4" placeholder="Tulis pendapat atau kenangan Anda tentang budaya ini..." class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-[#8b1c1c] focus:border-[#8b1c1c] resize-y"></textarea>
                    </div>
                    
                    <button type="submit" class="px-8 py-3 bg-[#8b1c1c] text-white text-sm font-semibold rounded-lg hover:bg-[#6b1515] transition shadow-md">
                        Kirim Komentar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Koleksi Terkait -->
    @if($relatedModuls->count() > 0)
    <div class="mt-24 border-t border-[#e2d5c5] pt-16">
        <div class="text-center mb-10">
            <span class="text-[#c9a84c] text-xs font-bold uppercase tracking-wider">Eksplorasi Lainnya</span>
            <h2 class="text-3xl font-serif font-bold text-gray-900 mt-2">Koleksi Budaya Terkait</h2>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedModuls as $rel)
            <a href="{{ route('koleksi.detail', $rel->id) }}" class="group bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-xl transition duration-300 flex flex-col">
                <div class="aspect-[4/3] bg-gray-100 relative overflow-hidden">
                    @if($rel->koleksi->path_foto)
                        <img src="{{ Storage::url($rel->koleksi->path_foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-in-out">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div class="absolute top-3 left-3">
                        <span class="px-3 py-1 bg-white/90 backdrop-blur text-[#8b1c1c] text-[10px] font-bold tracking-wider uppercase rounded-full shadow-sm">
                            {{ $rel->koleksi->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="font-serif font-bold text-gray-900 text-base group-hover:text-[#8b1c1c] transition line-clamp-2 leading-snug">
                        {{ $rel->judul }}
                    </h3>
                    <div class="mt-auto pt-4 flex items-center justify-between text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                        <span>No. Inv: {{ $rel->koleksi->nomor_inventaris_final ?? '-' }}</span>
                        <svg class="w-4 h-4 text-[#8b1c1c] opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 z-[100] bg-black/90 hidden flex-col items-center justify-center opacity-0 transition-opacity duration-300" onclick="closeLightbox()">
    <button class="absolute top-6 right-6 text-white hover:text-gray-300 z-10" onclick="closeLightbox()">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    <div class="relative w-full h-full p-4 md:p-12 flex items-center justify-center pointer-events-none">
        <img id="lightbox-img" src="" class="max-w-full max-h-full object-contain shadow-2xl rounded pointer-events-auto transform scale-95 transition-transform duration-300" alt="Zoomed Gallery Image" onclick="event.stopPropagation()">
    </div>
</div>

@endsection

@push('scripts')
<script>
    function switchTab(tabId) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(el => {
            el.classList.add('hidden');
        });
        // Show target content
        document.getElementById('content-' + tabId).classList.remove('hidden');

        // Reset all buttons styles
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('text-gray-900', 'border-[#8b1c1c]');
            btn.classList.add('text-gray-400', 'border-transparent');
        });

        // Set active button style
        const activeBtn = document.getElementById('btn-' + tabId);
        activeBtn.classList.remove('text-gray-400', 'border-transparent');
        activeBtn.classList.add('text-gray-900', 'border-[#8b1c1c]');
    }

    function openLightbox(src) {
        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-img');
        
        img.src = src;
        lightbox.classList.remove('hidden');
        
        // Trigger reflow
        void lightbox.offsetWidth;
        
        lightbox.classList.remove('opacity-0');
        img.classList.remove('scale-95');
        img.classList.add('scale-100');
        document.body.style.overflow = 'hidden';
    }
    
    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-img');
        
        lightbox.classList.add('opacity-0');
        img.classList.remove('scale-100');
        img.classList.add('scale-95');
        
        setTimeout(() => {
            lightbox.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300); // Matches transition duration
    }
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('lightbox').classList.contains('hidden')) {
            closeLightbox();
        }
    });
</script>
@endpush
