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
    return view('welcome');
})->name('home');

Route::get('/koleksi/{id}', function ($id) {
    $modul = \App\Models\ModulEdukasi::with('koleksi.kategori')->where('status', 'diterbitkan')->findOrFail($id);
    
    $koleksi = $modul->koleksi;
    $kontenData = json_decode($modul->konten, true);
    $deskripsi_umum = is_array($kontenData) ? ($kontenData['deskripsi_umum'] ?? '') : $modul->konten;
    $sejarah_makna = is_array($kontenData) ? ($kontenData['sejarah_makna'] ?? '') : '';

    return view('koleksi_detail', compact('modul', 'koleksi', 'deskripsi_umum', 'sejarah_makna'));
})->name('koleksi.detail');

Route::middleware('auth')->group(function () {
    
    // Redirect otomatis berdasarkan peran
    Route::get('/dashboard', function () {
        $peran = Auth::user()->peran;
        if ($peran === 'kurator') return redirect()->route('curator.dashboard');
        if ($peran === 'pimpinan') return redirect()->route('leader.dashboard');
        if ($peran === 'edukator') return redirect()->route('educator.dashboard');
        return redirect()->route('registrar.dashboard');
    })->name('dashboard');

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
