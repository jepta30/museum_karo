import re

with open('resources/views/layouts/app.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

target = """<a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 mt-4 text-sm font-semibold rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dasbor
                    </a>"""

new_menu = """<a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 mt-4 text-sm font-semibold rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dasbor
                    </a>
                    <a href="{{ route('admin.koleksi') }}" class="flex items-center gap-3 px-4 py-2.5 mt-1 text-sm font-medium rounded-md {{ request()->routeIs('admin.koleksi') || request()->routeIs('admin.koleksi.create') ? 'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Koleksi Budaya
                    </a>"""

content = content.replace(target, new_menu)

with open('resources/views/layouts/app.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
