with open('resources/views/admin/koleksi/create.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace("Tambah Baru", "Edit Koleksi")
content = content.replace("Tambah Koleksi Budaya", "Edit Koleksi Budaya")
content = content.replace("Tambahkan koleksi budaya baru", "Perbarui data koleksi budaya")
content = content.replace("route('admin.koleksi.store')", "route('admin.koleksi.update', $modul->id)")
content = content.replace("@csrf", "@csrf\n            @method('PUT')")
content = content.replace("old('nomor_koleksi')", "old('nomor_koleksi', $modul->koleksi->nomor_inventaris_final ?? '')")
content = content.replace("old('kategori_id')", "old('kategori_id', $modul->koleksi->kategori_id ?? '')")
content = content.replace("old('judul')", "old('judul', $modul->judul)")
content = content.replace("{{ old('deskripsi_umum') }}", "{{ old('deskripsi_umum', json_decode($modul->konten)->deskripsi_umum ?? '') }}")
content = content.replace("{{ old('sejarah_makna') }}", "{{ old('sejarah_makna', json_decode($modul->konten)->sejarah_makna ?? '') }}")
content = content.replace("old('latitude')", "old('latitude', $modul->latitude)")
content = content.replace("old('longitude')", "old('longitude', $modul->longitude)")

# Update Map defaults
content = content.replace("const defaultLat = 3.1000;", "const defaultLat = {{ $modul->latitude ?? 3.1000 }};")
content = content.replace("const defaultLng = 98.4833;", "const defaultLng = {{ $modul->longitude ?? 98.4833 }};")

with open('resources/views/admin/koleksi/edit.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
