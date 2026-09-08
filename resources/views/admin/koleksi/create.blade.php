@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto pb-10">
    <!-- Breadcrumb -->
    <div class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-museum-red">Dasbor Admin</a>
        <span class="mx-2">/</span>
        <a href="{{ route('admin.koleksi') }}" class="hover:text-museum-red">Koleksi Budaya</a>
        <span class="mx-2">/</span>
        <span class="text-gray-800 font-medium">Tambah Baru</span>
    </div>

    <div class="bg-[#fdfbf9] border border-[#f2ebe3] rounded-xl shadow-sm overflow-hidden">
        <div class="bg-white border-b border-[#f2ebe3] p-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-serif font-bold text-[#6d3e3e]">Tambah Koleksi Budaya</h1>
                <p class="text-sm text-gray-600 mt-1">Tambahkan koleksi budaya baru untuk dipublikasikan langsung ke pengunjung.</p>
            </div>
            <span class="px-3 py-1 bg-[#8b1c1c]/10 text-[#8b1c1c] rounded-full text-xs font-bold uppercase tracking-wider">Mode Admin (Bypass)</span>
        </div>

        @if($errors->any())
            <div class="p-6 bg-red-50 border-b border-red-100">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-400 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    <div class="text-sm text-red-700 font-medium">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.koleksi.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-5 bg-gray-50 border border-gray-200 rounded-lg">
                <!-- Nomor Koleksi (Manual) -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nomor Koleksi Budaya</label>
                    <input type="text" name="nomor_koleksi" required value="{{ old('nomor_koleksi') }}" placeholder="Contoh: INV/2026/001" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm font-medium bg-white">
                </div>
                <!-- Kategori -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori Koleksi</label>
                    <select name="kategori_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm bg-white">
                        <option value="">Pilih Kategori...</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Judul Koleksi -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama / Judul Koleksi</label>
                <input type="text" name="judul" required value="{{ old('judul') }}" placeholder="Contoh: Pisau Tumbuk Lada peninggalan..." 
                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm transition font-medium bg-white">
            </div>

            <!-- Deskripsi Umum -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Deskripsi Umum</label>
                <textarea name="deskripsi_umum" required rows="6" placeholder="Tuliskan gambaran umum koleksi budaya ini..." 
                          class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm leading-relaxed bg-white resize-y">{{ old('deskripsi_umum') }}</textarea>
                <p class="text-xs text-gray-500 mt-2">Berikan penjelasan singkat namun padat yang mudah dipahami oleh publik.</p>
            </div>

            <!-- Sejarah & Makna Filosofis -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sejarah & Makna Filosofis (Opsional)</label>
                <textarea name="sejarah_makna" rows="8" placeholder="Tuliskan sejarah, asal usul, atau makna filosofis dari koleksi budaya ini..." 
                          class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm leading-relaxed bg-white resize-y">{{ old('sejarah_makna') }}</textarea>
            </div>
            
            <!-- Unggah Media Galeri -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Media Galeri (Foto & Video)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-md p-6 text-center hover:bg-gray-50 transition cursor-pointer" onclick="document.getElementById('galeri-upload').click()">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600 font-medium">Klik untuk memilih file foto/video</p>
                    <p class="mt-1 text-xs text-gray-500">Mendukung JPG, PNG, MP4 (Maks 50MB per file). Gambar pertama akan menjadi foto utama.</p>
                    <input type="file" id="galeri-upload" name="galeri_files[]" multiple accept="image/*,video/mp4,video/quicktime" class="hidden">
                </div>
                <div id="file-preview-container" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 empty:hidden"></div>
            </div>

            <!-- Peta Titik Asal -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Titik Asal Koleksi (Peta)</label>
                <p class="text-xs text-gray-500 mb-3">Geser pin (marker) pada peta atau cari lokasi (fokus pencarian di wilayah Kabupaten Karo) untuk menentukan letak titik asal koleksi.</p>

                <div class="flex flex-col gap-3 mb-3 relative">
                    <div class="relative w-full">
                        <input type="text" id="map-search" placeholder="Cari desa / kecamatan di Kab. Karo..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-md text-sm focus:border-museum-red">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <ul id="search-results" class="absolute z-10 w-full bg-white border border-gray-200 rounded-md shadow-lg top-11 max-h-48 overflow-y-auto hidden"></ul>
                </div>
                
                <div id="map" class="w-full h-80 rounded-md border border-gray-300 z-0"></div>
                
                <div class="flex gap-4 mt-3">
                    <div class="w-1/2">
                        <label class="block text-xs text-gray-500 font-semibold mb-1">Latitude</label>
                        <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded text-sm text-gray-600">
                    </div>
                    <div class="w-1/2">
                        <label class="block text-xs text-gray-500 font-semibold mb-1">Longitude</label>
                        <input type="text" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded text-sm text-gray-600">
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.koleksi') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-museum-red text-white text-sm font-bold rounded-md hover:bg-red-800 transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan & Publikasikan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- MAP INITIALIZATION ---
        const defaultLat = 3.1000;
        const defaultLng = 98.4833;
        
        const map = L.map('map').setView([defaultLat, defaultLng], 11);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: 'Â© OpenStreetMap contributors'
        }).addTo(map);

        let marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        // Set default
        latInput.value = defaultLat.toFixed(6);
        lngInput.value = defaultLng.toFixed(6);

        // Update when dragged
        marker.on('dragend', function (e) {
            const pos = marker.getLatLng();
            latInput.value = pos.lat.toFixed(6);
            lngInput.value = pos.lng.toFixed(6);
            map.panTo(pos);
        });

        // Update when map clicked
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            latInput.value = e.latlng.lat.toFixed(6);
            lngInput.value = e.latlng.lng.toFixed(6);
        });

        // --- MAP SEARCH (NOMINATIM) ---
        const searchInput = document.getElementById('map-search');
        const searchResults = document.getElementById('search-results');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value;
            
            if(query.length < 3) {
                searchResults.classList.add('hidden');
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}, Karo, Sumatera Utara`)
                    .then(res => res.json())
                    .then(data => {
                        searchResults.innerHTML = '';
                        if(data.length > 0) {
                            searchResults.classList.remove('hidden');
                            data.forEach(item => {
                                const li = document.createElement('li');
                                li.className = 'px-4 py-2 hover:bg-gray-50 cursor-pointer text-sm text-gray-700 border-b last:border-0';
                                li.textContent = item.display_name;
                                li.onclick = () => {
                                    const lat = parseFloat(item.lat);
                                    const lon = parseFloat(item.lon);
                                    map.setView([lat, lon], 14);
                                    marker.setLatLng([lat, lon]);
                                    latInput.value = lat.toFixed(6);
                                    lngInput.value = lon.toFixed(6);
                                    searchInput.value = item.display_name.split(',')[0];
                                    searchResults.classList.add('hidden');
                                };
                                searchResults.appendChild(li);
                            });
                        } else {
                            searchResults.classList.add('hidden');
                        }
                    });
            }, 500);
        });

        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            if(!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });

        // --- FILE PREVIEW ---
        const fileInput = document.getElementById('galeri-upload');
        const container = document.getElementById('file-preview-container');
        
        fileInput.addEventListener('change', function() {
            container.innerHTML = '';
            Array.from(this.files).forEach(file => {
                const isVideo = file.type.startsWith('video/');
                const div = document.createElement('div');
                div.className = 'relative aspect-square rounded-md overflow-hidden bg-gray-100 border border-gray-200 group';
                
                if(isVideo) {
                    div.innerHTML = `
                        <div class="absolute inset-0 flex items-center justify-center bg-gray-800">
                            <svg class="w-8 h-8 text-white opacity-75" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                            <p class="text-[10px] text-white truncate font-medium">${file.name}</p>
                        </div>
                    `;
                } else {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/60 to-transparent p-2 opacity-0 group-hover:opacity-100 transition">
                                <p class="text-[10px] text-white truncate font-medium">${file.name}</p>
                            </div>
                        `;
                    }
                    reader.readAsDataURL(file);
                }
                container.appendChild(div);
            });
        });
    });
</script>
@endpush
@endsection

