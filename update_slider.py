import re

with open('resources/views/welcome.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace the CSS
old_css = """    <style>
        @keyframes kenburns {
            0% { transform: scale(1) translate(0, 0); }
            50% { transform: scale(1.1) translate(-1%, -1%); }
            100% { transform: scale(1) translate(0, 0); }
        }
        .animate-kenburns {
            animation: kenburns 30s ease-in-out infinite alternate;
        }
    </style>"""

new_css = """    <style>
        @keyframes slide {
            0%, 45% { transform: translateX(0); }
            55%, 100% { transform: translateX(-50%); }
        }
        .animate-slide {
            animation: slide 16s infinite alternate ease-in-out;
        }
    </style>"""

content = content.replace(old_css, new_css)

# Replace the HTML
old_html = """        <div class="absolute inset-0 z-0 overflow-hidden">
            <img src="{{ asset('images/museum-tampak-luar.png') }}" class="w-full h-full object-cover opacity-60 mix-blend-overlay animate-kenburns" alt="Museum Pusaka Karo">
            <!-- Linear Gradient for text readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        </div>"""

new_html = """        <div class="absolute inset-0 z-0 overflow-hidden">
            <div class="w-[200%] h-full flex animate-slide bg-black">
                <img src="{{ asset('images/museum-tampak-luar.png') }}" class="w-1/2 h-full object-cover opacity-60 mix-blend-overlay" alt="Museum Pusaka Karo 1">
                <img src="{{ asset('images/tampakdepan.png') }}" class="w-1/2 h-full object-cover opacity-60 mix-blend-overlay" alt="Museum Pusaka Karo 2">
            </div>
            <!-- Linear Gradient for text readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
        </div>"""

content = content.replace(old_html, new_html)

with open('resources/views/welcome.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
