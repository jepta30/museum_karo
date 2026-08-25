<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Koleksi;
use App\Models\ModulEdukasi;

class EducatorController extends Controller
{
    public function index()
    {
        $koleksiTerkumpul = Koleksi::whereIn('status', ['disetujui', 'dipublikasi'])->count();
        // Just mocking the weekly addition for now as per design
        $koleksiMingguIni = Koleksi::whereIn('status', ['disetujui', 'dipublikasi'])
                                   ->where('updated_at', '>=', now()->subDays(7))
                                   ->count();

        $drafMateri = ModulEdukasi::count();
        $siapDipublikasi = ModulEdukasi::where('status', 'siap_publikasi')->count();

        // Ambil data Koleksi yang sudah disetujui pimpinan sebagai "Aset Terbaru"
        $asetTerbaru = Koleksi::whereIn('status', ['disetujui', 'dipublikasi'])
                              ->orderBy('updated_at', 'desc')
                              ->take(5)
                              ->get();

        // Ambil data Modul Edukasi sebagai "Draf Materi Pembelajaran"
        $materiPembelajaran = ModulEdukasi::orderBy('updated_at', 'desc')
                                          ->take(4)
                                          ->get();

        return view('educator.dashboard', compact('koleksiTerkumpul', 'koleksiMingguIni', 'drafMateri', 'siapDipublikasi', 'asetTerbaru', 'materiPembelajaran'));
    }

    public function koleksi(Request $request)
    {
        $query = Koleksi::whereIn('status', ['disetujui', 'dipublikasi']);
        
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_sementara', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor_inventaris_final', 'like', '%' . $request->search . '%');
        }

        $koleksi = $query->with('modul')->orderBy('updated_at', 'desc')->paginate(12);
        $kategori = \App\Models\Kategori::all();

        return view('educator.koleksi', compact('koleksi', 'kategori'));
    }

    public function showKoleksi($id)
    {
        $koleksi = Koleksi::findOrFail($id);
        
        // Pastikan hanya yang disetujui/dipublikasi yang bisa dilihat
        if (!in_array($koleksi->status, ['disetujui', 'dipublikasi'])) {
            return redirect()->route('educator.koleksi')->with('error', 'Koleksi Budaya belum disetujui.');
        }

        $modulTerkait = ModulEdukasi::where('koleksi_id', $koleksi->id)->first();

        return view('educator.koleksi_show', compact('koleksi', 'modulTerkait'));
    }

    public function alatEdukasi(Request $request)
    {
        $query = ModulEdukasi::with('koleksi.kategori');
        
        // Filter status jika ada
        if ($request->has('status') && $request->status !== 'semua') {
            if ($request->status === 'terpublikasi') {
                $query->where('status', 'diterbitkan');
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter kategori jika ada
        if ($request->has('kategori') && $request->kategori !== 'semua') {
            $kategoriNama = $request->kategori;
            $query->whereHas('koleksi.kategori', function ($q) use ($kategoriNama) {
                $q->where('nama', 'LIKE', '%' . $kategoriNama . '%');
            });
        }

        // Ambil data terbaru
        $moduls = $query->orderBy('updated_at', 'desc')->paginate(12);

        return view('educator.alat_edukasi', compact('moduls'));
    }

    public function createModul(Request $request)
    {
        $koleksi_id = $request->query('koleksi_id');
        $koleksi = null;
        if ($koleksi_id) {
            $koleksi = Koleksi::find($koleksi_id);
        }
        
        return view('educator.modul_create', compact('koleksi'));
    }

    public function storeModul(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi_umum' => 'required|string',
            'sejarah_makna' => 'nullable|string',
            'koleksi_id' => 'nullable|exists:koleksi,id'
        ]);

        if ($request->koleksi_id) {
            $existingModul = ModulEdukasi::where('koleksi_id', $request->koleksi_id)->first();
            if ($existingModul) {
                return redirect()->route('educator.dashboard')->with('error', 'Modul edukasi untuk artefak ini sudah ada.');
            }
        }

        $modul = new ModulEdukasi();
        $modul->judul = $request->judul;
        $modul->konten = json_encode([
            'deskripsi_umum' => $request->deskripsi_umum,
            'sejarah_makna' => $request->sejarah_makna
        ]);
        $modul->koleksi_id = $request->koleksi_id;
        $modul->penulis_id = \Illuminate\Support\Facades\Auth::id();
        $modul->status = 'draf';
        $modul->save();

        return redirect()->route('educator.dashboard')->with('success', 'Draf modul edukasi berhasil disimpan.');
    }

    public function editModul($id)
    {
        $modul = ModulEdukasi::findOrFail($id);
        $koleksi = $modul->koleksi_id ? Koleksi::find($modul->koleksi_id) : null;
        
        $kontenData = json_decode($modul->konten, true);
        $deskripsi_umum = is_array($kontenData) ? ($kontenData['deskripsi_umum'] ?? '') : $modul->konten;
        $sejarah_makna = is_array($kontenData) ? ($kontenData['sejarah_makna'] ?? '') : '';

        return view('educator.modul_edit', compact('modul', 'koleksi', 'deskripsi_umum', 'sejarah_makna'));
    }

    public function updateModul(Request $request, $id)
    {
        $modul = ModulEdukasi::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi_umum' => 'required|string',
            'sejarah_makna' => 'nullable|string',
        ]);

        $modul->judul = $request->judul;
        $modul->konten = json_encode([
            'deskripsi_umum' => $request->deskripsi_umum,
            'sejarah_makna' => $request->sejarah_makna
        ]);
        
        // Cek action (Batal/Simpan Draf/Publis)
        if ($request->action === 'publis') {
            $modul->status = 'diterbitkan'; 
            $msg = 'Modul berhasil dipublikasi dan kini tampil di halaman pengunjung.';
        } else {
            $modul->status = 'draf';
            $msg = 'Draf modul berhasil diperbarui.';
        }
        
        $modul->save();

        return redirect()->route('educator.dashboard')->with('success', $msg);
    }

    public function showModul($id)
    {
        $modul = ModulEdukasi::findOrFail($id);
        
        // If somehow accessed when it's just a draft, we should redirect to edit
        if ($modul->status === 'draf') {
            return redirect()->route('educator.modul.edit', $id);
        }

        $koleksi = $modul->koleksi_id ? Koleksi::find($modul->koleksi_id) : null;
        
        $kontenData = json_decode($modul->konten, true);
        $deskripsi_umum = is_array($kontenData) ? ($kontenData['deskripsi_umum'] ?? '') : $modul->konten;
        $sejarah_makna = is_array($kontenData) ? ($kontenData['sejarah_makna'] ?? '') : '';

        return view('educator.modul_show', compact('modul', 'koleksi', 'deskripsi_umum', 'sejarah_makna'));
    }

    public function unpublishModul($id)
    {
        $modul = ModulEdukasi::findOrFail($id);
        $modul->status = 'draf';
        $modul->save();
        return redirect()->route('educator.alat_edukasi')->with('success', 'Modul berhasil dibatalkan publikasinya (dikembalikan ke Draf).');
    }
}
