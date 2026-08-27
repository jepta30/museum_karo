<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CuratorController;
use App\Http\Controllers\LeaderController;

use Illuminate\Support\Facades\Auth;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }

    $modulEdukasi = \App\Models\ModulEdukasi::with('koleksi.kategori')->where('status', 'diterbitkan')->latest()->get();
    
    // For dashboard stats on public
    $totalKoleksi = $modulEdukasi->count();
    $totalKategori = $modulEdukasi->pluck('koleksi.kategori_id')->unique()->filter()->count();

    // Track visit
    $deviceType = preg_match('/Mobile|Android|iP(hone|od|ad)/i', request()->header('User-Agent')) ? 'mobile' : 'desktop';
    \App\Models\KunjunganWebsite::create([
        'ip_address' => request()->ip(),
        'device_type' => $deviceType,
        'url' => request()->url(),
        'koleksi_id' => null,
    ]);

    return view('welcome', compact('modulEdukasi', 'totalKoleksi', 'totalKategori'));
})->name('home');

Route::post('/buku-tamu', function (Illuminate\Http\Request $request) {
    $request->validate([
        'nama' => 'required|string|max:255',
        'alamat' => 'nullable|string|max:255',
        'pekerjaan' => 'nullable|string|max:255',
    ]);

    \App\Models\BukuTamu::create([
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'pekerjaan' => $request->pekerjaan,
        'tanggal' => now()->toDateString(),
    ]);

    // Set a session variable so it doesn't pop up again in this session
    session()->put('buku_tamu_filled', true);

    return redirect()->back()->with('success_buku_tamu', 'Terima kasih telah mengisi buku tamu!');
})->name('buku_tamu.store');

Route::get('/koleksi/{id}', function ($id) {
    $modul = \App\Models\ModulEdukasi::with('koleksi.kategori')->where('status', 'diterbitkan')->findOrFail($id);
    
    $koleksi = $modul->koleksi;
    $kontenData = json_decode($modul->konten, true);
    $deskripsi_umum = is_array($kontenData) ? ($kontenData['deskripsi_umum'] ?? '') : $modul->konten;
    $sejarah_makna = is_array($kontenData) ? ($kontenData['sejarah_makna'] ?? '') : '';

    $komentars = \App\Models\Komentar::where('koleksi_id', $koleksi->id)->where('status', 'disetujui')->latest()->get();

    // Track visit
    $deviceType = preg_match('/Mobile|Android|iP(hone|od|ad)/i', request()->header('User-Agent')) ? 'mobile' : 'desktop';
    \App\Models\KunjunganWebsite::create([
        'ip_address' => request()->ip(),
        'device_type' => $deviceType,
        'url' => request()->url(),
        'koleksi_id' => $koleksi->id,
    ]);

    return view('koleksi_detail', compact('modul', 'koleksi', 'deskripsi_umum', 'sejarah_makna', 'komentars'));
})->name('koleksi.detail');

Route::post('/koleksi/{id}/komentar', function (Illuminate\Http\Request $request, $id) {
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'isi_komentar' => 'required|string',
    ]);

    $modul = \App\Models\ModulEdukasi::findOrFail($id);

    \App\Models\Komentar::create([
        'koleksi_id' => $modul->koleksi_id,
        'nama' => $request->nama,
        'email' => $request->email,
        'isi_komentar' => $request->isi_komentar,
        'status' => 'menunggu'
    ]);

    return redirect()->back()->with('success_komentar', 'Komentar Anda berhasil dikirim dan sedang menunggu persetujuan.');
})->name('koleksi.komentar');

