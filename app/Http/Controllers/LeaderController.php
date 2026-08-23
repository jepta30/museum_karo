<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Koleksi;

class LeaderController extends Controller
{
    public function index()
    {
        $totalKoleksi = Koleksi::count();
        $bulanIni = Koleksi::whereMonth('created_at', now()->month)
                           ->whereYear('created_at', now()->year)
                           ->count();

        $menungguPersetujuanCount = Koleksi::where('status', 'menunggu_persetujuan')->count();
        $antreanPersetujuan = Koleksi::where('status', 'menunggu_persetujuan')->orderBy('updated_at', 'desc')->get();

        return view('leader.dashboard', compact('totalKoleksi', 'bulanIni', 'menungguPersetujuanCount', 'antreanPersetujuan'));
    }

    public function review($id)
    {
        $collection = Koleksi::with('kategori')->findOrFail($id);
        
        // Hanya bisa mereview yang sedang menunggu persetujuan
        if ($collection->status !== 'menunggu_persetujuan' && $collection->status !== 'disetujui') {
            return redirect()->route('leader.dashboard')->with('error', 'Status koleksi tidak valid untuk ditinjau.');
        }

        return view('leader.review', compact('collection'));
    }

    public function approve(Request $request, $id)
    {
        $collection = Koleksi::findOrFail($id);

        $request->validate([
            'nomor_inventaris_final' => 'required|string|max:255',
        ]);

        $collection->update([
            'nomor_inventaris_final' => $request->nomor_inventaris_final,
            'tanggal_persetujuan' => now(),
            'status' => 'disetujui',
        ]);

        return redirect()->route('leader.dashboard')->with('success', 'Koleksi berhasil disetujui dan ditandatangani.');
    }

    public function education()
    {
        $modules = \App\Models\ModulEdukasi::with('penulis')->orderBy('created_at', 'asc')->get();
        
        $totalDiterbitkan = $modules->where('status', 'diterbitkan')->count();
        $menungguPersetujuan = $modules->where('status', 'menunggu_persetujuan')->count();

        // Count images from Koleksi that have been approved
        $totalImages = \App\Models\Koleksi::whereIn('status', ['disetujui', 'dipublikasi'])->count();

        return view('leader.education', compact('modules', 'totalDiterbitkan', 'menungguPersetujuan', 'totalImages'));
    }

    public function repository()
    {
        $approvedCount = \App\Models\Koleksi::where('status', 'disetujui')->count();
        $totalDokumen = $approvedCount; // Real DB logic
        $beritaAcaraBaru = $approvedCount; // Real DB logic

        $dokumenList = [
            [
                'nama' => 'Berita Acara Serah Terima Artefak #8821',
                'id_doc' => 'DOC-2023-10-8821',
                'kategori' => 'Berita Acara',
                'tanggal' => '12 Okt 2023',
                'ukuran' => '2.4 MB'
            ],
            [
                'nama' => 'SK Kurasi Koleksi Emas',
                'id_doc' => 'SK-DIR-2023-09-001',
                'kategori' => 'SK Tim',
                'tanggal' => '05 Sep 2023',
                'ukuran' => '1.1 MB'
            ],
            [
                'nama' => 'Laporan Audit Koleksi Semester I',
                'id_doc' => 'REP-2023-S1-AUD',
                'kategori' => 'Laporan',
                'tanggal' => '15 Jul 2023',
                'ukuran' => '15.8 MB'
            ]
        ];

        return view('leader.repository', compact('totalDokumen', 'beritaAcaraBaru', 'dokumenList'));
    }
}
