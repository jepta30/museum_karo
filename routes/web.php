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

Route::middleware('auth')->group(function () {
    
    // Redirect otomatis berdasarkan peran
    Route::get('/', function () {
        $peran = Auth::user()->peran;
        if ($peran === 'kurator') return redirect()->route('curator.dashboard');
        if ($peran === 'pimpinan') return redirect()->route('leader.dashboard');
        if ($peran === 'edukator') return redirect('/educator'); // Placeholder
        return redirect()->route('registrar.dashboard');
    });

    // Rute Registrar
    Route::get('/registrar', [RegistrarController::class, 'index'])->name('registrar.dashboard');
    Route::post('/collections', [RegistrarController::class, 'store']);

    // Rute Kurator
    Route::get('/curator', [CuratorController::class, 'index'])->name('curator.dashboard');
    Route::post('/curator/collections/{id}', [CuratorController::class, 'update'])->name('curator.update');
    Route::get('/curator/collections/{id}/berita-acara', [CuratorController::class, 'generateBeritaAcara'])->name('curator.berita_acara');

    // Rute Pimpinan
    Route::get('/leader', [LeaderController::class, 'index'])->name('leader.dashboard');
    Route::get('/leader/collections/{id}', [LeaderController::class, 'review'])->name('leader.review');
    Route::post('/leader/collections/{id}/approve', [LeaderController::class, 'approve'])->name('leader.approve');
    Route::get('/leader/education', [LeaderController::class, 'education'])->name('leader.education');
    Route::get('/leader/repository', [LeaderController::class, 'repository'])->name('leader.repository');
});
