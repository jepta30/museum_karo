import re

for file in ['resources/views/admin/koleksi/create.blade.php', 'resources/views/admin/koleksi/edit.blade.php']:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()

    # We will insert the new fields after the "Kategori" field.
    # Look for:
    #                 </div>
    #             </div>
    #             
    #             <div class="mb-4">
    #                 <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Koleksi Budaya</label>
    
    # Actually let's just find Judul Koleksi Budaya wrapper
    target = """<div class="mb-4">
                  <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Koleksi Budaya</label>"""
                  
    if 'edit.blade.php' in file:
        new_fields = """<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                  <div>
                      <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pemilik/Penitip (Opsional)</label>
                      <input type="text" name="nama_penyerah" value="{{ old('nama_penyerah', $modul->koleksi->nama_penyerah ?? '') }}" placeholder="Contoh: Budi Tarigan" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:border-museum-red focus:ring-1 focus:ring-museum-red outline-none text-sm">
                  </div>
                  <div>
                      <label class="block text-sm font-semibold text-gray-700 mb-1">Asal Koleksi (Opsional)</label>
                      <input type="text" name="asal_koleksi" value="{{ old('asal_koleksi', $modul->koleksi->alamat_penyerah ?? '') }}" placeholder="Contoh: Desa Berastagi" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:border-museum-red focus:ring-1 focus:ring-museum-red outline-none text-sm">
                  </div>
                  <div>
                      <label class="block text-sm font-semibold text-gray-700 mb-1">Kondisi Fisik (Opsional)</label>
                      <input type="text" name="kondisi_fisik" value="{{ old('kondisi_fisik', $modul->koleksi->kondisi_awal ?? '') }}" placeholder="Contoh: Baik / Sedikit Rusak" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:border-museum-red focus:ring-1 focus:ring-museum-red outline-none text-sm">
                  </div>
              </div>
              
              <div class="mb-4">
                  <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Koleksi Budaya</label>"""
    else:
        new_fields = """<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                  <div>
                      <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pemilik/Penitip (Opsional)</label>
                      <input type="text" name="nama_penyerah" value="{{ old('nama_penyerah') }}" placeholder="Contoh: Budi Tarigan" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:border-museum-red focus:ring-1 focus:ring-museum-red outline-none text-sm">
                  </div>
                  <div>
                      <label class="block text-sm font-semibold text-gray-700 mb-1">Asal Koleksi (Opsional)</label>
                      <input type="text" name="asal_koleksi" value="{{ old('asal_koleksi') }}" placeholder="Contoh: Desa Berastagi" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:border-museum-red focus:ring-1 focus:ring-museum-red outline-none text-sm">
                  </div>
                  <div>
                      <label class="block text-sm font-semibold text-gray-700 mb-1">Kondisi Fisik (Opsional)</label>
                      <input type="text" name="kondisi_fisik" value="{{ old('kondisi_fisik') }}" placeholder="Contoh: Baik / Sedikit Rusak" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:border-museum-red focus:ring-1 focus:ring-museum-red outline-none text-sm">
                  </div>
              </div>
              
              <div class="mb-4">
                  <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Koleksi Budaya</label>"""
                  
    content = content.replace(target, new_fields)

    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)
