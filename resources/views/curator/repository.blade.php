@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-10">
    
    <!-- HEADER -->
    <div class="mb-10">
        <h1 class="text-4xl md:text-5xl font-serif font-bold text-[#4a1b1b] mb-2">Repositori Institusi</h1>
        <p class="text-gray-600 font-medium">Penyimpanan pusat untuk dokumen legal, berita acara, dan arsip institusional resmi Museum Karo.</p>
    </div>

    <!-- 3 INFO CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Card 1 -->
        <div class="bg-[#fbf8f5] rounded-xl p-6 border border-[#f0e8df] relative overflow-hidden">
            <div class="flex items-center gap-2 mb-6 z-10 relative">
                <svg class="w-5 h-5 text-[#8b1c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                <p class="text-[11px] font-bold text-gray-600 uppercase tracking-widest">Total Dokumen Tersimpan</p>
            </div>
            <h2 class="text-5xl font-serif font-bold text-[#4a1b1b] z-10 relative">{{ number_format($totalDokumen) }}</h2>
            <!-- Dekorasi Kotak Kanan Atas -->
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#ece5dc] opacity-50 rounded-bl-3xl"></div>
        </div>

        <!-- Card 2 -->
        <div class="bg-[#fbf8f5] rounded-xl p-6 border border-[#f0e8df] relative overflow-hidden">
            <div class="flex items-center gap-2 mb-6 z-10 relative">
                <svg class="w-5 h-5 text-[#8b1c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-[11px] font-bold text-gray-600 uppercase tracking-widest">Dokumen Baru (Bulan Ini)</p>
            </div>
            <div class="flex items-end gap-3 z-10 relative">
                <h2 class="text-5xl font-serif font-bold text-[#4a1b1b] leading-none">{{ $beritaAcaraBaru }}</h2>
            </div>
            <!-- Dekorasi Kotak Kanan Atas -->
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#ece5dc] opacity-50 rounded-bl-3xl"></div>
        </div>

        <!-- Card 3 -->
        <div class="bg-[#fbf8f5] rounded-xl p-6 border border-[#f0e8df] relative overflow-hidden group">
            <div class="flex items-center gap-2 mb-6 z-10 relative cursor-help" title="Dokumen dikategorikan 'Aktif' jika berjenis Surat Keputusan (SK) atau Berita Acara yang tersimpan di sistem.">
                <svg class="w-5 h-5 text-[#8b1c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                <p class="text-[11px] font-bold text-gray-600 uppercase tracking-widest border-b border-dashed border-gray-400">Dokumen Legal Aktif</p>
                
                <!-- Tooltip Popup -->
                <div class="absolute top-8 left-0 w-64 bg-black text-white text-xs p-3 rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 shadow-xl z-20">
                    Dokumen dianggap <strong>Aktif</strong> jika dikategorikan sebagai <strong>Surat Keputusan</strong> atau <strong>Berita Acara</strong> yang masih berlaku di repositori ini.
                </div>
            </div>
            <h2 class="text-5xl font-serif font-bold text-[#4a1b1b] z-10 relative">{{ $dokumenAktif }}</h2>
            <!-- Dekorasi Kotak Kanan Atas -->
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#ece5dc] opacity-50 rounded-bl-3xl"></div>
        </div>
    </div>

    <!-- MAIN TABLE SECTION -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
        
        <!-- Filters Area -->
        <div class="p-6 border-b border-gray-100 flex flex-col lg:flex-row gap-4 items-center justify-between">
            <div class="flex items-center gap-4 w-full lg:w-1/2">
                <div class="relative w-full">
                    <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Cari dokumen legal, SK, atau berita acara..." class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded text-sm text-gray-700 focus:outline-none focus:border-[#4a1b1b] focus:ring-1 focus:ring-[#4a1b1b] transition">
                </div>
                <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="shrink-0 px-5 py-3 bg-[#8b1c1c] text-white text-sm font-bold rounded shadow-sm hover:bg-red-900 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Unggah Dokumen
                </button>
            </div>
            
            <div class="flex gap-3 w-full lg:w-auto">
                <select class="flex-1 lg:flex-none appearance-none px-4 py-3 bg-white border border-gray-200 rounded text-sm font-semibold text-gray-700 focus:outline-none pr-10 cursor-pointer" style="background-image: url('data:image/svg+xml;utf8,<svg fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' viewBox=\'0 0 24 24\' xmlns=\'http://www.w3.org/2000/svg\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M19 9l-7 7-7-7\'></path></svg>'); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px;">
                    <option>Semua Kategori</option>
                    <option>Berita Acara</option>
                    <option>Surat Keputusan</option>
                    <option>Laporan</option>
                </select>
                <select class="flex-1 lg:flex-none appearance-none px-4 py-3 bg-white border border-gray-200 rounded text-sm font-semibold text-gray-700 focus:outline-none pr-10 cursor-pointer" style="background-image: url('data:image/svg+xml;utf8,<svg fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' viewBox=\'0 0 24 24\' xmlns=\'http://www.w3.org/2000/svg\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M19 9l-7 7-7-7\'></path></svg>'); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px;">
                    <option>Tahun Ini</option>
                    <option>Tahun Lalu</option>
                </select>
                <button class="px-4 py-3 bg-white border border-gray-200 text-gray-700 font-semibold text-sm rounded hover:bg-gray-50 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filter Lainnya
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-white border-b border-gray-100">
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-700 uppercase tracking-widest w-2/5">Nama Dokumen</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-700 uppercase tracking-widest">Kategori</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-700 uppercase tracking-widest">Tanggal Unggah</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-700 uppercase tracking-widest">Ukuran</th>
                        <th class="py-4 px-6 text-[11px] font-bold text-gray-700 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($dokumenList as $doc)
                    <tr class="hover:bg-gray-50 transition group">
                        <td class="py-5 px-6 flex items-start gap-3">
                            <svg class="w-5 h-5 text-[#8b1c1c] mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <div>
                                <p class="font-bold text-[#4a1b1b] text-sm mb-0.5">{{ $doc->nama }}</p>
                                <p class="text-[11px] text-gray-400 font-medium">ID: {{ str_pad($doc->id, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <span class="inline-flex px-3 py-1 bg-[#ece5dc] text-gray-700 rounded-full text-[10px] font-bold">
                                {{ $doc->kategori }}
                            </span>
                        </td>
                        <td class="py-5 px-6 text-sm text-gray-600 font-medium">
                            {{ $doc->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td class="py-5 px-6 text-sm text-gray-600 font-medium">
                            {{ $doc->ukuran }}
                        </td>
                        <td class="py-5 px-6 text-right">
                            <a href="{{ Storage::url($doc->path_file) }}" download class="text-[#8b1c1c] font-bold text-xs hover:underline">Unduh</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500 font-medium">Belum ada dokumen repositori.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="border-t border-gray-100 p-4 px-6 bg-white">
            {{ $dokumenList->links() }}
        </div>

    </div>
</div>

<!-- Modal Upload -->
<div id="uploadModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-[#fbf8f5]">
            <h3 class="font-bold text-[#4a1b1b] text-lg">Unggah Dokumen Baru</h3>
            <button onclick="document.getElementById('uploadModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('curator.repository.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Dokumen <span class="text-red-500">*</span></label>
                <input type="text" name="nama" required class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-1 focus:ring-[#8b1c1c] focus:border-[#8b1c1c] text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="kategori" required class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-1 focus:ring-[#8b1c1c] focus:border-[#8b1c1c] text-sm">
                    <option value="Berita Acara">Berita Acara</option>
                    <option value="Surat Keputusan">Surat Keputusan</option>
                    <option value="Laporan">Laporan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">File Dokumen <span class="text-red-500">*</span></label>
                <input type="file" name="file_dokumen" required accept=".pdf,.doc,.docx,.xls,.xlsx" class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-1 focus:ring-[#8b1c1c] focus:border-[#8b1c1c] text-sm text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-bold file:bg-[#ece5dc] file:text-[#4a1b1b] hover:file:bg-[#e2d8cd]">
                <p class="text-[10px] text-gray-400 mt-1">Format didukung: PDF, DOCX, XLSX. Maksimal 20MB.</p>
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="px-4 py-2 text-sm font-bold text-gray-600 hover:bg-gray-100 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold bg-[#8b1c1c] text-white rounded hover:bg-red-900 shadow-sm">Unggah</button>
            </div>
        </form>
    </div>
</div>
@endsection
