import re

with open('routes/web.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace session()->put with Cookie queue
target = "session()->put('buku_tamu_filled', true);"
new_code = "cookie()->queue('buku_tamu_filled', true, 24 * 60); // 24 hours"
content = content.replace(target, new_code)

with open('routes/web.php', 'w', encoding='utf-8') as f:
    f.write(content)
