@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto pb-10 mt-6 px-4">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-[#4a1c1c] mb-2">Log Aktivitas Sistem</h1>
            <p class="text-gray-600 text-sm">Rekam jejak seluruh aktivitas pengguna dalam sistem museum.</p>
        </div>
        <a href="{{ route('admin.logs.export') }}" class="px-4 py-2 bg-white border border-gray-300 text-[#4a1c1c] text-sm font-semibold rounded hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Ekspor (CSV)
        </a>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm min-h-[60vh]">
        <div class="relative border-l-2 border-orange-100 ml-4 space-y-8 pb-6">
            
            @forelse($logs as $index => $log)
            <div class="relative pl-8">
                @if($log->status === 'Ditandai')
                    <div class="absolute w-4 h-4 bg-red-600 rounded-full -left-[9px] top-1 border-[3px] border-white shadow-sm"></div>
                @else
                    <div class="absolute w-4 h-4 {{ $index === 0 && $logs->currentPage() === 1 ? 'bg-[#62231c]' : 'bg-gray-300' }} rounded-full -left-[9px] top-1 border-[3px] border-white shadow-sm"></div>
                @endif
                
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-1">
                    <span class="text-xs font-bold {{ $log->status === 'Ditandai' ? 'text-red-600' : 'text-gray-500' }} uppercase tracking-wider">
                        {{ $log->created_at->format('d M Y - H:i') }}
                    </span>
                    @if($log->status === 'Ditandai')
                        <span class="px-2 py-0.5 bg-red-100 text-red-700 text-[9px] font-bold uppercase rounded border border-red-200">Perhatian</span>
                    @endif
                </div>
                
                <div class="bg-gray-50 border border-gray-100 rounded-lg p-4 mt-2 hover:bg-white hover:border-gray-200 transition">
                    <p class="text-sm text-gray-800 leading-relaxed">
                        <strong class="text-[#4a1c1c] font-bold">{{ $log->nama_pengguna }}</strong> {{ $log->aksi }}
                    </p>
                    @if($log->status === 'Ditandai')
                        <div class="mt-2 text-xs text-red-600 flex items-center gap-1.5 font-medium bg-red-50 p-2 rounded border border-red-100 w-fit">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Sistem menandai aktivitas ini sebagai anomali atau gagal.
                        </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="relative pl-8">
                <div class="absolute w-4 h-4 bg-gray-300 rounded-full -left-[9px] top-1 border-[3px] border-white shadow-sm"></div>
                <div class="text-sm text-gray-500 italic mt-1 bg-gray-50 border border-gray-100 rounded-lg p-4 w-fit">Sistem belum mencatat riwayat aktivitas apapun.</div>
            </div>
            @endforelse

        </div>

        <div class="mt-8 border-t border-gray-100 pt-6">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
