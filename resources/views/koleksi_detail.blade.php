<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $modul->judul }} - Museum Pusaka Karo</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#fdfbf9] text-gray-800 antialiased font-sans flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white px-6 py-4 flex items-center justify-between shadow-sm relative z-50">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10" onerror="this.style.display='none'">
            <div class="hidden sm:block">
                <h1 class="text-[#8b1c1c] font-serif font-bold text-lg leading-tight">Sistem Informasi Warisan<br>Budaya Karo</h1>
                <p class="text-xs text-gray-500 uppercase tracking-widest mt-0.5">Museum Pusaka Karo</p>
            </div>
        </div>
        
        <div class="flex items-center gap-6 text-sm font-semibold text-gray-700">
            <div class="hidden lg:flex items-center gap-6">
                <a href="{{ route('home') }}" class="hover:text-[#8b1c1c] transition">Beranda</a>
                <a href="#" class="bg-[#8b1c1c] text-white px-5 py-2 rounded-full shadow-md">Katalog Koleksi</a>
                <a href="{{ route('home') }}#peta" class="hover:text-[#8b1c1c] transition">Peta Titik Asal</a>
                <a href="#" class="hover:text-[#8b1c1c] transition">Tentang Kami</a>
            </div>
            
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 hover:text-[#8b1c1c] text-[#8b1c1c] transition ml-2 lg:ml-4 font-bold border border-[#8b1c1c] px-4 py-2 rounded">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-2 hover:text-[#8b1c1c] text-gray-600 transition ml-2 lg:ml-4 font-bold border border-gray-300 px-4 py-2 rounded">
                        Login Admin
                    </a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-6 lg:px-12 py-10">
        
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-gray-900 mb-3">{{ $modul->judul }}</h1>
            <div class="flex items-center gap-1.5 text-gray-500 text-sm font-medium">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                Museum Pusaka Karo
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Left: Image -->
            <div class="lg:col-span-2 bg-[#f4f7fa] rounded-xl overflow-hidden flex items-center justify-center p-8 border border-gray-100 shadow-inner min-h-[400px]">
                @if($koleksi && $koleksi->path_foto)
                    <img src="{{ Storage::url($koleksi->path_foto) }}" alt="{{ $modul->judul }}" class="max-w-full max-h-[600px] object-contain shadow-lg">
                @else
                    <div class="text-gray-400 flex flex-col items-center">
                        <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                        <p class="font-medium">Foto Koleksi Belum Tersedia</p>
                    </div>
                @endif
            </div>

            <!-- Right: Info Box -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm h-full flex flex-col">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Informasi Utama</h2>
                    
                    <div class="flex-grow space-y-5">
                        <div class="flex justify-between items-center border-b border-dashed border-gray-200 pb-4">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Jenis Koleksi</span>
                            <span class="text-sm font-bold text-gray-900 uppercase text-right">{{ $koleksi && $koleksi->kategori ? $koleksi->kategori->nama_kategori : '-' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center border-b border-dashed border-gray-200 pb-4">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Nama Pemilik/Penitip</span>
                            <span class="text-sm font-bold text-gray-900 text-right">{{ $koleksi->nama_penyerah ?? 'Tidak Diketahui' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center border-b border-dashed border-gray-200 pb-4">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Lokasi</span>
                            <span class="text-sm font-bold text-gray-900 text-right">Museum Pusaka Karo</span>
                        </div>
                        
                        <div class="flex justify-between items-center border-b border-dashed border-gray-200 pb-4">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Asal</span>
                            @php
                                // Attempt to parse a city or specific location from alamat_penyerah
                                $asal = 'Tidak Diketahui';
                                if ($koleksi->tempat_lahir_penyerah) {
                                    $asal = $koleksi->tempat_lahir_penyerah;
                                } elseif ($koleksi->alamat_penyerah) {
                                    $parts = explode(',', $koleksi->alamat_penyerah);
                                    $asal = trim(end($parts));
                                }
                            @endphp
                            <span class="text-sm font-bold text-gray-900 text-right">{{ $asal }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center border-b border-dashed border-gray-200 pb-4">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status Fisik</span>
                            <span class="text-[10px] font-bold text-gray-700 bg-gray-100 px-3 py-1 rounded uppercase tracking-wider">{{ $koleksi->kondisi_awal ?? 'TIDAK DIKETAHUI' }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <a href="#" class="block w-full py-3.5 bg-black text-white text-center text-xs font-bold uppercase tracking-wider rounded hover:bg-gray-800 transition">
                            Rencanakan Kunjungan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-8 flex gap-8 px-2 overflow-x-auto" id="tab-buttons">
            <button onclick="switchTab('deskripsi')" id="btn-deskripsi" class="tab-btn pb-4 text-sm font-bold text-gray-900 border-b-2 border-[#8b1c1c] uppercase tracking-wider whitespace-nowrap">Deskripsi</button>
            <button onclick="switchTab('sejarah')" id="btn-sejarah" class="tab-btn pb-4 text-sm font-bold text-gray-400 hover:text-gray-700 uppercase tracking-wider whitespace-nowrap border-b-2 border-transparent">Sejarah</button>
            <button onclick="switchTab('galeri')" id="btn-galeri" class="tab-btn pb-4 text-sm font-bold text-gray-400 hover:text-gray-700 uppercase tracking-wider whitespace-nowrap border-b-2 border-transparent">Galeri</button>
            <button onclick="switchTab('komentar')" id="btn-komentar" class="tab-btn pb-4 text-sm font-bold text-gray-400 hover:text-gray-700 uppercase tracking-wider whitespace-nowrap border-b-2 border-transparent">Komentar</button>
        </div>

        <!-- Content Area -->
        <div class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm text-gray-700 leading-relaxed max-w-4xl min-h-[200px]">
            <!-- Deskripsi Content -->
            <div id="content-deskripsi" class="tab-content">
                @if($deskripsi_umum)
                    {!! nl2br(e($deskripsi_umum)) !!}
                @else
                    <p class="text-gray-400 italic">Belum ada deskripsi yang ditambahkan untuk koleksi ini.</p>
                @endif
            </div>

            <!-- Sejarah Content -->
            <div id="content-sejarah" class="tab-content hidden">
                @if($sejarah_makna)
                    {!! nl2br(e($sejarah_makna)) !!}
                @elseif($koleksi && $koleksi->sejarah_asal_usul)
                    {!! nl2br(e($koleksi->sejarah_asal_usul)) !!}
                @else
                    <p class="text-gray-400 italic">Belum ada data sejarah yang ditambahkan untuk koleksi ini.</p>
                @endif
            </div>

            <!-- Galeri Content -->
            <div id="content-galeri" class="tab-content hidden">
                <p class="text-gray-400 italic">Galeri foto belum tersedia.</p>
            </div>

            <!-- Komentar Content -->
            <div id="content-komentar" class="tab-content hidden space-y-8">
                
                @if(session('success_komentar'))
                    <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-md text-sm mb-6 font-medium">
                        {{ session('success_komentar') }}
                    </div>
                @endif

                @if($komentars->isEmpty())
                    <p class="text-gray-500 italic mb-6">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                @else
                    <div class="space-y-6 mb-8">
                        @foreach($komentars as $komentar)
                            <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                                <h4 class="font-bold text-gray-900">{{ $komentar->nama }}</h4>
                                <span class="text-xs text-gray-400">{{ $komentar->created_at->diffForHumans() }}</span>
                                <p class="text-sm text-gray-700 mt-2">{{ $komentar->isi_komentar }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="bg-[#fcfcfc] border border-gray-200 p-8 rounded-xl shadow-sm">
                    <h3 class="text-xl font-serif font-bold text-gray-900 mb-6">Tinggalkan Jejak / Pertanyaan</h3>
                    
                    <form action="{{ route('koleksi.komentar', $modul->id) }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2">Nama Anda *</label>
                                <input type="text" name="nama" required placeholder="Cth: Budi Tarigan" class="w-full px-4 py-2 border border-gray-300 rounded text-sm focus:ring-[#8b1c1c] focus:border-[#8b1c1c]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2">Email (Opsional)</label>
                                <input type="email" name="email" placeholder="Tidak akan dipublikasikan" class="w-full px-4 py-2 border border-gray-300 rounded text-sm focus:ring-[#8b1c1c] focus:border-[#8b1c1c]">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Isi Komentar *</label>
                            <textarea name="isi_komentar" required rows="4" placeholder="Tulis pendapat atau kenangan Anda tentang budaya ini..." class="w-full px-4 py-3 border border-gray-300 rounded text-sm focus:ring-[#8b1c1c] focus:border-[#8b1c1c] resize-y"></textarea>
                        </div>
                        
                        <button type="submit" class="px-6 py-2.5 bg-[#8b1c1c] text-white text-sm font-semibold rounded hover:bg-red-800 transition shadow-sm">
                            Kirim Komentar
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-20 py-10">
        <div class="container mx-auto px-6 lg:px-12 text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Sistem Informasi Warisan Budaya Karo - Museum Pusaka Karo. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script>
        function switchTab(tabId) {
            // Hide all contents
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.add('hidden');
            });
            // Show target content
            document.getElementById('content-' + tabId).classList.remove('hidden');

            // Reset all buttons styles
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('text-gray-900', 'border-[#8b1c1c]');
                btn.classList.add('text-gray-400', 'border-transparent');
            });

            // Set active button style
            const activeBtn = document.getElementById('btn-' + tabId);
            activeBtn.classList.remove('text-gray-400', 'border-transparent');
            activeBtn.classList.add('text-gray-900', 'border-[#8b1c1c]');
        }
    </script>
</body>
</html>
