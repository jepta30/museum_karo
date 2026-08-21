<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Koleksi;

class RegistrarController extends Controller
{
    public function index()
    {
        $categories = Kategori::all();
        $collections = Koleksi::with('kategori')->orderBy('created_at', 'desc')->take(12)->get();
        $weeklyCount = Koleksi::where('created_at', '>=', now()->subDays(7))->count();
        
        return view('registrar.dashboard', compact('categories', 'collections', 'weeklyCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sementara' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'nama_penyerah' => 'required|string|max:255',
            'tanggal_terima' => 'required|date',
            'kondisi_awal' => 'nullable|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $photoPath = $request->file('photo')->store('koleksi', 'public');

        Koleksi::create([
            'nama_sementara' => $request->nama_sementara,
            'kategori_id' => $request->kategori_id,
            'nama_penyerah' => $request->nama_penyerah,
            'tanggal_terima' => $request->tanggal_terima,
            'kondisi_awal' => $request->kondisi_awal,
            'path_foto' => $photoPath,
            'status' => 'menunggu_kurasi',
        ]);

        return redirect()->back()->with('success', 'Data koleksi berhasil disimpan!');
    }
}
