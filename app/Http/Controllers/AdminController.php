<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\ModulEdukasi;
use App\Models\Koleksi;
use App\Models\Kategori;
use App\Models\GaleriModul;


class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Statistik Login Pengguna (Top 4)
        $stats = \App\Models\LogAktivitas::where('aksi', 'Login ke dalam sistem')
            ->selectRaw('nama_pengguna as label, count(*) as count')
            ->groupBy('nama_pengguna')
            ->orderByDesc('count')
            ->limit(4)
            ->get()
            ->toArray();



        // 2. Log Aktivitas Terbaru
        $logs = \App\Models\LogAktivitas::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'logs'));
    }

    public function users()
    {
        $users = \App\Models\User::paginate(4);
        
        // Count active users
        $totalAktif = \App\Models\User::where('is_active', true)->count();
        
        // Count flagged activities in last 24h
        $peringatan = \App\Models\LogAktivitas::where('status', 'Ditandai')
            ->where('created_at', '>=', now()->subDay())
            ->count();
            
        // Fetch recent logs
        $logs = \App\Models\LogAktivitas::latest()->limit(5)->get();
        
        return view('admin.users', compact('users', 'totalAktif', 'peringatan', 'logs'));
    }

    public function logs()
    {
        $logs = \App\Models\LogAktivitas::latest()->paginate(15);
        return view('admin.logs', compact('logs'));
    }

    public function roles()
    {
        $users = \App\Models\User::orderBy('peran')->get();
        return view('admin.roles', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'peran' => 'required|in:pendaftar,edukator,kurator,pimpinan,admin',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'peran' => $request->peran,
            'is_active' => true,
        ]);

        \App\Models\LogAktivitas::create([
            'user_id' => auth()->id(),
            'nama_pengguna' => auth()->user()->name,
            'aksi' => "Membuat akun baru '{$user->name}' dengan peran {$user->peran}",
            'status' => 'Berhasil'
        ]);

        return back()->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function exportLogs()
    {
        $fileName = 'log_aktivitas_museum_karo_' . date('Y-m-d_H-i-s') . '.csv';
        $logs = \App\Models\LogAktivitas::latest()->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID', 'Waktu', 'Pengguna', 'Aktivitas', 'Status');

        $callback = function() use($logs, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($logs as $log) {
                fputcsv($file, array(
                    $log->id, 
                    $log->created_at->format('Y-m-d H:i:s'), 
                    $log->nama_pengguna, 
                    $log->aksi, 
                    $log->status
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

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
        $kategoris = Kategori::orderBy('nama', 'asc')->get();
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

        $koleksi = new Koleksi();
        $koleksi->nama_sementara = $request->judul;
        $koleksi->nomor_inventaris_final = $request->nomor_koleksi;
        $koleksi->kategori_id = $request->kategori_id;
        $koleksi->status = 'dipublikasi';
        $koleksi->nama_penyerah = 'Admin (Bypass)';
        $koleksi->tanggal_terima = now();
        $koleksi->path_foto = '-'; // Akan diupdate jika ada foto
        $koleksi->save();

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
        $modul->status = 'diterbitkan'; 
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
                
                if ($index === 0 && $tipe === 'foto') {
                    $koleksi->path_foto = $path;
                    $koleksi->save();
                }
            }
        }

        return redirect()->route('admin.koleksi')->with('success', 'Koleksi Budaya berhasil ditambahkan dan langsung dipublikasikan!');
    }


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
        
        $konten = json_decode($modul->konten, true) ?? [];
        $konten['deskripsi_umum'] = $request->deskripsi_umum;
        $konten['sejarah_makna'] = $request->sejarah_makna;
        $modul->konten = json_encode($konten);
        
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

