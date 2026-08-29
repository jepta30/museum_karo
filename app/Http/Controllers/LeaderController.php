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

        \App\Models\LogAktivitas::create([
            'user_id' => auth()->id(),
            'nama_pengguna' => auth()->user()->name,
            'aksi' => "Menyetujui koleksi budaya '{$collection->nama_sementara}' (No. Inv: {$request->nomor_inventaris_final})",
            'status' => 'Berhasil'
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


}
