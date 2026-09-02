import re

with open('resources/views/layouts/app.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# The section starts with @elseif(Auth::check() && Auth::user()->peran === 'kurator')
# and ends right before @elseif(Auth::check() && Auth::user()->peran === 'edukator')
start_str = "@elseif(Auth::check() && Auth::user()->peran === 'kurator')"
end_str = "@elseif(Auth::check() && Auth::user()->peran === 'edukator')"

start_idx = content.find(start_str)
end_idx = content.find(end_str)

if start_idx != -1 and end_idx != -1:
    old_section = content[start_idx:end_idx]
    
    new_section = """@elseif(Auth::check() && Auth::user()->peran === 'kurator')
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
                """
    
    content = content.replace(old_section, new_section)
    
    with open('resources/views/layouts/app.blade.php', 'w', encoding='utf-8') as f:
        f.write(content)
        print("Success")
else:
    print("Not found")
