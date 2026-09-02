import re

with open('resources/views/welcome.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace duplicate style
pattern = """    <style>
        @keyframes kenburns {
            0% { transform: scale(1) translate(0, 0); }
            50% { transform: scale(1.1) translate(-1%, -1%); }
            100% { transform: scale(1) translate(0, 0); }
        }
        .animate-kenburns {
            animation: kenburns 30s ease-in-out infinite alternate;
        }
    </style>
"""

content = content.replace(pattern + "\n" + pattern, pattern)

with open('resources/views/welcome.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
