import re

with open('app/Http/Controllers/AdminController.php', 'r', encoding='utf-8') as f:
    content = f.read()

new_methods = """
    public function editKoleksi($id)
    {
        $modul = ModulEdukasi::with('koleksi.kategori')->findOrFail($id);
        $kategoris = Kategori::orderBy('nama', 'asc')->get();
        return view('admin.koleksi.edit', compact('modul', 'kategoris'));
    }

    public function updateKoleksi(Request $request, $id)
    {
        $request->validate([
            'nomor_koleksi' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'judul' => 'required|string|max:255',
            'deskripsi_umum' => 'required|string',
            'sejarah_makna' => 'nullable|string',
            'galeri_files.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:51200'
        ]);

        $modul = ModulEdukasi::findOrFail($id);
        $koleksi = $modul->koleksi;

        if ($koleksi) {
            $koleksi->nama_sementara = $request->judul;
            $koleksi->nomor_inventaris_final = $request->nomor_koleksi;
            $koleksi->kategori_id = $request->kategori_id;
            $koleksi->save();
        }

        $modul->judul = $request->judul;
        $modul->latitude = $request->latitude;
        $modul->longitude = $request->longitude;
        $modul->konten = json_encode([
            'deskripsi_umum' => $request->deskripsi_umum,
            'sejarah_makna' => $request->sejarah_makna
        ]);
        $modul->save();

        if ($request->hasFile('galeri_files')) {
            $files = $request->file('galeri_files');
            foreach ($files as $index => $file) {
                $path = $file->store('galeri_modul', 'public');
                $ext = strtolower($file->getClientOriginalExtension());
                $tipe = in_array($ext, ['mp4', 'mov', 'avi']) ? 'video' : 'foto';
                GaleriModul::create([
                    'modul_edukasi_id' => $modul->id,
                    'tipe' => $tipe,
                    'path_file' => $path,
                ]);
                
                if ($index === 0 && $tipe === 'foto' && $koleksi) {
                    $koleksi->path_foto = $path;
                    $koleksi->save();
                }
            }
        }

        return redirect()->route('admin.koleksi')->with('success', 'Koleksi Budaya berhasil diperbarui!');
    }
}
"""

if "public function editKoleksi" not in content:
    content = content.replace("}\n", new_methods, 1)

with open('app/Http/Controllers/AdminController.php', 'w', encoding='utf-8') as f:
    f.write(content)
