import re

with open('resources/views/layouts/app.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace aside classes
content = re.sub(
    r'<aside class="w-64 border-r border-\[\#eebfbf\] flex flex-col justify-between shrink-0 bg-gradient-to-b from-\[\#fffaf7\] via-\[\#fae6e6\] to-\[\#f3cece\]">',
    r'<aside class="w-64 border-r border-[#6a1515] flex flex-col justify-between shrink-0 bg-gradient-to-b from-[#8b1c1c] via-[#6a1515] to-[#4a0f0f] text-white">',
    content
)

# Replace logo background/border
content = re.sub(
    r'border-b border-\[\#eebfbf\]',
    r'border-b border-[#a82525]',
    content
)

# Replace SIMPUKA text
content = re.sub(
    r'text-\[\#8b1c1c\] tracking-wide">SIMPUKA',
    r'text-white tracking-wide">SIMPUKA',
    content
)

# Replace small text
content = re.sub(
    r'text-\[\#5c1c16\] uppercase tracking-widest mt-0\.5 font-bold leading-tight">Sistem Informasi Museum Pusaka Karo',
    r'text-red-200 uppercase tracking-widest mt-0.5 font-medium leading-tight">Sistem Informasi Museum Pusaka Karo',
    content
)

# Replace inactive link classes
content = re.sub(
    r'text-gray-700 hover:bg-white/60 hover:text-\[\#8b1c1c\]',
    r'text-red-100 hover:bg-white/10 hover:text-white',
    content
)

# Replace active link classes (they currently use bg-[#8b1c1c] text-white shadow-sm, we will change to bg-white/20 text-white shadow-inner)
content = re.sub(
    r'bg-\[\#8b1c1c\] text-white shadow-sm',
    r'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white',
    content
)
content = re.sub(
    r'bg-\[\#8b1c1c\] text-white font-semibold shadow-sm',
    r'bg-white/20 text-white shadow-inner font-bold border-l-4 border-white',
    content
)

# Also fix the bottom ornament background to blend better if it was red, but the bottom ornament is SVG data URI.
# The SVG has %238b1c1c which is #8b1c1c. Since our background is #4a0f0f, we might want to change it.
content = re.sub(
    r"fill=\'%238b1c1c\'",
    r"fill=\'%234a0f0f\'",
    content
)

with open('resources/views/layouts/app.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
