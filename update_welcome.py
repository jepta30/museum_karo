import re

with open('resources/views/welcome.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace blade directive
content = content.replace("@if(!session()->has('buku_tamu_filled'))", "@if(!request()->hasCookie('buku_tamu_filled'))")

# Replace JS logic
old_js = """function closeBukuTamu() {
            document.getElementById('modal-buku-tamu').classList.add('hidden');
            localStorage.setItem('buku_tamu_closed', 'true');
        }

        document.addEventListener("DOMContentLoaded", function() {
            if(localStorage.getItem('buku_tamu_closed') === 'true') {
                document.getElementById('modal-buku-tamu').classList.add('hidden');
            }
        });"""

new_js = """function closeBukuTamu() {
            document.getElementById('modal-buku-tamu').classList.add('hidden');
            localStorage.setItem('buku_tamu_closed_timestamp', new Date().getTime());
        }

        document.addEventListener("DOMContentLoaded", function() {
            const closedTimestamp = localStorage.getItem('buku_tamu_closed_timestamp');
            if(closedTimestamp) {
                const now = new Date().getTime();
                const diffHours = (now - parseInt(closedTimestamp)) / (1000 * 60 * 60);
                if(diffHours < 24) {
                    const modal = document.getElementById('modal-buku-tamu');
                    if(modal) modal.classList.add('hidden');
                } else {
                    localStorage.removeItem('buku_tamu_closed_timestamp');
                }
            } else if(localStorage.getItem('buku_tamu_closed') === 'true') {
                // Reset legacy users
                localStorage.removeItem('buku_tamu_closed');
            }
        });"""

if "function closeBukuTamu()" in content:
    # Use re to replace flexibly just in case spacing varies
    pattern = r"function closeBukuTamu\(\)\s*\{[\s\S]*?\}\s*document\.addEventListener\(\"DOMContentLoaded\",\s*function\(\)\s*\{[\s\S]*?\}\);"
    content = re.sub(pattern, new_js, content)

with open('resources/views/welcome.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
