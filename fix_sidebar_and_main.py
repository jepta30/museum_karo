import re

with open('resources/views/layouts/app.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Fix the remaining dark text in the sidebar (curator and registrar used different classes)
content = re.sub(
    r'text-gray-700 font-medium hover:bg-white/60 hover:text-\[\#8b1c1c\]',
    r'text-white/80 font-medium hover:bg-white/10 hover:text-white',
    content
)

# And if there are text-red-100, let's just make sure they are bright enough. The user said it was too dark/not visible.
# text-red-100 is light pink, but maybe text-white/80 is better.
content = re.sub(
    r'text-red-100 hover:bg-white/10 hover:text-white',
    r'text-white/80 hover:bg-white/10 hover:text-white',
    content
)

# Replace any stray text-gray-700 in the sidebar
# We know the sidebar ends at </aside>, so we can just replace text-gray-700 with text-white/80 in the first half of the document.
# Actually, the above two regexes cover all the links from the Select-String output.

# 2. Fix the "luar" (outside/main content and header) to be pure white as requested: "dan untuk luar buatkan warna putih saja"
# The header currently is:
# <header class="h-16 bg-gradient-to-r from-[#fae6e6] via-[#fdf4f4] to-white border-b border-[#eebfbf] flex items-center justify-between px-8 shrink-0">
content = re.sub(
    r'<header class="h-16 bg-gradient-to-r from-\[\#fae6e6\] via-\[\#fdf4f4\] to-white border-b border-\[\#eebfbf\] flex items-center justify-between px-8 shrink-0">',
    r'<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">',
    content
)

# Restore the search box border if I changed it
content = re.sub(
    r'bg-white border border-\[\#eebfbf\] rounded-full',
    r'bg-gray-50 border border-gray-200 rounded-full',
    content
)

# Restore the header profile divider border
content = re.sub(
    r'border-l border-\[\#eebfbf\]',
    r'border-l border-gray-200',
    content
)

# 3. Main content background:
# <main class="flex-1 overflow-y-auto p-8 bg-gradient-to-br from-[#f3cece] via-[#faf0f0] to-[#eebfbf]">
content = re.sub(
    r'<main class="flex-1 overflow-y-auto p-8 bg-gradient-to-br from-\[\#f3cece\] via-\[\#faf0f0\] to-\[\#eebfbf\]">',
    r'<main class="flex-1 overflow-y-auto p-8 bg-white">',
    content
)

with open('resources/views/layouts/app.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