Route::middleware('auth')->group(function () {
    
    // Redirect otomatis berdasarkan peran
    Route::get('/dashboard', function () {
        $peran = Auth::user()->peran;
        if ($peran === 'admin') return redirect()->route('admin.dashboard');
        if ($peran === 'kurator') return redirect()->route('curator.dashboard');
        if ($peran === 'pimpinan') return redirect()->route('leader.dashboard');
        if ($peran === 'edukator') return redirect()->route('educator.dashboard');
        return redirect()->route('registrar.dashboard');
    })->name('dashboard');

    // Rute Admin
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/logs', [\App\Http\Controllers\AdminController::class, 'logs'])->name('admin.logs');
    Route::get('/admin/logs/export', [\App\Http\Controllers\AdminController::class, 'exportLogs'])->name('admin.logs.export');
    Route::get('/admin/roles', [\App\Http\Controllers\AdminController::class, 'roles'])->name('admin.roles');
    Route::post('/admin/roles/store', [\App\Http\Controllers\AdminController::class, 'storeUser'])->name('admin.store_user');

    // Rute Registrar
    Route::get('/registrar', [RegistrarController::class, 'index'])->name('registrar.dashboard');
    Route::get('/registrar/create', [RegistrarController::class, 'create'])->name('registrar.create');
    Route::get('/registrar/collections/{id}', [RegistrarController::class, 'show'])->name('registrar.show');
    Route::post('/collections', [RegistrarController::class, 'store'])->name('registrar.store');

    // Rute Kurator
    Route::get('/curator', [CuratorController::class, 'index'])->name('curator.dashboard');
    Route::get('/curator/kurasi', [CuratorController::class, 'kurasi'])->name('curator.kurasi');
    Route::get('/curator/collections/{id}/edit', [CuratorController::class, 'edit'])->name('curator.edit');
    Route::post('/curator/collections/{id}', [CuratorController::class, 'update'])->name('curator.update');
    Route::get('/curator/collections/{id}/berita-acara', [CuratorController::class, 'generateBeritaAcara'])->name('curator.berita_acara');
    Route::get('/curator/repository', [CuratorController::class, 'repository'])->name('curator.repository');
    Route::post('/curator/repository/store', [CuratorController::class, 'storeDokumen'])->name('curator.repository.store');
    
    // Komentar Pengunjung
    Route::get('/curator/komentar', [CuratorController::class, 'komentar'])->name('curator.komentar');
    Route::post('/curator/komentar/{id}/approve', [CuratorController::class, 'approveKomentar'])->name('curator.komentar.approve');
    Route::delete('/curator/komentar/{id}', [CuratorController::class, 'rejectKomentar'])->name('curator.komentar.reject');

    // Katalog Pengunjung / Buku Tamu
    Route::get('/curator/katalog-pengunjung', [CuratorController::class, 'katalogPengunjung'])->name('curator.katalog');
    Route::post('/curator/katalog-pengunjung', [CuratorController::class, 'storeBukuTamu'])->name('curator.katalog.store');
    Route::delete('/curator/katalog-pengunjung/{id}', [CuratorController::class, 'deleteBukuTamu'])->name('curator.katalog.delete');

    // Rute Pimpinan
    Route::get('/leader', [LeaderController::class, 'index'])->name('leader.dashboard');
    Route::get('/leader/collections/{id}', [LeaderController::class, 'review'])->name('leader.review');
    Route::post('/leader/collections/{id}/approve', [LeaderController::class, 'approve'])->name('leader.approve');
    Route::get('/leader/education', [LeaderController::class, 'education'])->name('leader.education');

    // Rute Edukator
    Route::get('/educator', [App\Http\Controllers\EducatorController::class, 'index'])->name('educator.dashboard');
    Route::get('/educator/koleksi', [App\Http\Controllers\EducatorController::class, 'koleksi'])->name('educator.koleksi');
    Route::get('/educator/koleksi/{id}', [App\Http\Controllers\EducatorController::class, 'showKoleksi'])->name('educator.koleksi.show');
    Route::get('/educator/alat-edukasi', [App\Http\Controllers\EducatorController::class, 'alatEdukasi'])->name('educator.alat_edukasi');
    
    // Rute Modul Edukasi
    Route::get('/educator/modul/create', [App\Http\Controllers\EducatorController::class, 'createModul'])->name('educator.modul.create');
    Route::post('/educator/modul/store', [App\Http\Controllers\EducatorController::class, 'storeModul'])->name('educator.modul.store');
    Route::get('/educator/modul/{id}', [App\Http\Controllers\EducatorController::class, 'showModul'])->name('educator.modul.show');
    Route::get('/educator/modul/{id}/edit', [App\Http\Controllers\EducatorController::class, 'editModul'])->name('educator.modul.edit');
    Route::post('/educator/modul/{id}/update', [App\Http\Controllers\EducatorController::class, 'updateModul'])->name('educator.modul.update');
    Route::post('/educator/modul/{id}/unpublish', [App\Http\Controllers\EducatorController::class, 'unpublishModul'])->name('educator.modul.unpublish');
});
