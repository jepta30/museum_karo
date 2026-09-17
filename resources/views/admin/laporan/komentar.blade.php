@extends('layouts.app')
@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4 text-center font-serif text-[#8b1c1c]">Laporan Komentar Pengunjung</h1>
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.laporan.komentar.export') }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
            Export PDF
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-400">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border border-gray-400">Tanggal</th>
                    <th class="px-4 py-2 border border-gray-400">Nama</th>
                    <th class="px-4 py-2 border border-gray-400">Email</th>
                    <th class="px-4 py-2 border border-gray-400">Koleksi</th>
                    <th class="px-4 py-2 border border-gray-400">Komentar</th>
                    <th class="px-4 py-2 border border-gray-400">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($komentars as $item)
                <tr>
                    <td class="px-4 py-2 border border-gray-400 text-center">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                    <td class="px-4 py-2 border border-gray-400">{{ $item->nama }}</td>
                    <td class="px-4 py-2 border border-gray-400">{{ $item->email ?? '-' }}</td>
                    <td class="px-4 py-2 border border-gray-400">{{ $item->koleksi->nama_sementara ?? '-' }}</td>
                    <td class="px-4 py-2 border border-gray-400">{{ $item->isi_komentar }}</td>
                    <td class="px-4 py-2 border border-gray-400 text-center">{{ ucfirst($item->status) }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-2 border border-gray-400 text-center text-gray-500">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $komentars->links() }}</div>
</div>
@endsection
