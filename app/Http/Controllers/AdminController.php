<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
