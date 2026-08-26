<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Koleksi;
use App\Models\Kategori;

class CuratorController extends Controller
{
    public function index(Request $request)
    {
        $koleksi = Koleksi::orderBy('updated_at', 'desc')->paginate(10);
        
        $countMenunggu = Koleksi::where('status', 'menunggu_kurasi')
                                ->whereNull('sejarah_asal_usul')
                                ->whereNull('kondisi_kuratorial')
                                ->count();
                                
        $countPenelitian = Koleksi::where('status', 'menunggu_kurasi')
                                  ->where(function($q) {
                                      $q->whereNotNull('sejarah_asal_usul')
                                        ->orWhereNotNull('kondisi_kuratorial');
                                  })->count();
                                  
        $countSelesai = Koleksi::whereIn('status', ['menunggu_persetujuan', 'disetujui', 'dipublikasi'])->count();

        return view('curator.dashboard', compact('koleksi', 'countMenunggu', 'countPenelitian', 'countSelesai'));
    }

    public function kurasi(Request $request)
    {
        $pendingCollections = Koleksi::whereIn('status', ['menunggu_kurasi', 'menunggu_persetujuan', 'disetujui'])
                                        ->orderBy('updated_at', 'desc')
                                        ->get();

        $selectedCollection = null;
        if ($request->has('id')) {
            $selectedCollection = Koleksi::with('kategori')->find($request->id);
        } elseif ($pendingCollections->count() > 0) {
            $selectedCollection = $pendingCollections->first();
        }

        $categories = Kategori::all();

        // Generate draft inventory number if empty
        if ($selectedCollection && empty($selectedCollection->draf_nomor_inventaris)) {
            $receiveDate = \Carbon\Carbon::parse($selectedCollection->tanggal_terima);
            $yearFront = $receiveDate->format('y');
            $yearFull = (int) $receiveDate->format('Y');
            $middleNumber = str_pad($yearFull - 2009, 2, '0', STR_PAD_LEFT);
            
            $sequence = \App\Models\Koleksi::where('id', '<=', $selectedCollection->id)->count();
            $paddedSeq = str_pad($sequence, 4, '0', STR_PAD_LEFT);
            
            $generatedDraft = "{$yearFront}.{$middleNumber}.{$paddedSeq}";
            $selectedCollection->draf_nomor_inventaris = $generatedDraft;
        }

        return view('curator.kurasi', compact('pendingCollections', 'selectedCollection', 'categories'));
    }

    public function edit($id)
    {
        $selectedCollection = Koleksi::with('kategori')->findOrFail($id);
        $categories = Kategori::all();

        // Generate draft inventory number if empty
        if (empty($selectedCollection->draf_nomor_inventaris)) {
            $receiveDate = \Carbon\Carbon::parse($selectedCollection->tanggal_terima);
            $yearFront = $receiveDate->format('y');
            $yearFull = (int) $receiveDate->format('Y');
            $middleNumber = str_pad($yearFull - 2009, 2, '0', STR_PAD_LEFT);
            
            $sequence = \App\Models\Koleksi::where('id', '<=', $selectedCollection->id)->count();
            $paddedSeq = str_pad($sequence, 4, '0', STR_PAD_LEFT);
            
            $generatedDraft = "{$yearFront}.{$middleNumber}.{$paddedSeq}";
            $selectedCollection->draf_nomor_inventaris = $generatedDraft;
        }

        return view('curator.edit', compact('selectedCollection', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $collection = Koleksi::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'draf_nomor_inventaris' => 'nullable|string|max:255',
            'sejarah_asal_usul' => 'nullable|string',
            'kondisi_kuratorial' => 'nullable|string',
        ]);

        $status = $request->input('action') === 'submit' ? 'menunggu_persetujuan' : 'menunggu_kurasi';

        $collection->update([
            'kategori_id' => $request->kategori_id,
            'draf_nomor_inventaris' => $request->draf_nomor_inventaris,
            'sejarah_asal_usul' => $request->sejarah_asal_usul,
            'kondisi_kuratorial' => $request->kondisi_kuratorial,
            'status' => $status,
        ]);

        $message = $status === 'menunggu_persetujuan' 
            ? 'Rekomendasi berhasil dikirim ke Pimpinan.' 
            : 'Draf riset berhasil disimpan.';

        return redirect()->route('curator.dashboard')->with('success', $message);
    }

    public function generateBeritaAcara($id)
    {
        $collection = Koleksi::findOrFail($id);

        if ($collection->status !== 'disetujui' && $collection->status !== 'dipublikasi') {
            return redirect()->back()->with('error', 'Berita Acara hanya dapat diunduh jika koleksi sudah disetujui.');
        }

        if ($collection->batch_id) {
            $collections = Koleksi::where('batch_id', $collection->batch_id)->get();
        } else {
            $collections = collect([$collection]);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.berita_acara', [
            'collection' => $collection, 
            'collections' => $collections
        ]);
        
