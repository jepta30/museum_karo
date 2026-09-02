import re

with open('resources/views/welcome.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

pattern = r'<div class="absolute inset-0 z-0">\s*<img src="\{\{ asset\(\'images/museum-tampak-luar\.png\'\) \}\}" class="w-full h-full object-cover opacity-60 mix-blend-overlay animate-kenburns" alt="Museum Pusaka Karo">\s*<!-- Linear Gradient for text readability -->\s*<div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>\s*</div>'

new_html = """<div class="absolute inset-0 z-0 overflow-hidden">
            <div class="w-[200%] h-full flex animate-slide bg-black">
                <img src="{{ asset('images/museum-tampak-luar.png') }}" class="w-1/2 h-full object-cover opacity-60 mix-blend-overlay" alt="Museum Pusaka Karo 1">
                <img src="{{ asset('images/tampakdepan.png') }}" class="w-1/2 h-full object-cover opacity-60 mix-blend-overlay" alt="Museum Pusaka Karo 2">
            </div>
            <!-- Linear Gradient for text readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        </div>"""

content = re.sub(pattern, new_html, content)

with open('resources/views/welcome.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
