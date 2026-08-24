<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Koleksi;

class RegistrarController extends Controller
{
    public function index()
    {
        $menungguCount = Koleksi::where('status', 'menunggu_kurasi')->count();
        $dinilaiCount = Koleksi::where('status', 'menunggu_persetujuan')->count();
        $selesaiCount = Koleksi::whereIn('status', ['disetujui', 'dipublikasi'])->count();

        $aktivitasTerbaru = Koleksi::with('kategori')->orderBy('created_at', 'desc')->take(10)->get();

        return view('registrar.dashboard', compact('menungguCount', 'dinilaiCount', 'selesaiCount', 'aktivitasTerbaru'));
    }

    public function create()
    {
        $categories = Kategori::all();
        $collections = Koleksi::with('kategori')->orderBy('created_at', 'desc')->take(12)->get();
        $weeklyCount = Koleksi::where('created_at', '>=', now()->subDays(7))->count();
        
        return view('registrar.create', compact('categories', 'collections', 'weeklyCount'));
    }

    public function show($id)
    {
        $koleksi = Koleksi::with('kategori')->findOrFail($id);
        return view('registrar.show', compact('koleksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_penyerah' => 'required|string|max:255',
            'tempat_lahir_penyerah' => 'nullable|string|max:255',
            'tanggal_lahir_penyerah' => 'nullable|date',
            'pekerjaan_penyerah' => 'nullable|string|max:255',
            'alamat_penyerah' => 'nullable|string',
            'tanggal_terima' => 'required|date',
            
            'nama_sementara' => 'required|array|min:1',
            'nama_sementara.*' => 'required|string|max:255',
            'kategori_id' => 'required|array|min:1',
            'kategori_id.*' => 'required|exists:kategori,id',
            'kondisi_awal' => 'nullable|array',
            'klaim_asal_usul' => 'nullable|array',
            'photo' => 'required|array|min:1',
            'photo.*' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $batchId = 'BA-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));

        foreach ($request->nama_sementara as $index => $nama) {
            $photoPath = $request->file('photo')[$index]->store('koleksi', 'public');

            Koleksi::create([
                'batch_id' => $batchId,
                'nama_sementara' => $nama,
                'kategori_id' => $request->kategori_id[$index],
                'nama_penyerah' => $request->nama_penyerah,
                'tempat_lahir_penyerah' => $request->tempat_lahir_penyerah,
                'tanggal_lahir_penyerah' => $request->tanggal_lahir_penyerah,
                'pekerjaan_penyerah' => $request->pekerjaan_penyerah,
                'alamat_penyerah' => $request->alamat_penyerah,
                'tanggal_terima' => $request->tanggal_terima,
                'kondisi_awal' => $request->kondisi_awal[$index] ?? null,
                'klaim_asal_usul' => $request->klaim_asal_usul[$index] ?? null,
                'path_foto' => $photoPath,
                'status' => 'menunggu_kurasi',
            ]);
        }

        return redirect()->back()->with('success', 'Data koleksi berhasil disimpan!');
    }
}
