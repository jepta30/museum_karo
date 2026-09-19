@extends('layouts.app')
@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4 text-center font-serif text-[#8b1c1c]">Laporan Buku Tamu Pengunjung</h1>
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.laporan.pengunjung.export') }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
            Export PDF
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-400">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border border-gray-400">Tanggal Kunjungan</th>
                    <th class="px-4 py-2 border border-gray-400">Nama Pengunjung</th>
                    <th class="px-4 py-2 border border-gray-400">Alamat</th>
                    <th class="px-4 py-2 border border-gray-400">Pekerjaan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengunjungs as $item)
                <tr>
                    <td class="px-4 py-2 border border-gray-400 text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td class="px-4 py-2 border border-gray-400">{{ $item->nama }}</td>
                    <td class="px-4 py-2 border border-gray-400">{{ $item->alamat ?? '-' }}</td>
                    <td class="px-4 py-2 border border-gray-400">{{ $item->pekerjaan ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-4 py-2 border border-gray-400 text-center text-gray-500">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $pengunjungs->links() }}</div>
</div>
@endsection