        return $pdf->download('Berita_Acara_Penerimaan_Koleksi_' . $collection->nomor_inventaris_final . '.pdf');
    }

    public function repository()
    {
        $approvedCount = \App\Models\Koleksi::where('status', 'disetujui')->count();
        $totalDokumen = \App\Models\DokumenRepositori::count(); 
        
        $beritaAcaraBaru = \App\Models\DokumenRepositori::whereMonth('created_at', now()->month)
                                                        ->whereYear('created_at', now()->year)
                                                        ->count(); 
        
        // Dokumen Legal Aktif: Dokumen berupa Surat Keputusan atau Berita Acara
        $dokumenAktif = \App\Models\DokumenRepositori::whereIn('kategori', ['Surat Keputusan', 'Berita Acara'])->count();

        $dokumenList = \App\Models\DokumenRepositori::orderBy('created_at', 'desc')->paginate(10);

        return view('curator.repository', compact('totalDokumen', 'beritaAcaraBaru', 'dokumenAktif', 'dokumenList'));
    }

    public function storeDokumen(Request $request)
    {
        $request->validate([
            'judul_dokumen' => 'required|string|max:255',
            'file_dokumen' => 'required|file|mimes:pdf|max:5120',
        ]);

        $path = $request->file('file_dokumen')->store('dokumen', 'public');

        \App\Models\DokumenRepositori::create([
            'judul_dokumen' => $request->judul_dokumen,
            'path_dokumen' => $path,
            'diunggah_oleh' => \Illuminate\Support\Facades\Auth::id()
        ]);

        return redirect()->route('curator.repository')->with('success', 'Dokumen berhasil diunggah ke repositori.');
    }

    public function komentar()
    {
        $komentars = \App\Models\Komentar::with('koleksi')->where('status', 'menunggu')->latest()->get();
        return view('curator.komentar', compact('komentars'));
    }

    public function approveKomentar($id)
    {
        $komentar = \App\Models\Komentar::findOrFail($id);
        $komentar->update(['status' => 'disetujui']);
        return redirect()->route('curator.komentar')->with('success', 'Komentar berhasil disetujui dan diterbitkan.');
    }

    public function rejectKomentar($id)
    {
        $komentar = \App\Models\Komentar::findOrFail($id);
        $komentar->delete();
        return redirect()->route('curator.komentar')->with('success', 'Komentar ditolak dan dihapus.');
    }

    public function katalogPengunjung(Request $request)
    {
        $query = \App\Models\BukuTamu::query();
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('pekerjaan', 'like', "%{$search}%");
        }
        
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('tanggal', $request->date);
        }

        $bukuTamu = $query->latest('tanggal')->latest('id')->get();

        // Real Statistics
        $totalKunjungan = \App\Models\KunjunganWebsite::count();
        
        $desktopCount = \App\Models\KunjunganWebsite::where('device_type', 'desktop')->count();
        $mobileCount = \App\Models\KunjunganWebsite::where('device_type', 'mobile')->count();

        // Top Koleksi
        $topKoleksiData = \App\Models\KunjunganWebsite::whereNotNull('koleksi_id')
            ->select('koleksi_id', \Illuminate\Support\Facades\DB::raw('count(*) as views'))
            ->groupBy('koleksi_id')
            ->orderByDesc('views')
            ->limit(3)
            ->get();
            
        $topKoleksi = [];
        foreach ($topKoleksiData as $tk) {
            $koleksi = \App\Models\Koleksi::find($tk->koleksi_id);
            if ($koleksi) {
                $topKoleksi[] = [
                    'nama' => $koleksi->nama_sementara ?? 'Koleksi',
                    'views' => $tk->views
                ];
            }
        }

        // Tren Kunjungan Harian (Last 7 days)
        $trenKunjungan = \App\Models\KunjunganWebsite::select(
            \Illuminate\Support\Facades\DB::raw('DATE(created_at) as date'),
            \Illuminate\Support\Facades\DB::raw('count(*) as views')
        )
        ->groupBy('date')
        ->orderByDesc('date')
        ->limit(7)
        ->get()
        ->reverse()
        ->values();

        return view('curator.katalog_pengunjung', compact('bukuTamu', 'topKoleksi', 'totalKunjungan', 'desktopCount', 'mobileCount', 'trenKunjungan'));
    }

    public function storeBukuTamu(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
        ]);

        \App\Models\BukuTamu::create($request->all());

        return redirect()->route('curator.katalog')->with('success', 'Kunjungan berhasil dicatat.');
    }

    public function deleteBukuTamu($id)
    {
        $bukuTamu = \App\Models\BukuTamu::findOrFail($id);
        $bukuTamu->delete();
        return redirect()->route('curator.katalog')->with('success', 'Catatan kunjungan berhasil dihapus.');
    }
}
