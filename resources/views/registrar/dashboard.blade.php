@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    
    <!-- Header Halaman -->
    <div class="mb-8 border-b-2 border-museum-red pb-4 inline-block">
        <h1 class="text-3xl font-serif font-bold text-gray-900 mb-1">Pendaftar - Pendataan Awal</h1>
        <p class="text-gray-600 text-sm">Catat kedatangan baru dan pantau status pemrosesan data mentah.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- KOLOM KIRI (Form Entri) -->
        <div class="lg:col-span-2 bg-white rounded-md shadow-sm border border-gray-200">
            <!-- Aksen Garis Merah di atas Form -->
            <div class="h-1 w-full bg-museum-red rounded-t-md"></div>
            
            <div class="p-6 lg:p-8">
                <h3 class="text-xl font-serif text-gray-800 flex items-center gap-3 mb-8">
                    <span class="flex items-center justify-center w-6 h-6 rounded-full border border-museum-red text-museum-red font-bold text-lg leading-none pt-0.5 pb-1">+</span> 
                    Entri Kedatangan Baru
                </h3>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="/collections" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <!-- Area Upload -->
                    <div id="photo-upload-container" class="border-2 border-dashed border-red-200 bg-red-50/50 rounded-md p-10 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-red-50 transition mb-4 relative">
                        <input id="photo-upload-input" type="file" name="photo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required accept="image/*">
                        <svg class="w-8 h-8 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p id="photo-upload-text" class="text-sm font-semibold text-gray-800">Unggah Gambar Utama koleksi</p>
                        <p class="text-xs text-gray-500 mt-1">JPEG atau PNG resolusi tinggi, maks 10MB</p>
                    </div>

                    <!-- Input Nama -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama koleksi (Sementara)</label>
                        <input type="text" name="nama_sementara" required placeholder="cth., Gagang Piso Surit Kayu" class="w-full p-2.5 border border-gray-200 rounded text-sm bg-gray-50 focus:bg-white focus:outline-none focus:border-museum-red focus:ring-1 focus:ring-museum-red transition">
                    </div>

                    <!-- Jenis Koleksi -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori Koleksi</label>
                        <select name="kategori_id" required class="w-full p-2.5 border border-gray-200 rounded text-sm bg-gray-50 focus:bg-white focus:outline-none focus:border-museum-red focus:ring-1 focus:ring-museum-red transition appearance-none text-gray-600">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nama Sumber -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Penyerah / Donatur</label>
                        <input type="text" name="nama_penyerah" required placeholder="Masukkan nama atau institusi" class="w-full p-2.5 border border-gray-200 rounded text-sm bg-gray-50 focus:bg-white focus:outline-none focus:border-museum-red focus:ring-1 focus:ring-museum-red transition">
                    </div>

                    <!-- Tanggal Akuisisi -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Terima</label>
                        <input type="date" name="tanggal_terima" required class="w-1/2 p-2.5 border border-gray-200 rounded text-sm bg-gray-50 focus:bg-white focus:outline-none focus:border-museum-red focus:ring-1 focus:ring-museum-red transition text-gray-500">
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kondisi Awal</label>
                        <textarea name="kondisi_awal" rows="3" placeholder="Jelaskan secara singkat kerusakan yang terlihat atau karakteristik penting..." class="w-full p-2.5 border border-gray-200 rounded text-sm bg-gray-50 focus:bg-white focus:outline-none focus:border-museum-red focus:ring-1 focus:ring-museum-red transition"></textarea>
                    </div>

                    <!-- Tombol Form -->
                    <div class="flex justify-end gap-3 pt-6">
                        <button type="reset" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 transition">Bersihkan</button>
                        <button type="submit" class="px-6 py-2 bg-gray-100 text-gray-900 border border-gray-200 rounded-md text-sm font-semibold hover:bg-gray-200 transition">Simpan Entri</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- KOLOM KANAN (Status & Info) -->
        <div class="space-y-6">
            
            <!-- Panel Status -->
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-serif text-lg text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Status Pemrosesan
                    </h3>
                    <a href="#" class="text-xs text-museum-red hover:underline font-semibold text-right leading-tight tracking-wide uppercase">Lihat<br>Semua</a>
                </div>

                <!-- Tabel Mini Status -->
                <div class="text-sm">
                    <div class="grid grid-cols-4 gap-2 text-gray-400 mb-4 pb-2 border-b border-gray-100 text-xs font-semibold uppercase tracking-wider">
                        <div class="col-span-1">no regis</div>
                        <div class="col-span-2">koleksi</div>
                        <div class="col-span-1 text-right">Status</div>
                    </div>
                    
                    @forelse($collections as $col)
                    <div class="grid grid-cols-4 gap-2 items-center mb-5">
                        <div class="col-span-1 text-gray-400 text-[11px] font-medium tracking-wide">#ARR-<br>{{ str_pad($col->id, 3, '0', STR_PAD_LEFT) }}</div>
                        <div class="col-span-2 text-gray-800 text-sm font-medium leading-tight">{{ $col->nama_sementara }}</div>
                        <div class="col-span-1 text-right">
                            @if($col->status == 'menunggu_kurasi')
                                <span class="inline-block px-2.5 py-1 bg-[#f5ebe6] text-[#785b4a] rounded-full text-[10px] font-semibold text-center leading-tight">Menunggu<br>Kurator</span>
                            @elseif($col->status == 'menunggu_persetujuan')
                                <span class="inline-block px-2.5 py-1 bg-[#ecdce0] text-[#86515c] rounded-full text-[10px] font-semibold text-center leading-tight">Dalam<br>Tinjauan</span>
                            @else
                                <span class="inline-block px-2.5 py-1.5 bg-gray-100 text-gray-600 rounded-full text-[10px] font-semibold text-center leading-tight">Selesai</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-gray-400 text-xs text-center py-4">Belum ada koleksi yang dicatat.</div>
                    @endforelse
                </div>
            </div>

            <!-- Panel Kedatangan Minggu Ini (Hitam) -->
            <div class="bg-black text-white rounded-md p-6 relative overflow-hidden shadow-md h-32 flex flex-col justify-center">
                <h4 class="text-xs text-gray-400 mb-2 font-semibold tracking-wider">Kedatangan Minggu Ini</h4>
                <div class="flex items-baseline gap-3 z-10 relative">
                    <span class="text-5xl font-serif font-bold">{{ $weeklyCount }}</span>
                    <span class="text-[11px] text-gray-400 font-medium">artefak baru</span>
                </div>
                <!-- Elemen Box transparan di background -->
                <div class="absolute -right-4 -bottom-6 opacity-20 text-gray-300">
                    <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('photo-upload-input');
    const container = document.getElementById('photo-upload-container');
    const textElement = document.getElementById('photo-upload-text');

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Tampilkan nama file yang dipilih
                textElement.textContent = 'File terpilih: ' + file.name;
                textElement.classList.add('text-green-700');
                
                // Ubah gaya border kotak menjadi hijau
                container.classList.remove('border-red-200', 'bg-red-50/50');
                container.classList.add('border-green-400', 'bg-green-50');
            } else {
                // Kembalikan ke state awal jika dibatalkan
                textElement.textContent = 'Unggah Gambar Utama koleksi';
                textElement.classList.remove('text-green-700');
                
                container.classList.add('border-red-200', 'bg-red-50/50');
                container.classList.remove('border-green-400', 'bg-green-50');
            }
        });
    }
});
</script>
@endsection
