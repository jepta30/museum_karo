import re

with open('resources/views/welcome.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Add the kenburns style to the head
style_css = """
    <style>
        @keyframes kenburns {
            0% { transform: scale(1) translate(0, 0); }
            50% { transform: scale(1.1) translate(-1%, -1%); }
            100% { transform: scale(1) translate(0, 0); }
        }
        .animate-kenburns {
            animation: kenburns 30s ease-in-out infinite alternate;
        }
    </style>
</head>"""

content = content.replace('</head>', style_css)

# Update the hero image to museum-tampak-luar.png and add animation class
content = content.replace("asset('images/tampakdepan.png')", "asset('images/museum-tampak-luar.png')")
content = content.replace('class="w-full h-full object-cover opacity-60 mix-blend-overlay"', 'class="w-full h-full object-cover opacity-60 mix-blend-overlay animate-kenburns"')

with open('resources/views/welcome.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
