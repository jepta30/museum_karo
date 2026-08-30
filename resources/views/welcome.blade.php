<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPUKA - Sistem Informasi Museum Pusaka Karo</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        'museum-red': '#8b1c1c',
                        'museum-dark': '#4a1b1b',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

    <!-- Navbar -->
    <nav class="bg-white px-6 py-4 flex items-center justify-between shadow-sm relative z-50">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Museum Pusaka Karo" class="h-12 w-auto drop-shadow-sm">
            <div class="hidden sm:block">
                <h1 class="text-[#8b1c1c] font-serif font-bold text-xl leading-tight tracking-wide">SIMPUKA</h1>
                <p class="text-[11px] text-gray-500 uppercase tracking-wider mt-0.5 font-medium">Sistem Informasi Museum Pusaka Karo</p>
            </div>
        </div>
        
        <div class="flex items-center gap-6 text-sm font-semibold text-gray-700">
            <div class="hidden lg:flex items-center gap-6">
                <a href="{{ route('home') }}" class="bg-[#8b1c1c] text-white px-5 py-2 rounded-full shadow-md">Beranda</a>
                <a href="{{ route('katalog') }}" class="hover:text-[#8b1c1c] transition">Katalog Koleksi</a>
                <a href="{{ route('peta') }}" class="hover:text-[#8b1c1c] transition">Peta Titik Asal</a>
                <a href="{{ route('tentang') }}" class="hover:text-[#8b1c1c] transition">Tentang Kami</a>
                <a href="{{ route('saran') }}" class="hover:text-[#8b1c1c] transition">Saran & Pesan</a>
            </div>
            
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 hover:text-[#8b1c1c] text-[#8b1c1c] transition ml-2 lg:ml-4 font-bold border border-[#8b1c1c] px-4 py-2 rounded">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-2 hover:text-white hover:bg-[#8b1c1c] text-gray-700 transition ml-2 lg:ml-4 border border-gray-300 px-4 py-2 rounded">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Login Admin
                    </a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative w-full h-[600px] lg:h-[700px] bg-gray-900 overflow-hidden flex items-center">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/tampakdepan.png') }}" class="w-full h-full object-cover opacity-60 mix-blend-overlay" alt="Museum Pusaka Karo">
            <!-- Linear Gradient for text readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        </div>

        <div class="container mx-auto px-6 lg:px-12 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Text Content -->
            <div class="max-w-2xl text-white">
                <div class="flex items-center gap-2 text-yellow-500 text-xs font-bold tracking-widest uppercase mb-4">
                    <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                    Museum Pusaka Karo &bull; Berastagi
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif font-bold leading-tight mb-6 text-white drop-shadow-md">
                    Menjaga jejak leluhur Karo, agar tak lekang oleh zaman.
                </h1>
                
                <p class="text-lg text-gray-200 mb-8 leading-relaxed max-w-xl text-shadow">
                    Mengenal, melestarikan, dan mendokumentasikan warisan budaya Karo untuk generasi mendatang secara digital.
                </p>
                
                <!-- Search Box -->
                <form action="#" method="GET" class="flex max-w-md bg-white rounded-sm overflow-hidden shadow-lg">
                    <input type="text" name="q" placeholder="Cari koleksi atau budaya..." class="w-full px-4 py-3 text-gray-800 focus:outline-none">
                    <button type="submit" class="bg-black text-white font-bold px-6 py-3 hover:bg-gray-800 transition">CARI</button>
                </form>
            </div>

            <!-- Right Image Popup -->
            <div class="hidden lg:block relative h-[450px] transform translate-x-12 shadow-2xl">
                <img src="{{ asset('images/museum-karo.jpg') }}" alt="Interior Museum" class="w-full h-full object-cover rounded-2xl border-4 border-white shadow-2xl rotate-1">
            </div>
            
        </div>
    </div>

    <!-- Stats Section -->
    @php
        $warisanCount = \App\Models\ModulEdukasi::where('status', 'diterbitkan')->count();
        $jenisCount = \App\Models\Kategori::whereHas('koleksi.modul', function($q) {
            $q->where('modul_edukasis.status', 'diterbitkan');
        })->count();
        $titikCount = \App\Models\Koleksi::whereHas('modul', function($q) {
                            $q->where('modul_edukasis.status', 'diterbitkan');
                        })
                        ->whereNotNull('alamat_penyerah')
                        ->distinct('alamat_penyerah')
                        ->count('alamat_penyerah');
    @endphp

    <div class="relative z-20 -mt-16 container mx-auto px-6 lg:px-12 mb-20">
        <div class="bg-white rounded-xl shadow-xl border border-gray-100 p-8 md:p-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-gray-200">
                <div class="py-4 md:py-0">
                    <h2 class="text-4xl md:text-5xl font-serif font-bold text-[#8b1c1c] mb-2">{{ $warisanCount }}</h2>
                    <p class="text-sm text-gray-500 font-semibold tracking-wide">Warisan Terdokumentasi</p>
                </div>
                <div class="py-4 md:py-0">
                    <h2 class="text-4xl md:text-5xl font-serif font-bold text-[#8b1c1c] mb-2">{{ $jenisCount }}</h2>
                    <p class="text-sm text-gray-500 font-semibold tracking-wide">Jenis Koleksi</p>
                </div>
                <div class="py-4 md:py-0">
                    <h2 class="text-4xl md:text-5xl font-serif font-bold text-[#8b1c1c] mb-2">{{ $titikCount }}</h2>
                    <p class="text-sm text-gray-500 font-semibold tracking-wide">Titik Asal</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Koleksi Unggulan Section -->
    @php
        $unggulan = \App\Models\ModulEdukasi::where('status', 'diterbitkan')
                        ->with('koleksi.kategori')
                        ->latest()
                        ->take(6)
                        ->get();
    @endphp

    @if($unggulan->count() > 0)
    <div class="bg-[#fdfbf9] py-16 border-t border-[#f2ebe3]">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-10 gap-4">
                <h2 class="text-2xl font-serif font-bold text-[#1b1b18] tracking-wide uppercase">KOLEKSI UNGGULAN</h2>
                <a href="#" class="text-sm text-gray-500 hover:text-[#8b1c1c] transition font-medium">Lihat Semua Koleksi &gt;</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($unggulan as $modul)
                @php
                    $koleksi = $modul->koleksi;
                    $kontenData = json_decode($modul->konten, true);
                    $deskripsi_umum = is_array($kontenData) ? ($kontenData['deskripsi_umum'] ?? '') : $modul->konten;
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:border-[#8b1c1c] hover:shadow-lg transition duration-300 group flex flex-col">
                    <div class="h-64 bg-gray-50 overflow-hidden relative">
                        @if($koleksi && $koleksi->path_foto)
                            <img src="{{ Storage::url($koleksi->path_foto) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-in-out">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-6 flex-grow flex flex-col">
                        <p class="text-[11px] font-bold text-[#8b1c1c] uppercase tracking-wider mb-2">
                            {{ $koleksi && $koleksi->kategori ? $koleksi->kategori->nama_kategori : 'KATEGORI UMUM' }}
                        </p>
                        <a href="{{ route('koleksi.detail', $modul->id) }}" class="inline-block mb-3">
                            <h3 class="text-[22px] font-serif font-bold text-[#1a237e] underline decoration-1 underline-offset-4 group-hover:text-[#8b1c1c] transition leading-snug">
                                {{ $modul->judul }}
                            </h3>
                        </a>
                        <p class="text-[14px] text-gray-600 leading-relaxed line-clamp-3">
                            {{ Str::limit(strip_tags($deskripsi_umum), 120) }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Map Section -->
    <div class="bg-[#fdfbf9] py-20 border-t border-[#f2ebe3]">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Text -->
                <div>
                    <h2 class="text-3xl font-serif font-bold text-gray-900 mb-4 tracking-wide">PETA MUSEUM</h2>
                    <p class="text-gray-600 mb-8 leading-relaxed max-w-md">
                        Temukan lokasi museum kami dan jelajahi tata letak galeri secara virtual sebelum Anda berkunjung.
                    </p>
                    <a href="https://maps.app.goo.gl/9zG2XyQvKx3q4QJYA" target="_blank" class="inline-block border-2 border-gray-900 text-gray-900 font-bold text-sm tracking-widest px-8 py-3 hover:bg-gray-900 hover:text-white transition">
                        BUKA PETA INTERAKTIF
                    </a>
                </div>
                
                <!-- Map Container -->
                <div class="bg-white p-2 rounded-xl shadow-lg border border-gray-200">
                    <div id="map" class="w-full h-[350px] rounded-lg relative z-10"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 pt-16 pb-8">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Branding -->
                <div class="md:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8">
                        <h3 class="font-serif font-bold text-gray-900 text-sm tracking-wider uppercase">Museum Pusaka Karo</h3>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed mb-6 pr-4">
                        Sistem informasi yang menyajikan data dan informasi warisan budaya Karo secara digital untuk melestarikan jejak leluhur agar tak lekang oleh zaman.
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-8 h-8 rounded bg-gray-800 text-white flex items-center justify-center hover:bg-[#8b1c1c] transition">
                            <!-- Instagram -->
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded bg-gray-800 text-white flex items-center justify-center hover:bg-[#8b1c1c] transition">
                            <!-- Facebook -->
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded bg-gray-800 text-white flex items-center justify-center hover:bg-[#8b1c1c] transition">
                            <!-- YouTube -->
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.015 3.015 0 0 0-2.122 2.136C0 8.139 0 12 0 12s0 3.861.501 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.55 9.377.55 9.377.55s7.505 0 9.377-.55a3.015 3.015 0 0 0 2.122-2.136C24 15.861 24 12 24 12s0-3.861-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Links 1 -->
                <div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs tracking-wider uppercase mb-6">Menu Utama</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-[#8b1c1c] transition">Beranda</a></li>
                        <li><a href="#" class="hover:text-[#8b1c1c] transition">Katalog Koleksi</a></li>
                        <li><a href="#" class="hover:text-[#8b1c1c] transition">Peta Titik Asal</a></li>
                        <li><a href="#" class="hover:text-[#8b1c1c] transition">Tentang Kami</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs tracking-wider uppercase mb-6">Kontak Kami</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 shrink-0 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jl. Perwira No. 3, Gundaling I,<br>Berastagi, Kabupaten Karo,<br>Sumatera Utara</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>(0628) 9123456</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>info@museumpusaka.karo.go.id</span>
                        </li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs tracking-wider uppercase mb-6">Informasi Legal</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-[#8b1c1c] transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-[#8b1c1c] transition">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-[#8b1c1c] transition">Login Administrator</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row items-center justify-center text-xs text-gray-400 font-medium tracking-wide">
                <span>&copy; {{ date('Y') }} SIMPUKA. Sistem Informasi Museum Pusaka Karo.</span>
            </div>
        </div>
    </footer>

    <!-- Modal Buku Tamu -->
    @if(!session()->has('buku_tamu_filled'))
    <div id="modal-buku-tamu" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden relative">
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-serif font-bold text-xl text-gray-900">Buku Tamu Pengunjung</h3>
                <button type="button" onclick="closeBukuTamu()" class="text-gray-400 hover:text-gray-700 transition focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('buku_tamu.store') }}" method="POST" class="p-8">
                @csrf
                <p class="text-sm text-gray-600 mb-6">Selamat datang di Museum Pusaka Karo. Mohon isi data kunjungan Anda terlebih dahulu.</p>

                <div class="space-y-5">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" name="nama" required class="w-full px-4 py-2.5 border border-gray-300 rounded-md text-sm focus:border-[#8b1c1c] focus:ring-[#8b1c1c] outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Alamat</label>
                        <input type="text" name="alamat" class="w-full px-4 py-2.5 border border-gray-300 rounded-md text-sm focus:border-[#8b1c1c] focus:ring-[#8b1c1c] outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="w-full px-4 py-2.5 border border-gray-300 rounded-md text-sm focus:border-[#8b1c1c] focus:ring-[#8b1c1c] outline-none transition">
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-[#752626] text-white text-sm font-semibold rounded hover:bg-red-900 transition shadow-sm w-full sm:w-auto">Kirim Data</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function closeBukuTamu() {
            document.getElementById('modal-buku-tamu').classList.add('hidden');
            localStorage.setItem('buku_tamu_closed', 'true');
        }

        document.addEventListener("DOMContentLoaded", function() {
            if(localStorage.getItem('buku_tamu_closed') === 'true') {
                document.getElementById('modal-buku-tamu').classList.add('hidden');
            }
        });
    </script>
    @endif

    <!-- Modal Success Buku Tamu -->
    @if(session()->has('success_buku_tamu'))
    <div id="modal-success-tamu" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-[110] flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm overflow-hidden relative text-center p-8">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            
            <h3 class="font-serif font-bold text-2xl text-gray-900 mb-2">Bujur Melala!</h3>
            <p class="text-gray-600 text-sm leading-relaxed mb-8">
                Terima kasih telah mencatatkan kunjungan Anda. Selamat menelusuri keindahan warisan peninggalan leluhur di <strong>Museum Pusaka Karo</strong>. Mari bersama-sama menjaga jejak leluhur agar tak lekang oleh zaman.
            </p>

            <button onclick="document.getElementById('modal-success-tamu').classList.add('hidden')" class="w-full px-6 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded hover:bg-black transition shadow-sm">
                Mulai Menjelajah
            </button>
        </div>
    </div>
    @endif

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Koordinat Museum Pusaka Karo, Berastagi
            var lat = 3.1905;
            var lng = 98.5049;
            
            var map = L.map('map').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var marker = L.marker([lat, lng]).addTo(map);
            
            // Popup yang mirip dengan desain
            marker.bindPopup(`
                <div class="text-center p-1">
                    <strong class="font-sans text-gray-800 text-sm">Museum Pusaka Karo</strong><br>
                    <span class="text-xs text-gray-600">Jl. Perwira No. 3, Berastagi</span>
                </div>
            `).openPopup();
        });
    </script>
</body>
</html>
