import re

with open('app/Http/Controllers/AdminController.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Update validation in storeKoleksi
store_val_target = "'judul' => 'required|string|max:255',"
store_val_new = """'judul' => 'required|string|max:255',
            'nama_penyerah' => 'nullable|string|max:255',
            'asal_koleksi' => 'nullable|string|max:255',
            'kondisi_fisik' => 'nullable|string|max:255',"""
content = content.replace(store_val_target, store_val_new)

# Update save in storeKoleksi
store_save_target = "$koleksi->nama_penyerah = 'Admin (Bypass)';"
store_save_new = """$koleksi->nama_penyerah = $request->nama_penyerah ?: 'Museum Pusaka Karo';
        $koleksi->alamat_penyerah = $request->asal_koleksi;
        $koleksi->kondisi_awal = $request->kondisi_fisik;"""
content = content.replace(store_save_target, store_save_new)

# Update validation in updateKoleksi
update_val_target = "'judul' => 'required|string|max:255',"
update_val_new = """'judul' => 'required|string|max:255',
            'nama_penyerah' => 'nullable|string|max:255',
            'asal_koleksi' => 'nullable|string|max:255',
            'kondisi_fisik' => 'nullable|string|max:255',"""
content = content.replace(update_val_target, update_val_new)

# Update save in updateKoleksi
update_save_target = "$koleksi->kategori_id = $request->kategori_id;"
update_save_new = """$koleksi->kategori_id = $request->kategori_id;
            $koleksi->nama_penyerah = $request->nama_penyerah ?: 'Museum Pusaka Karo';
            $koleksi->alamat_penyerah = $request->asal_koleksi;
            $koleksi->kondisi_awal = $request->kondisi_fisik;"""
content = content.replace(update_save_target, update_save_new)

with open('app/Http/Controllers/AdminController.php', 'w', encoding='utf-8') as f:
    f.write(content)
