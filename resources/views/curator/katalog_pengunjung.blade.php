@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <a href="#" class="text-sm text-gray-500 hover:text-gray-800 flex items-center gap-2 mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Pusat Laporan
            </a>
            <h1 class="text-3xl font-serif font-bold text-gray-900 mb-1">Statistik Kunjungan Website</h1>
            <p class="text-sm text-gray-500">Data kunjungan situs tercatat otomatis setiap ada pengunjung membuka halaman publik.</p>
        </div>
        <div class="flex gap-3">
            <button class="px-4 py-2 border border-gray-300 bg-white text-gray-700 text-sm font-bold rounded shadow-sm hover:bg-gray-50 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Unduh CSV
            </button>
            <button class="px-4 py-2 border border-gray-300 bg-white text-gray-700 text-sm font-bold rounded shadow-sm hover:bg-gray-50 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Unduh PDF
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
        <!-- Left: Total Kunjungan -->
        <div class="lg:col-span-2 bg-[#fdfaf5] border border-orange-100 rounded-xl p-6">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-xs font-bold text-gray-600 tracking-wider uppercase">Total Kunjungan Halaman</h3>
                <select class="text-xs font-medium border-gray-300 rounded shadow-sm focus:ring-[#8b1c1c] focus:border-[#8b1c1c] bg-white text-gray-700 py-1 pl-3 pr-8">
                    <option>Bulanan</option>
                    <option>Mingguan</option>
                </select>
            </div>
            
            <div class="mb-8">
                <span class="text-5xl font-bold text-[#62231c]">{{ $totalKunjungan }}</span>
            </div>

            <h4 class="text-xs font-bold text-gray-700 tracking-wider mb-4">Tren Kunjungan Harian</h4>
            
            <div class="space-y-3">
                @php
                    $maxViews = $trenKunjungan->max('views') ?: 1;
                @endphp
                @forelse($trenKunjungan as $tren)
                    <div class="flex items-center gap-4 text-xs font-medium text-gray-600">
                        <span class="w-24">{{ \Carbon\Carbon::parse($tren->date)->format('d M Y') }}</span>
                        <div class="flex-1 bg-orange-50 h-3 rounded-full overflow-hidden">
                            <div class="bg-[#59231c] h-full rounded-full" style="width: {{ ($tren->views / $maxViews) * 100 }}%"></div>
                        </div>
                        <span class="w-8 text-right font-bold text-gray-900">{{ $tren->views }}</span>
                    </div>
                @empty
                    <p class="text-gray-400 italic text-sm">Belum ada data kunjungan.</p>
                @endforelse
            </div>
        </div>

        <!-- Right: Small Cards -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Jenis Perangkat -->
            <div class="bg-[#fdfaf5] border border-orange-100 rounded-xl p-6">
                <h3 class="text-xs font-bold text-gray-800 tracking-wider mb-5">Jenis Perangkat</h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-medium text-gray-600 mb-1.5">
                            <span>Desktop</span>
                            <span class="font-bold text-gray-900">{{ $desktopCount }}</span>
                        </div>
                        <div class="w-full bg-orange-50 h-2 rounded-full overflow-hidden">
                            <div class="bg-[#59231c] h-full" style="width: {{ $totalKunjungan > 0 ? ($desktopCount / $totalKunjungan) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-medium text-gray-600 mb-1.5">
                            <span>Mobile</span>
                            <span class="font-bold text-gray-900">{{ $mobileCount }}</span>
                        </div>
                        <div class="w-full bg-orange-50 h-2 rounded-full overflow-hidden">
                            <div class="bg-[#59231c] h-full" style="width: {{ $totalKunjungan > 0 ? ($mobileCount / $totalKunjungan) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Koleksi -->
            <div class="bg-[#fdfaf5] border border-orange-100 rounded-xl p-6">
                <h3 class="text-xs font-bold text-gray-800 tracking-wider mb-5">Koleksi Budaya Terpopuler</h3>
                
                <div class="space-y-3">
                    @forelse($topKoleksi as $tk)
                        <div class="flex justify-between items-center text-xs border-b border-orange-100 pb-2 last:border-0 last:pb-0">
                            <span class="font-medium text-gray-600 uppercase truncate pr-2">{{ $tk['nama'] }}</span>
                            <span class="font-bold text-gray-900 shrink-0">{{ $tk['views'] }}x</span>
                        </div>
                    @empty
                        <p class="text-gray-400 italic text-sm">Belum ada data.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Buku Tamu Section -->
    <div class="mb-6">
        <h2 class="text-3xl font-serif font-bold text-gray-900 mb-2">Buku Tamu Pengunjung</h2>
        <p class="text-sm text-gray-600">Catat, pantau, dan buat laporan kunjungan fisik pengunjung Museum Pusaka Karo. Semua entri disimpan di database dan bisa diekspor sebagai CSV.</p>
    </div>

    <!-- Helper Box -->
    <div class="bg-[#fdfaf5] border border-orange-100 rounded-lg p-4 mb-6 flex flex-col md:flex-row md:items-center text-xs text-gray-700 divide-y md:divide-y-0 md:divide-x divide-orange-100">
        <div class="flex items-center gap-3 pr-6 py-2 md:py-0 font-medium">
            <svg class="w-4 h-4 text-orange-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Gunakan tombol</span>
        </div>
        <div class="flex items-center gap-3 px-0 md:px-6 py-2 md:py-0 font-medium">
            <span class="font-bold text-black">Catat Kunjungan</span>
            <span>untuk mencatat kunjungan manual, atau minta pengunjung membuka</span>
        </div>
        <div class="flex items-center gap-3 px-0 md:px-6 py-2 md:py-0 font-medium">
            <span class="font-bold text-black">Halaman Utama</span>
            <span>untuk mengisi otomatis.</span>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="bg-[#fdfaf5] border border-orange-100 rounded-lg p-4 mb-6 flex flex-col md:flex-row gap-4 items-center">
        <button onclick="document.getElementById('modal-catat').classList.remove('hidden')" class="w-full md:w-auto px-4 py-2.5 bg-[#59231c] text-white text-xs font-bold rounded flex items-center justify-center gap-2 hover:bg-red-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Catat Kunjungan
        </button>
        
        <form action="{{ route('curator.katalog') }}" method="GET" class="flex-1 flex flex-col md:flex-row gap-4 w-full">
            <div class="relative flex-1">
                <svg class="w-4 h-4 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / alamat / pekerjaan..." class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded focus:border-[#8b1c1c] focus:ring-[#8b1c1c]">
            </div>
            <div class="w-full md:w-48">
                <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()" class="w-full px-4 py-2 text-sm border border-gray-200 rounded text-gray-600 focus:border-[#8b1c1c] focus:ring-[#8b1c1c]">
            </div>
            <button type="submit" class="hidden">Submit</button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-[#fdfaf5] border border-orange-100 rounded-xl overflow-hidden">
        <table class="w-full text-left text-sm text-gray-700">
            <thead class="text-[10px] font-bold text-gray-500 uppercase tracking-wider border-b border-orange-100">
                <tr>
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">Alamat</th>
                    <th class="px-6 py-4">Pekerjaan</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-orange-100/50 text-xs font-medium">
                @forelse($bukuTamu as $index => $tamu)
                <tr class="hover:bg-orange-50 transition">
                    <td class="px-6 py-4 text-[#8b1c1c] font-bold">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-gray-900 font-bold">{{ $tamu->nama }}</td>
                    <td class="px-6 py-4">{{ $tamu->alamat ?? '-' }}</td>
                    <td class="px-6 py-4 uppercase text-gray-500">{{ $tamu->pekerjaan ?? '-' }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($tamu->tanggal)->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('curator.katalog.delete', $tamu->id) }}" method="POST" onsubmit="return confirm('Hapus data pengunjung ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400 font-medium">Belum ada data pengunjung.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- Modal Catat Kunjungan -->
<div id="modal-catat" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-900">Catat Kunjungan Baru</h3>
            <button onclick="document.getElementById('modal-catat').classList.add('hidden')" class="text-gray-400 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('curator.katalog.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Nama Pengunjung *</label>
                <input type="text" name="nama" required class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:border-[#8b1c1c] focus:ring-[#8b1c1c]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Alamat (Opsional)</label>
                <input type="text" name="alamat" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:border-[#8b1c1c] focus:ring-[#8b1c1c]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Pekerjaan (Opsional)</label>
                <input type="text" name="pekerjaan" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:border-[#8b1c1c] focus:ring-[#8b1c1c]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal *</label>
                <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:border-[#8b1c1c] focus:ring-[#8b1c1c]">
            </div>
            <div class="pt-4 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modal-catat').classList.add('hidden')" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-semibold rounded hover:bg-gray-50 transition">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#8b1c1c] text-white text-sm font-semibold rounded hover:bg-red-800 transition">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
