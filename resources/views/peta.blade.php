@extends('layouts.public')

@section('title', 'Peta Titik Asal Koleksi')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<style>
    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        overflow: hidden;
        padding: 0;
    }
    .leaflet-popup-content {
        margin: 0;
        width: 240px !important;
    }
    .custom-marker {
        background: white;
        border: 2px solid #8b1c1c;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        transition: transform 0.2s;
    }
    .custom-marker:hover {
        transform: scale(1.1);
        z-index: 1000 !important;
    }
    .custom-marker img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<div class="bg-[#faf7f2] border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-8 md:py-12">
        <h1 class="text-3xl md:text-4xl font-serif font-bold text-[#4a1c1c] text-center mb-4">Peta Persebaran Titik Asal</h1>
        <p class="text-gray-600 text-center max-w-2xl mx-auto text-sm md:text-base leading-relaxed">
            Eksplorasi jejak persebaran koleksi artefak Museum Pusaka Karo secara geografis.
        </p>
    </div>
</div>

<div class="w-full relative h-[70vh] min-h-[500px]">
    <div id="mainMap" class="w-full h-full z-0"></div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Init Map centered at Museum Pusaka Karo
        const map = L.map('mainMap').setView([3.13220, 98.46650], 11);
        
        // Base Layer (Satellite/Hybrid view is best for this)
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        }).addTo(map);

        // Marker khusus untuk Museum Pusaka Karo
        const museumIcon = L.divIcon({
            className: 'custom-icon',
            html: `
                <div class="custom-marker" style="width: 70px; height: 70px; border-radius: 50%; border: 3px solid #c9a84c; box-shadow: 0 4px 12px rgba(0,0,0,0.5); z-index: 2000; position: relative;">
                    <img src="/images/tampakdepan.png" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block;" alt="Museum Pusaka Karo" />
                </div>
            `,
            iconSize: [70, 70],
            iconAnchor: [35, 35],
            popupAnchor: [0, -35]
        });

        L.marker([3.13220, 98.46650], {icon: museumIcon, zIndexOffset: 1000})
            .addTo(map)
            .bindPopup(`
                <div class="text-center p-2">
                    <img src="/images/tampakdepan.png" class="w-full h-24 object-cover rounded mb-2">
                    <h3 class="font-bold text-[#8b1c1c] text-sm mb-1">Museum Pusaka Karo</h3>
                    <p class="text-xs text-gray-600">Jl. Perwira No. 3, Berastagi</p>
                </div>
            `);

        // Map data from controller
        const moduls = @json($moduls);

        // Kelompokkan modul berdasarkan koordinat
        const groupedModuls = {};
        
        moduls.forEach(modul => {
            if (modul.latitude && modul.longitude && modul.koleksi.path_foto) {
                const key = modul.latitude + '_' + modul.longitude;
                if(!groupedModuls[key]) {
                    groupedModuls[key] = [];
                }
                groupedModuls[key].push(modul);
            }
        });

        // Tampilkan marker untuk setiap kelompok
        Object.keys(groupedModuls).forEach(key => {
            const group = groupedModuls[key];
            const firstModul = group[0];
            const count = group.length;

            let badgeHtml = '';
            if (count > 1) {
                badgeHtml = `<div style="position: absolute; top: -8px; right: -8px; background: #8b1c1c; color: white; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; border: 2px solid white; z-index: 10;">${count}</div>`;
            }

            // Custom Icon for image
            const icon = L.divIcon({
                className: 'custom-icon',
                html: `
                    <div style="position: relative; display: block;">
                        <div class="custom-marker" style="width: 55px; height: 55px; border: 3px solid white; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.4); display: block; overflow: hidden; position: relative;">
                            <img src="/storage/${firstModul.koleksi.path_foto}" style="width: 100%; height: 100%; object-fit: cover; display: block;" alt="${firstModul.judul}" onerror="this.src='/images/placeholder.jpg'" />
                        </div>
                        ${badgeHtml}
                    </div>
                `,
                iconSize: [55, 55],
                iconAnchor: [27, 27],
                popupAnchor: [0, -27]
            });

            const marker = L.marker([firstModul.latitude, firstModul.longitude], {icon: icon}).addTo(map);

            // Buat konten popup
            let popupContent = '';
            
            if (count === 1) {
                // Tampilan tunggal
                popupContent = `
                    <div class="bg-white">
                        <div class="h-32 w-full bg-gray-100 overflow-hidden">
                            <img src="/storage/${firstModul.koleksi.path_foto}" class="w-full h-full object-cover" onerror="this.src='/images/placeholder.jpg'">
                        </div>
                        <div class="p-4">
                            <div class="text-[10px] font-bold text-[#8b1c1c] uppercase tracking-wider mb-1">${firstModul.koleksi.kategori ? firstModul.koleksi.kategori.nama_kategori : 'Umum'}</div>
                            <h3 class="font-bold text-gray-900 text-sm mb-2 leading-tight">${firstModul.judul}</h3>
                            
                            <div class="flex flex-col gap-2 mt-3">
                                <a href="/koleksi/${firstModul.id}" class="text-center w-full px-3 py-1.5 bg-[#4a1c1c] text-white text-xs font-semibold rounded hover:bg-[#3a1515] transition">
                                    Lihat Detail
                                </a>
                                <a href="https://www.google.com/maps/search/?api=1&query=${firstModul.latitude},${firstModul.longitude}" target="_blank" class="text-center w-full px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-semibold rounded hover:bg-gray-200 transition flex items-center justify-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    Buka di Maps
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                // Tampilan jamak (list)
                let listItems = group.map(modul => `
                    <div class="flex items-center gap-3 p-3 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition">
                        <img src="/storage/${modul.koleksi.path_foto}" class="w-12 h-12 object-cover rounded shadow-sm" onerror="this.src='/images/placeholder.jpg'">
                        <div class="flex-1 min-w-0">
                            <div class="text-[9px] font-bold text-[#8b1c1c] uppercase tracking-wider truncate">${modul.koleksi.kategori ? modul.koleksi.kategori.nama_kategori : 'Umum'}</div>
                            <h4 class="font-bold text-gray-800 text-xs truncate" title="${modul.judul}">${modul.judul}</h4>
                            <a href="/koleksi/${modul.id}" class="text-[10px] text-blue-600 hover:underline mt-0.5 inline-block">Lihat Koleksi &rarr;</a>
                        </div>
                    </div>
                `).join('');

                popupContent = `
                    <div class="bg-white">
                        <div class="bg-[#8b1c1c] text-white p-3 text-center">
                            <h3 class="font-bold text-sm">Terdapat ${count} Koleksi di Lokasi Ini</h3>
                        </div>
                        <div class="max-h-60 overflow-y-auto">
                            ${listItems}
                        </div>
                        <div class="p-3 border-t border-gray-100 bg-gray-50">
                            <a href="https://www.google.com/maps/search/?api=1&query=${firstModul.latitude},${firstModul.longitude}" target="_blank" class="text-center w-full px-3 py-1.5 bg-white border border-gray-300 text-gray-700 text-xs font-semibold rounded hover:bg-gray-100 transition flex items-center justify-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                Rute Peta
                            </a>
                        </div>
                    </div>
                `;
            }

            marker.bindPopup(popupContent);
        });
    });
</script>
@endpush
