<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CuratorController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    
    // Redirect otomatis berdasarkan peran
    Route::get('/', function () {
        $peran = Auth::user()->peran;
        if ($peran === 'kurator') return redirect()->route('curator.dashboard');
        if ($peran === 'pimpinan') return redirect('/leader'); // Placeholder
        if ($peran === 'edukator') return redirect('/educator'); // Placeholder
        return redirect()->route('registrar.dashboard');
    });

    // Rute Registrar
    Route::get('/registrar', [RegistrarController::class, 'index'])->name('registrar.dashboard');
    Route::post('/collections', [RegistrarController::class, 'store']);

    // Rute Kurator
    Route::get('/curator', [CuratorController::class, 'index'])->name('curator.dashboard');
    Route::post('/curator/collections/{id}', [CuratorController::class, 'update'])->name('curator.update');
});
