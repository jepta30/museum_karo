<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistem Informasi Warisan Budaya Karo')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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

    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

    <!-- Navbar -->
    <nav class="bg-white px-6 py-4 flex items-center justify-between shadow-sm relative z-50">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10">
            <div class="hidden sm:block">
                <h1 class="text-[#8b1c1c] font-serif font-bold text-lg leading-tight">Sistem Informasi Warisan<br>Budaya Karo</h1>
                <p class="text-xs text-gray-500 uppercase tracking-widest mt-0.5">Museum Pusaka Karo</p>
            </div>
        </div>
        
        <div class="flex items-center gap-6 text-sm font-semibold text-gray-700">
            <div class="hidden lg:flex items-center gap-6">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'bg-[#8b1c1c] text-white px-5 py-2 rounded-full shadow-md' : 'hover:text-[#8b1c1c] transition' }}">Beranda</a>
                <a href="{{ route('katalog') }}" class="{{ request()->routeIs('katalog') ? 'bg-[#8b1c1c] text-white px-5 py-2 rounded-full shadow-md' : 'hover:text-[#8b1c1c] transition' }}">Katalog Koleksi</a>
                <a href="{{ route('peta') }}" class="{{ request()->routeIs('peta') ? 'bg-[#8b1c1c] text-white px-5 py-2 rounded-full shadow-md' : 'hover:text-[#8b1c1c] transition' }}">Peta Titik Asal</a>
                <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'bg-[#8b1c1c] text-white px-5 py-2 rounded-full shadow-md' : 'hover:text-[#8b1c1c] transition' }}">Tentang Kami</a>
                <a href="{{ route('saran') }}" class="{{ request()->routeIs('saran') ? 'bg-[#8b1c1c] text-white px-5 py-2 rounded-full shadow-md' : 'hover:text-[#8b1c1c] transition' }}">Saran & Pesan</a>
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

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-20">
        <div class="max-w-7xl mx-auto px-6 pt-16 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12">
                        <div>
                            <h3 class="text-[#8b1c1c] font-serif font-bold text-xl">Museum Pusaka Karo</h3>
                            <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">Berastagi, Sumatera Utara</p>
                        </div>
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-md">
                        Mengumpulkan, merawat, dan menyajikan warisan budaya leluhur untuk generasi masa depan.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs tracking-wider uppercase mb-6">Tautan Cepat</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li><a href="{{ route('home') }}" class="hover:text-[#8b1c1c] transition">Beranda</a></li>
                        <li><a href="{{ route('katalog') }}" class="hover:text-[#8b1c1c] transition">Katalog Koleksi</a></li>
                        <li><a href="{{ route('peta') }}" class="hover:text-[#8b1c1c] transition">Peta Persebaran</a></li>
                        <li><a href="{{ route('tentang') }}" class="hover:text-[#8b1c1c] transition">Tentang Kami</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs tracking-wider uppercase mb-6">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 shrink-0 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jl. Perwira No. 3, Gundaling I,<br>Berastagi, Kabupaten Karo,<br>Sumatera Utara</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row items-center justify-center text-xs text-gray-400 font-medium tracking-wide">
                <span>&copy; {{ date('Y') }} Museum Pusaka Karo. All rights reserved.</span>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
