@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-10">
    <div class="mb-8">
        <h1 class="text-2xl font-serif font-bold text-gray-900 mb-2">Komentar Pengunjung</h1>
        <p class="text-sm text-gray-500">Tinjau dan setujui komentar yang dikirimkan pengunjung sebelum ditampilkan di halaman publik.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($komentars->isEmpty())
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <p class="text-gray-500 font-medium">Tidak ada komentar baru yang menunggu persetujuan.</p>
            </div>
        @else
            <div class="divide-y divide-gray-100">
                @foreach($komentars as $komentar)
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex flex-col md:flex-row gap-6 justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="font-bold text-gray-900">{{ $komentar->nama }}</h3>
                                    @if($komentar->email)
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $komentar->email }}</span>
                                    @endif
                                    <span class="text-xs text-gray-400">&bull; {{ $komentar->created_at->diffForHumans() }}</span>
                                </div>
                                
                                <p class="text-xs font-bold text-museum-red uppercase tracking-wider mb-2">Di Koleksi: {{ $komentar->koleksi->nama_sementara }}</p>
                                
                                <p class="text-sm text-gray-700 bg-white p-4 border border-gray-200 rounded-md shadow-sm">
                                    {{ $komentar->isi_komentar }}
                                </p>
                            </div>
                            
                            <div class="flex gap-2 w-full md:w-auto mt-4 md:mt-0 shrink-0">
                                <form action="{{ route('curator.komentar.approve', $komentar->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full md:w-auto px-4 py-2 bg-green-600 text-white text-xs font-bold uppercase tracking-wider rounded hover:bg-green-700 transition flex items-center justify-center gap-2 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('curator.komentar.reject', $komentar->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak dan menghapus komentar ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full md:w-auto px-4 py-2 bg-white border border-red-300 text-red-600 text-xs font-bold uppercase tracking-wider rounded hover:bg-red-50 transition flex items-center justify-center gap-2 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
