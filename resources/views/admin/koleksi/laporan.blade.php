@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4 text-center font-serif text-[#8b1c1c]">Induk Inventaris Benda Koleksi Museum Pusaka Karo {{ date('Y') }}</h1>
    <div class="flex justify-end mb-4 gap-2">
        <a href="{{ route('admin.koleksi.laporan.export', ['type' => 'pdf']) }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
            Export PDF
        </a>
        <a href="{{ route('admin.koleksi.laporan.export', ['type' => 'csv']) }}" class="bg-[#8b1c1c] text-white px-4 py-2 rounded-md hover:bg-[#6a1515] transition">
            Export CSV
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-400">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border border-gray-400 text-center font-bold">Nomor Koleksi</th>
                    <th class="px-4 py-2 border border-gray-400 text-center font-bold">Nama Koleksi</th>
                    <th class="px-4 py-2 border border-gray-400 text-center font-bold">Jenis Koleksi</th>
                    <th class="px-4 py-2 border border-gray-400 text-center font-bold">Nama Penghibah/Penitip</th>
                    <th class="px-4 py-2 border border-gray-400 text-center font-bold">Cara Perolehan</th>
                    <th class="px-4 py-2 border border-gray-400 text-center font-bold">Tempat Perolehan</th>
                    <th class="px-4 py-2 border border-gray-400 text-center font-bold">Tanggal masuk</th>
                    <th class="px-4 py-2 border border-gray-400 text-center font-bold">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($koleksi as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2 border border-gray-400 text-center">{{ $item->nomor_inventaris_final }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->nama_sementara }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->kategori->nama ?? '' }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->nama_penyerah }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->klaim_asal_usul ?? '-' }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->alamat_penyerah }}</td>
                        <td class="px-4 py-2 border border-gray-400 text-center">{{ \Carbon\Carbon::parse($item->tanggal_terima)->format('Y-m-d') }}</td>
                        <td class="px-4 py-2 border border-gray-400">{{ $item->kondisi_awal }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-2 border border-gray-400 text-center text-gray-500">Tidak ada koleksi yang dipublikasikan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $koleksi->links() }}</div>
</div>
@endsection
