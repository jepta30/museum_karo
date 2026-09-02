import re

with open('resources/views/welcome.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Remove bg-black from flex container, and mix-blend-overlay from images. Keep opacity to darken them for text readability.
old_html = """<div class="absolute inset-0 z-0 overflow-hidden">
            <div class="w-[200%] h-full flex animate-slide bg-black">
                <img src="{{ asset('images/museum-tampak-luar.png') }}" class="w-1/2 h-full object-cover opacity-60 mix-blend-overlay" alt="Museum Pusaka Karo 1">
                <img src="{{ asset('images/tampakdepan.png') }}" class="w-1/2 h-full object-cover opacity-60 mix-blend-overlay" alt="Museum Pusaka Karo 2">
            </div>
            <!-- Linear Gradient for text readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        </div>"""

new_html = """<div class="absolute inset-0 z-0 overflow-hidden">
            <div class="w-[200%] h-full flex animate-slide">
                <img src="{{ asset('images/museum-tampak-luar.png') }}" class="w-1/2 h-full object-cover opacity-60" alt="Museum Pusaka Karo 1">
                <img src="{{ asset('images/tampakdepan.png') }}" class="w-1/2 h-full object-cover opacity-60" alt="Museum Pusaka Karo 2">
            </div>
            <!-- Linear Gradient for text readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        </div>"""

content = content.replace(old_html, new_html)

with open('resources/views/welcome.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
