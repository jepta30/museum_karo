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

        $koleksi = $query->orderBy('updated_at', 'desc')->paginate(12);
        $kategori = \App\Models\Kategori::all();

        return view('educator.koleksi', compact('koleksi', 'kategori'));
    }

    public function showKoleksi($id)
    {
        $koleksi = Koleksi::findOrFail($id);
        
        // Pastikan hanya yang disetujui/dipublikasi yang bisa dilihat
        if (!in_array($koleksi->status, ['disetujui', 'dipublikasi'])) {
            return redirect()->route('educator.koleksi')->with('error', 'Koleksi belum disetujui.');
        }

        return view('educator.koleksi_show', compact('koleksi'));
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
            'konten' => 'required|string',
            'koleksi_id' => 'nullable|exists:koleksi,id'
        ]);

        $modul = new ModulEdukasi();
        $modul->judul = $request->judul;
        $modul->konten = $request->konten;
        $modul->koleksi_id = $request->koleksi_id;
        $modul->penulis_id = \Illuminate\Support\Facades\Auth::id();
        $modul->status = 'draf';
        $modul->save();

        return redirect()->route('educator.dashboard')->with('success', 'Draf modul edukasi berhasil disimpan.');
    }
}
