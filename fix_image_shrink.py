import re

with open('resources/views/welcome.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Fix the image squishing issue by adding shrink-0
content = content.replace('class="w-1/2 h-full object-cover opacity-60"', 'class="w-1/2 h-full object-cover opacity-60 shrink-0"')

with open('resources/views/welcome.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
