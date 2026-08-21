<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Koleksi;
use App\Models\Kategori;

class CuratorController extends Controller
{
    public function index(Request $request)
    {
        $pendingCollections = Koleksi::whereIn('status', ['menunggu_kurasi', 'menunggu_persetujuan'])
                                        ->orderBy('updated_at', 'desc')
                                        ->get();

        $selectedCollection = null;
        if ($request->has('id')) {
            $selectedCollection = Koleksi::with('kategori')->find($request->id);
        } elseif ($pendingCollections->count() > 0) {
            $selectedCollection = $pendingCollections->first();
        }

        $categories = Kategori::all();

        return view('curator.dashboard', compact('pendingCollections', 'selectedCollection', 'categories'));
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
}
