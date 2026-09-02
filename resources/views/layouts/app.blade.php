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
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        'museum-red': '#8b1c1c',
                        'museum-dark': '#4a1b1b',
                        'museum-bg': '#faf7f2',
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="bg-museum-bg text-gray-800 font-sans h-screen flex overflow-hidden">

    <!-- SIDEBAR KIRI -->
    <aside class="w-64 border-r border-[#6a1515] flex flex-col justify-between shrink-0 bg-gradient-to-b from-[#8b1c1c] via-[#6a1515] to-[#4a0f0f] text-white">
        <div>
            <!-- Logo & Title -->
            <div class="p-6 flex items-center gap-3 border-b border-[#a82525] mb-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto">
                <div>
                    <h1 class="font-serif font-bold text-xl leading-tight text-white tracking-wide">SIMPUKA</h1>
                    <p class="text-[9px] text-red-200 uppercase tracking-widest mt-0.5 font-medium leading-tight">Sistem Informasi Museum Pusaka Karo</p>
                </div>
            </div>
            
            <!-- Menu Utama -->
            <nav class="px-4 mt-2">
                @if(Auth::user()->peran === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 mt-4 text-sm font-semibold rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dasbor
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-2.5 mt-1 text-sm font-medium rounded-md {{ request()->routeIs('admin.users') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Manajemen Akun
                    </a>
                    <a href="{{ route('admin.logs') }}" class="flex items-center gap-3 px-4 py-2.5 mt-1 text-sm font-medium rounded-md {{ request()->routeIs('admin.logs') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Log Aktivitas
                    </a>
                    <a href="{{ route('admin.roles') }}" class="flex items-center gap-3 px-4 py-2.5 mt-1 text-sm font-medium rounded-md {{ request()->routeIs('admin.roles') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Peran & Izin
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 mt-1 text-sm font-medium rounded-md {{ request()->routeIs('profile.edit') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan Sistem
                    </a>
                @elseif(Auth::check() && Auth::user()->peran === 'pimpinan')
                    <a href="{{ route('leader.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('leader.dashboard') || request()->routeIs('leader.review') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} font-semibold rounded-md text-sm mb-1">
                        <!-- Ikon Dasbor -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dasbor Utama
                    </a>
                    <a href="{{ route('leader.education') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('leader.education') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} font-semibold rounded-md text-sm mb-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Otorisasi Edukasi
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 mt-1 text-sm font-medium rounded-md {{ request()->routeIs('profile.edit') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Settings
                    </a>
                @elseif(Auth::check() && Auth::user()->peran === 'kurator')
                    <a href="{{ route('curator.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('curator.dashboard') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 font-medium hover:bg-white/10 hover:text-white' }} rounded-md text-sm mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dasbor Utama
                    </a>
                    <a href="{{ route('curator.kurasi') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('curator.kurasi') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 font-medium hover:bg-white/10 hover:text-white' }} rounded-md text-sm mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tinjau & Verifikasi
                    </a>
                    <a href="{{ route('curator.repository') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('curator.repository') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 font-medium hover:bg-white/10 hover:text-white' }} rounded-md text-sm mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                        Repositori Dokumen
                    </a>
                    <a href="{{ route('curator.komentar') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('curator.komentar') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 font-medium hover:bg-white/10 hover:text-white' }} rounded-md text-sm mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                        Komentar Pengunjung
                    </a>
                    <a href="{{ route('curator.katalog') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('curator.katalog') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 font-medium hover:bg-white/10 hover:text-white' }} rounded-md text-sm mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Katalog Publikasi
                    </a>
                    <a href="{{ route('curator.saran') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('curator.saran') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 font-medium hover:bg-white/10 hover:text-white' }} rounded-md text-sm mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Saran & Pesan
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('profile.edit') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 font-medium hover:bg-white/10 hover:text-white' }} rounded-md text-sm mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan
                    </a>
                @elseif(Auth::check() && Auth::user()->peran === 'edukator')
                    <a href="{{ route('educator.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('educator.dashboard') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-md transition group">
                        <svg class="w-5 h-5 {{ request()->routeIs('educator.dashboard') ? 'text-white' : 'text-red-200 group-hover:text-white transition' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Manajemen Koleksi
                    </a>
                    <a href="{{ route('educator.koleksi') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('educator.koleksi') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-md transition font-medium group">
                        <svg class="w-5 h-5 {{ request()->routeIs('educator.koleksi') ? 'text-white' : 'text-red-200 group-hover:text-white transition' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Koleksi
                    </a>
                    <a href="{{ route('educator.alat_edukasi') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('educator.alat_edukasi') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-md transition font-medium group">
                        <svg class="w-5 h-5 {{ request()->routeIs('educator.alat_edukasi') ? 'text-white' : 'text-red-200 group-hover:text-white transition' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Alat Edukasi
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('profile.edit') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-md transition font-medium group">
                        <svg class="w-5 h-5 {{ request()->routeIs('profile.edit') ? 'text-white' : 'text-red-200 group-hover:text-white transition' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan
                    </a>
                @else
                    <a href="{{ route('registrar.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('registrar.dashboard') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 font-medium hover:bg-white/10 hover:text-white' }} rounded-md text-sm">
                        <!-- Ikon Home -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dasbor Utama
                    </a>
                    <a href="{{ route('registrar.create') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('registrar.create') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 font-medium hover:bg-white/10 hover:text-white' }} mt-1 rounded-md text-sm">
                        <!-- Ikon Edit -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Pendaftaran Baru
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('profile.edit') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 font-medium hover:bg-white/10 hover:text-white' }} rounded-md text-sm mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan
                    </a>
                @endif
            </nav>
        </div>

        <!-- Corak Karo Bottom Ornament -->
        <div class="mt-auto pb-4 w-full opacity-90">
            <div class="h-[30px] w-full" style="background-image: url('data:image/svg+xml,%3Csvg width=\'40\' height=\'30\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'40\' height=\'30\' fill=\'%238b1c1c\' /%3E%3Crect width=\'40\' height=\'3\' y=\'3\' fill=\'%231a1a1a\' /%3E%3Crect width=\'40\' height=\'3\' y=\'24\' fill=\'%231a1a1a\' /%3E%3Crect width=\'40\' height=\'1\' y=\'8\' fill=\'%23d4af37\' /%3E%3Crect width=\'40\' height=\'1\' y=\'21\' fill=\'%23d4af37\' /%3E%3Cpolygon points=\'20,10 25,15 20,20 15,15\' fill=\'%23d4af37\' /%3E%3Cpolygon points=\'0,10 5,15 0,20 -5,15\' fill=\'%23d4af37\' /%3E%3Cpolygon points=\'40,10 45,15 40,20 35,15\' fill=\'%23d4af37\' /%3E%3C/svg%3E'); background-repeat: repeat-x; background-size: 40px 30px;"></div>
        </div>
        <!-- End of Sidebar Content -->
    </aside>

    <!-- AREA KANAN (Main Content) -->
    <div class="flex-1 flex flex-col h-screen min-w-0">
        <!-- TOPBAR -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
            @if(Auth::check() && Auth::user()->peran === 'admin')
                <h2 class="text-2xl font-serif text-[#8b1c1c] font-bold">Management System</h2>
            @else
                <h2 class="text-xl font-serif text-[#8b1c1c] font-bold">Museum Budaya Karo</h2>
            @endif
            <div class="flex items-center gap-6">
                <!-- Search Box -->
                <div class="relative">
                    <svg class="w-4 h-4 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Cari Koleksi..." class="pl-9 pr-4 py-1.5 text-sm bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:border-museum-red focus:ring-1 focus:ring-museum-red w-64 transition">
                </div>
                <!-- Ikon Profil dll -->
                <div class="flex items-center gap-4 text-gray-500">
                    <button class="hover:text-[#8b1c1c] transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg></button>
                    <button class="hover:text-[#8b1c1c] transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></button>
                    <button class="hover:text-[#8b1c1c] transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></button>
                    <!-- User Avatar & Logout -->
                    <div class="flex items-center gap-3 ml-2 pl-4 border-l border-gray-200">
                        <div class="text-right hidden md:block">
                            <p class="text-xs font-bold text-[#4a1b1b]">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-[10px] text-red-800 capitalize">{{ Auth::user()->peran ?? 'Peran' }}</p>
                        </div>
                        <div class="w-8 h-8 rounded-full overflow-hidden border border-[#8b1c1c]/30">
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
        <main class="flex-1 overflow-y-auto p-8 bg-white">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>


