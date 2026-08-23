<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Museum Karo - Dasbor Registrar</title>
    <!-- Import Font Serif dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Fallback CDN Tailwind jika Vite gagal di-build -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'museum-red': '#8b1c1c', 
                        'museum-bg': '#fcfcfc',
                    },
                    fontFamily: {
                        'serif': ['"Playfair Display"', 'Georgia', 'serif'], 
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-museum-bg text-gray-800 font-sans h-screen flex overflow-hidden">

    <!-- SIDEBAR KIRI -->
    <aside class="w-64 border-r border-gray-200 flex flex-col justify-between shrink-0 {{ (Auth::check() && in_array(Auth::user()->peran, ['kurator', 'pimpinan'])) ? 'bg-[#faf5f0]' : 'bg-white' }}">
        <div>
            <!-- Logo & Title -->
            <div class="p-6 flex items-center gap-3">
                <div class="w-10 h-10 bg-black text-white rounded-md flex items-center justify-center font-bold text-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                </div>
                <div>
                    <h1 class="font-serif font-bold text-lg leading-tight text-black">Museum<br>Karo</h1>
                    <p class="text-[10px] text-gray-500 font-medium tracking-wide">Sistem Buku Besar Digital</p>
                </div>
            </div>
            
            <!-- Menu Utama -->
            <nav class="px-4 mt-2">
                @if(Auth::check() && Auth::user()->peran === 'pimpinan')
                    <a href="{{ route('leader.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('leader.dashboard') || request()->routeIs('leader.review') ? 'bg-[#4a1515] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }} font-semibold rounded-md text-sm mb-1">
                        <!-- Ikon Dasbor -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dasbor Utama
                    </a>
                    <a href="{{ route('leader.education') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('leader.education') ? 'bg-[#4a1515] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }} font-semibold rounded-md text-sm mb-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Otorisasi Edukasi
                    </a>
                    <a href="{{ route('leader.repository') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('leader.repository') ? 'bg-[#4a1515] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }} font-semibold rounded-md text-sm mb-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Repositori Institusi
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-gray-600 font-medium rounded-md text-sm hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Settings
                    </a>
                @elseif(Auth::check() && Auth::user()->peran === 'kurator')
                    <a href="{{ route('curator.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 bg-[#f5ebe6] text-museum-red font-semibold rounded-md text-sm border-l-4 border-museum-red">
                        <!-- Ikon Kurator -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Ruang Kerja Kurator
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-gray-600 font-medium rounded-md text-sm hover:bg-gray-50 mt-1">
                        <!-- Ikon Katalog -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Katalog Pengunjung
                    </a>
                @else
                    <a href="{{ route('registrar.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 bg-gray-50 text-black font-semibold rounded-md text-sm border-l-4 border-black">
                        <!-- Ikon Edit -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Dasbor Registrar
                    </a>
                @endif
            </nav>
        </div>

        <!-- End of Sidebar Content -->
    </aside>

    <!-- AREA KANAN (Main Content) -->
    <div class="flex-1 flex flex-col h-screen min-w-0">
        <!-- TOPBAR -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
            <h2 class="text-xl font-serif text-gray-900 font-medium">Museum Budaya Karo</h2>
            <div class="flex items-center gap-6">
                <!-- Search Box -->
                <div class="relative">
                    <svg class="w-4 h-4 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Cari arsip..." class="pl-9 pr-4 py-1.5 text-sm bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:border-museum-red focus:ring-1 focus:ring-museum-red w-64 transition">
                </div>
                <!-- Ikon Profil dll -->
                <div class="flex items-center gap-4 text-gray-500">
                    <button class="hover:text-gray-900 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg></button>
                    <button class="hover:text-gray-900 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></button>
                    <button class="hover:text-gray-900 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></button>
                    <!-- User Avatar & Logout -->
                    <div class="flex items-center gap-3 ml-2 pl-4 border-l border-gray-200">
                        <div class="text-right hidden md:block">
                            <p class="text-xs font-bold text-gray-800">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-[10px] text-gray-500 capitalize">{{ Auth::user()->peran ?? 'Peran' }}</p>
                        </div>
                        <div class="w-8 h-8 rounded-full overflow-hidden border border-gray-200">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'A') }}&background=8b1c1c&color=fff" alt="Profil">
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="ml-2">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Keluar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- KONTEN DINAMIS -->
        <main class="flex-1 overflow-y-auto p-8 bg-museum-bg">
            @yield('content')
        </main>
    </div>

</body>
</html>
