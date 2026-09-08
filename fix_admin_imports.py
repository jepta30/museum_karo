with open('app/Http/Controllers/AdminController.php', 'r', encoding='utf-8') as f:
    content = f.read()

imports = """
use App\\Models\\User;
use App\\Models\\ModulEdukasi;
use App\\Models\\Koleksi;
use App\\Models\\Kategori;
use App\\Models\\GaleriModul;
"""

if "use App\\Models\\ModulEdukasi;" not in content:
    content = content.replace("use Illuminate\\Http\\Request;", "use Illuminate\\Http\\Request;\n" + imports)

with open('app/Http/Controllers/AdminController.php', 'w', encoding='utf-8') as f:
    f.write(content)
