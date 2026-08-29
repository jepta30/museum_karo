@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-10">
    <!-- Breadcrumb -->
    <div class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('educator.dashboard') }}" class="hover:text-museum-red">Dasbor</a>
        <span class="mx-2">/</span>
        @if($koleksi)
            <a href="{{ route('educator.koleksi.show', $koleksi->id) }}" class="hover:text-museum-red">{{ $koleksi->nama_sementara }}</a>
            <span class="mx-2">/</span>
        @endif
        <span class="text-gray-800 font-medium">Lanjutkan Menyusun Draf</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Side: Referensi Data Kurator -->
        <div class="lg:col-span-1 space-y-6">
            @if($koleksi)
            <div class="bg-[#fdf9f4] border border-[#f0e3d3] rounded-xl shadow-sm overflow-hidden sticky top-6">
                <div class="bg-[#f0e3d3] px-5 py-3">
                    <h3 class="font-serif font-bold text-[#6d3e3e]">Data Kurator (Referensi)</h3>
                </div>
                <div class="p-5 space-y-4">
                    <div class="w-full aspect-[4/3] bg-white rounded border border-gray-200 flex-shrink-0 overflow-hidden mb-4">
                        @if($koleksi->path_foto)
                            <img src="{{ Storage::url($koleksi->path_foto) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-full h-full text-gray-300 p-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                        @endif
                    </div>
                    
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Koleksi Budaya</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $koleksi->nama_sementara }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Disumbangkan Oleh</p>
                        <p class="text-sm font-medium text-gray-900">{{ $koleksi->nama_penyerah ?? 'Tidak Diketahui' }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Klaim Asal Usul</p>
                        <p class="text-sm text-gray-700 bg-white p-3 border border-gray-200 rounded leading-relaxed max-h-40 overflow-y-auto">
                            {{ $koleksi->klaim_asal_usul ?? 'Tidak ada data klaim sejarah.' }}
                        </p>
                    </div>
                    
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Catatan Kuratorial</p>
                        <p class="text-sm text-gray-700 bg-white p-3 border border-gray-200 rounded leading-relaxed max-h-60 overflow-y-auto">
                            {{ $koleksi->deskripsi ?? $koleksi->kondisi_kuratorial ?? 'Tidak ada catatan kuratorial rinci.' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Kondisi Fisik</p>
                        <p class="text-sm text-gray-700 bg-white p-3 border border-gray-200 rounded leading-relaxed">
                            {{ $koleksi->kondisi_awal ?? 'Tidak diketahui' }}
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Side: Form Edukator -->
        <div class="lg:col-span-2">
            <div class="bg-[#fdfbf9] border border-[#f2ebe3] rounded-xl shadow-sm overflow-hidden">
                <div class="bg-white border-b border-[#f2ebe3] p-6 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-serif font-bold text-[#6d3e3e]">Lanjutkan Menyusun Modul</h1>
                        <p class="text-sm text-gray-600 mt-1">Perbarui narasi sejarah dan edukasi yang sudah Anda mulai.</p>
                    </div>
                    @if($modul->status === 'draf')
                        <span class="bg-orange-100 text-orange-800 text-xs font-bold px-3 py-1 rounded border border-orange-200">Status: Draf</span>
                    @endif
                </div>

                <form action="{{ route('educator.modul.update', $modul->id) }}" method="POST" class="p-8 space-y-8">
                    @csrf
                    
                    <!-- Judul Modul -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Judul Materi / Modul</label>
                        <input type="text" name="judul" required value="{{ old('judul', $modul->judul) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm transition font-medium bg-white">
                    </div>

                    <!-- Deskripsi Umum -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Deskripsi Umum</label>
                        <textarea name="deskripsi_umum" required rows="6" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm leading-relaxed bg-white resize-y">{{ old('deskripsi_umum', $deskripsi_umum) }}</textarea>
                        <p class="text-xs text-gray-500 mt-2">Berikan penjelasan singkat namun padat yang mudah dipahami oleh publik.</p>
                    </div>

                    <!-- Sejarah & Makna Filosofis -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sejarah & Makna Filosofis (Opsional)</label>
                        <textarea name="sejarah_makna" rows="8" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-museum-red focus:border-museum-red text-sm leading-relaxed bg-white resize-y">{{ old('sejarah_makna', $sejarah_makna) }}</textarea>
                    </div>

                    <!-- Peta Titik Asal -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Titik Asal Koleksi (Peta)</label>
                        <p class="text-xs text-gray-500 mb-3">Geser pin (marker) pada peta atau cari lokasi (fokus pencarian di wilayah Kabupaten Karo) untuk menentukan letak titik asal koleksi.</p>
                        
                        <div class="flex flex-col gap-3 mb-3 relative">
                            <div class="relative w-full">
                                <input type="text" id="map-search" placeholder="Cari desa / kecamatan di Kab. Karo..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-md text-sm focus:border-museum-red">
                                <div class="absolute left-3 top-2.5 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <button type="button" id="btn-search-map" class="absolute right-2 top-1.5 px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs rounded border border-gray-300">Cari</button>
                            </div>
                        </div>
                        
                        <div id="locationMap" class="w-full h-80 rounded-md border border-gray-300 shadow-inner z-0"></div>
                        
                        <div class="flex gap-4 mt-3">
                            <div class="flex-1">
                                <label class="text-[10px] text-gray-500 uppercase font-bold">Latitude</label>
                                <input type="text" id="latitude" name="latitude" value="{{ $modul->latitude }}" readonly class="w-full mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded text-sm text-gray-600">
                            </div>
                            <div class="flex-1">
                                <label class="text-[10px] text-gray-500 uppercase font-bold">Longitude</label>
                                <input type="text" id="longitude" name="longitude" value="{{ $modul->longitude }}" readonly class="w-full mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded text-sm text-gray-600">
                            </div>
                        </div>
                    </div>

                    <!-- Aksi -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#f2ebe3] bg-[#fdfbf9] -mx-8 -mb-8 px-8 py-4">
                        <a href="{{ url()->previous() }}" class="px-6 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded transition shadow-sm">
                            Batal
                        </a>
                        <!-- Simpan sebagai Draf -->
                        <button type="submit" name="action" value="draf" class="px-6 py-2.5 bg-white text-gray-800 border border-gray-300 text-sm font-semibold rounded shadow-sm hover:bg-gray-50 transition">
                            Simpan Draf
                        </button>
                        <!-- Publis -->
                        <button type="submit" name="action" value="publis" class="px-8 py-2.5 bg-[#4a1b1b] text-white text-sm font-semibold rounded shadow-sm hover:bg-[#381111] transition">
                            Publis
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>
@endsection
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const initialLat = {{ $modul->latitude ?? 3.13220 }};
        const initialLng = {{ $modul->longitude ?? 98.46650 }};
        const hasLocation = {{ $modul->latitude ? 'true' : 'false' }};
        
        const map = L.map('locationMap').setView([initialLat, initialLng], hasLocation ? 14 : 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
        
        let marker = null;
        
        if(hasLocation) {
            setMarker(initialLat, initialLng);
        }
        
        map.on('click', function(e) {
            setMarker(e.latlng.lat, e.latlng.lng);
        });
        
        function setMarker(lat, lng) {
            if(marker) map.removeLayer(marker);
            marker = L.marker([lat, lng], {draggable: true}).addTo(map);
            document.getElementById('latitude').value = lat.toFixed(7);
            document.getElementById('longitude').value = lng.toFixed(7);
            
            marker.on('dragend', function(event) {
                const position = marker.getLatLng();
                document.getElementById('latitude').value = position.lat.toFixed(7);
                document.getElementById('longitude').value = position.lng.toFixed(7);
            });
        }
        
        document.getElementById('btn-search-map').addEventListener('click', function() {
            const query = document.getElementById('map-search').value;
            if(!query) return;
            
            // Search focused on Kabupaten Karo
            fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query + ', Kabupaten Karo, Sumatera Utara'))
                .then(res => res.json())
                .then(data => {
                    if(data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);
                        map.setView([lat, lng], 14);
                        setMarker(lat, lng);
                    } else {
                        alert('Lokasi tidak ditemukan di Kabupaten Karo.');
                    }
                });
        });
    });
</script>
@endpush
