import re

with open('resources/views/layouts/app.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace svg classes for educator/curator which use transition group
# "text-white" for active, "text-gray-400 group-hover:text-[#8b1c1c] transition"
content = re.sub(
    r'text-gray-400 group-hover:text-\[\#8b1c1c\] transition',
    r'text-red-200 group-hover:text-white transition',
    content
)

# And replace their parent link classes:
content = re.sub(
    r'bg-\[\#8b1c1c\] text-white font-semibold shadow-sm',
    r'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white',
    content
)

with open('resources/views/layouts/app.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
