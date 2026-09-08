import re

with open('app/Http/Controllers/AdminController.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Add use statements if needed
if 'use App\Models\ModulEdukasi;' not in content:
    content = content.replace('use App\Models\User;', "use App\Models\User;\nuse App\Models\ModulEdukasi;\nuse App\Models\Koleksi;\nuse App\Models\Kategori;\nuse App\Models\GaleriModul;")

methods = """
    public function koleksi(Request $request)
    {
        $query = ModulEdukasi::with('koleksi.kategori', 'penulis');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhereHas('koleksi', function($q) use ($search) {
                      $q->where('nomor_inventaris_final', 'like', "%{$search}%");
                  });
        }
        
        $koleksi = $query->latest()->paginate(10);
        return view('admin.koleksi.index', compact('koleksi'));
    }

    public function createKoleksi()
    {
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('admin.koleksi.create', compact('kategoris'));
    }

    public function storeKoleksi(Request $request)
    {
        $request->validate([
            'nomor_koleksi' => 'required|string|unique:koleksi,nomor_inventaris_final',
            'kategori_id' => 'required|exists:kategori,id',
            'judul' => 'required|string|max:255',
            'deskripsi_umum' => 'required|string',
            'sejarah_makna' => 'nullable|string',
            'galeri_files.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:51200'
        ]);

        // Create Koleksi directly skipping registrar/curator
        $koleksi = new Koleksi();
        $koleksi->nama_sementara = $request->judul;
        $koleksi->nomor_inventaris_final = $request->nomor_koleksi;
        $koleksi->kategori_id = $request->kategori_id;
        $koleksi->status = 'selesai';
        $koleksi->save();

        // Create ModulEdukasi skipping educator/leader
        $modul = new ModulEdukasi();
        $modul->judul = $request->judul;
        $modul->latitude = $request->latitude;
        $modul->longitude = $request->longitude;
        $modul->konten = json_encode([
            'deskripsi_umum' => $request->deskripsi_umum,
            'sejarah_makna' => $request->sejarah_makna
        ]);
        $modul->koleksi_id = $koleksi->id;
        $modul->penulis_id = \Illuminate\Support\Facades\Auth::id();
        $modul->status = 'diterbitkan'; // Publishes directly to public
        $modul->save();

        // Handle gallery
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
                
                // Set primary photo on Koleksi if not set
                if ($index === 0 && $tipe === 'foto') {
                    $koleksi->path_foto = $path;
                    $koleksi->save();
                }
            }
        }

        return redirect()->route('admin.koleksi')->with('success', 'Koleksi Budaya berhasil ditambahkan dan langsung dipublikasikan!');
    }
"""

content = content.replace('}', methods + '\n}')

with open('app/Http/Controllers/AdminController.php', 'w', encoding='utf-8') as f:
    f.write(content)
