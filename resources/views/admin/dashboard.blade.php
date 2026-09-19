@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-10 mt-6 px-4">
    <!-- Header Section -->
    <div class="mb-10">
        <h1 class="text-3xl font-serif font-bold text-[#4a1c1c] mb-2">Selamat Datang, Admin</h1>
        <p class="text-gray-600 text-sm">Ikhtisar sistem manajemen arsip dan aktivitas museum hari ini.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Statistik Pengunjung -->
        <div class="lg:col-span-2 border border-gray-100 rounded-xl p-8 bg-white shadow-sm">
            <h3 class="text-xl font-serif font-bold text-[#5c1c16] mb-8">Statistik Frekuensi Login</h3>
            
            <div class="bg-[#fdfaf5] py-8 rounded flex flex-col justify-between">
                <!-- Data bars -->
                <div class="flex items-end justify-around px-4 h-40">
                    @if(empty($stats))
                        <div class="w-full h-full flex items-center justify-center text-sm font-medium text-gray-400">
                            Belum ada riwayat login pengguna.
                        </div>
                    @else
                        @php
                            $maxCount = collect($stats)->max('count') ?: 1;
                        @endphp
                        @foreach($stats as $stat)
                        <div class="flex flex-col items-center justify-end w-24">
                            <span class="text-[10px] text-gray-500 font-medium mb-1">{{ $stat['count'] }} kali</span>
                            <!-- Bar Chart Visual -->
                            <div class="w-12 bg-[#8b1c1c] rounded-t-sm transition-all duration-500 opacity-80 hover:opacity-100" style="height: {{ ($stat['count'] / $maxCount) * 100 }}px;"></div>
                            <span class="text-[10px] font-bold text-gray-800 mt-2 text-center leading-tight">{{ $stat['label'] }}</span>
                        </div>
                        @endforeach
                    @endif
                </div>
                
                <div class="text-center text-[11px] font-bold text-[#8b1c1c] mt-8">
                    Staf Teraktif (Berdasarkan Jumlah Login)
                </div>
            </div>
        </div>

        <!-- Tindakan Cepat -->
        <div class="lg:col-span-1 bg-[#fdfaf5] border border-orange-100 rounded-xl p-8 shadow-sm flex flex-col">
            <h3 class="text-xl font-serif font-bold text-[#5c1c16] mb-8">Tindakan Cepat</h3>
            
            <a href="{{ route('admin.roles') }}" class="w-full py-3 bg-[#4a1c1c] text-white text-sm font-semibold rounded flex items-center justify-center gap-2 hover:bg-[#3a1515] transition mb-4 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Tambah Pengguna Baru
            </a>
            
            <a href="{{ route('admin.log.export') }}" target="_blank" class="w-full py-3 bg-white border border-gray-300 text-[#4a1c1c] text-sm font-semibold rounded flex items-center justify-center gap-2 hover:bg-gray-50 transition mb-auto shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Ekspor Log Audit
            </a>
            
            <div class="mt-8 text-center border-t border-gray-200 pt-4">
                <a href="{{ route('admin.users') }}" class="text-[10px] font-bold text-gray-500 uppercase tracking-wider hover:text-gray-800 transition">
                    Lihat Semua Tindakan
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik Harian (Bulan Ini) -->
    <div class="border border-gray-100 rounded-xl p-8 bg-white shadow-sm mb-8">
        <h3 class="text-xl font-serif font-bold text-[#5c1c16] mb-6">Kunjungan Login Staf (30 Hari Terakhir)</h3>
        <div class="w-full h-64">
            <canvas id="dailyLoginChart"></canvas>
        </div>
    </div>

    <!-- Log Aktivitas Terbaru -->
    <div class="border border-gray-100 rounded-xl p-8 bg-white shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-serif font-bold text-[#5c1c16]">Log Aktivitas Terbaru</h3>
            <a href="#" class="text-[11px] font-bold text-gray-900 uppercase tracking-widest hover:underline">Lihat Semua</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[600px]">
                <thead>
                    <tr class="bg-[#fdfaf5] text-[10px] font-bold text-gray-500 uppercase tracking-widest border-b border-gray-100">
                        <th class="py-4 px-4 w-1/4">Waktu</th>
                        <th class="py-4 px-4 w-1/4">Pengguna</th>
                        <th class="py-4 px-4 w-1/4">Aksi</th>
                        <th class="py-4 px-4 w-1/4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-4 text-gray-500">
                            @if($log->created_at->isToday())
                                Hari ini, {{ $log->created_at->format('H:i') }}
                            @else
                                {{ $log->created_at->format('d M Y, H:i') }}
                            @endif
                        </td>
                        <td class="py-4 px-4 font-bold text-gray-800">{{ $log->nama_pengguna }}</td>
                        <td class="py-4 px-4 text-gray-600">{{ $log->aksi }}</td>
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex px-3 py-1 text-[10px] font-bold rounded-full {{ $log->status == 'Berhasil' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                {{ $log->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-400 font-medium">Belum ada aktivitas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dailyStats = @json($dailyStats);
    const labels = dailyStats.map(stat => stat.date);
    const data = dailyStats.map(stat => stat.count);

    const ctx = document.getElementById('dailyLoginChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Login',
                data: data,
                borderColor: '#8b1c1c',
                backgroundColor: 'rgba(139, 28, 28, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#8b1c1c'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
});
</script>
@endpush
