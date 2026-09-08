import re

for file in ['resources/views/admin/koleksi/create.blade.php', 'resources/views/admin/koleksi/edit.blade.php']:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()

    target = "<!-- Judul Koleksi -->"
                  
    if 'edit.blade.php' in file:
        new_fields = """<!-- Informasi Tambahan untuk Pengunjung -->
              <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                  <div>
                      <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Pemilik/Penitip (Opsional)</label>
                      <input type="text" name="nama_penyerah" value="{{ old('nama_penyerah', $modul->koleksi->nama_penyerah ?? '') }}" placeholder="Contoh: Keluarga Bpk. Tarigan" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm transition bg-white">
                  </div>
                  <div>
                      <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Asal Koleksi (Opsional)</label>
                      <input type="text" name="asal_koleksi" value="{{ old('asal_koleksi', $modul->koleksi->alamat_penyerah ?? '') }}" placeholder="Contoh: Desa Barusjahe / Tidak Diketahui" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm transition bg-white">
                  </div>
                  <div>
                      <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kondisi Fisik (Opsional)</label>
                      <input type="text" name="kondisi_fisik" value="{{ old('kondisi_fisik', $modul->koleksi->kondisi_awal ?? '') }}" placeholder="Contoh: Baik / Sedikit Rusak" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm transition bg-white">
                  </div>
              </div>
              
              <!-- Judul Koleksi -->"""
    else:
        new_fields = """<!-- Informasi Tambahan untuk Pengunjung -->
              <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                  <div>
                      <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Pemilik/Penitip (Opsional)</label>
                      <input type="text" name="nama_penyerah" value="{{ old('nama_penyerah') }}" placeholder="Contoh: Keluarga Bpk. Tarigan" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm transition bg-white">
                  </div>
                  <div>
                      <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Asal Koleksi (Opsional)</label>
                      <input type="text" name="asal_koleksi" value="{{ old('asal_koleksi') }}" placeholder="Contoh: Desa Barusjahe / Tidak Diketahui" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm transition bg-white">
                  </div>
                  <div>
                      <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kondisi Fisik (Opsional)</label>
                      <input type="text" name="kondisi_fisik" value="{{ old('kondisi_fisik') }}" placeholder="Contoh: Baik / Sedikit Rusak" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm transition bg-white">
                  </div>
              </div>
              
              <!-- Judul Koleksi -->"""
                  
    content = content.replace(target, new_fields)

    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)
