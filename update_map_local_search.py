import re

files = [
    'resources/views/admin/koleksi/create.blade.php',
    'resources/views/admin/koleksi/edit.blade.php',
    'resources/views/educator/modul_create.blade.php',
    'resources/views/educator/modul_edit.blade.php'
]

new_js = """
        let karoVillages = [];
        fetch('/karo_villages.json')
            .then(res => res.json())
            .then(data => { karoVillages = data; })
            .catch(err => console.error('Gagal memuat data desa:', err));

        function doSearch() {
            const query = searchInput.value.trim().toLowerCase();
            if(query.length < 3) {
                if(searchResults) searchResults.classList.add('hidden');
                return;
            }

            // Cari di data desa lokal dulu
            let matchedVillages = karoVillages.filter(v => 
                v.name.toLowerCase().includes(query) || 
                v.kecamatan.toLowerCase().includes(query)
            );

            // Jika ada kecocokan lokal, tampilkan sebagai dropdown
            if(matchedVillages.length > 0) {
                if(!searchResults) return;
                searchResults.innerHTML = '';
                searchResults.classList.remove('hidden');
                
                // Ambil 5 hasil terbaik
                matchedVillages.slice(0, 5).forEach(village => {
                    const li = document.createElement('li');
                    li.className = 'px-4 py-2 hover:bg-gray-50 cursor-pointer text-sm text-gray-700 border-b last:border-0';
                    li.innerHTML = `<strong>${village.name}</strong> <span class="text-xs text-gray-500">Kec. ${village.kecamatan}</span>`;
                    
                    li.onclick = () => {
                        searchInput.value = village.name;
                        searchResults.classList.add('hidden');
                        
                        // Fetch koordinat dari Nominatim menggunakan search_query yang sangat spesifik
                        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(village.search_query)}`)
                            .then(res => res.json())
                            .then(data => {
                                if(data.length > 0) {
                                    const lat = parseFloat(data[0].lat);
                                    const lon = parseFloat(data[0].lon);
                                    map.setView([lat, lon], 14);
                                    if(typeof setMarker === 'function') {
                                        setMarker(lat, lon); // Educator
                                    } else {
                                        marker.setLatLng([lat, lon]); // Admin
                                        latInput.value = lat.toFixed(6);
                                        lngInput.value = lon.toFixed(6);
                                    }
                                } else {
                                    alert(`Koordinat untuk ${village.name} belum tersedia di OpenStreetMap.`);
                                }
                            });
                    };
                    searchResults.appendChild(li);
                });
                
                // Jika user langsung klik "Cari" (tanpa pilih dropdown), eksekusi yang pertama
                if(event && event.type === 'click' || (event && event.type === 'keypress' && event.key === 'Enter')) {
                    searchResults.firstChild.click();
                }
                
            } else {
                // Fallback ke Nominatim biasa jika tidak ada di daftar lokal
                const searchQuery = encodeURIComponent(query + ", Kabupaten Karo, Sumatera Utara");
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${searchQuery}`)
                    .then(res => res.json())
                    .then(data => {
                        if(!searchResults) return;
                        searchResults.innerHTML = '';
                        if(data.length > 0) {
                            searchResults.classList.remove('hidden');
                            
                            const firstLat = parseFloat(data[0].lat);
                            const firstLng = parseFloat(data[0].lon);
                            map.setView([firstLat, firstLng], 14);
                            if(typeof setMarker === 'function') {
                                setMarker(firstLat, firstLng);
                            } else {
                                marker.setLatLng([firstLat, firstLng]);
                                latInput.value = firstLat.toFixed(6);
                                lngInput.value = firstLng.toFixed(6);
                            }
                            
                            data.forEach(item => {
                                const li = document.createElement('li');
                                li.className = 'px-4 py-2 hover:bg-gray-50 cursor-pointer text-sm text-gray-700 border-b last:border-0';
                                li.textContent = item.display_name;
                                li.onclick = () => {
                                    const lat = parseFloat(item.lat);
                                    const lng = parseFloat(item.lon);
                                    map.setView([lat, lng], 14);
                                    if(typeof setMarker === 'function') {
                                        setMarker(lat, lng);
                                        searchInput.value = item.display_name.split(',')[0];
                                    } else {
                                        marker.setLatLng([lat, lng]);
                                        latInput.value = lat.toFixed(6);
                                        lngInput.value = lng.toFixed(6);
                                        searchInput.value = item.display_name.split(',')[0];
                                    }
                                    searchResults.classList.add('hidden');
                                };
                                searchResults.appendChild(li);
                            });
                        } else {
                            searchResults.classList.remove('hidden');
                            const li = document.createElement('li');
                            li.className = 'px-4 py-2 text-sm text-gray-500';
                            li.textContent = 'Lokasi tidak ditemukan';
                            searchResults.appendChild(li);
                        }
                    });
            }
        }
"""

for file in files:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()

    # Find the doSearch function block and replace it
    # We will use regex to find: function doSearch() { ... }
    # up to the if(btnSearch) block
    
    pattern = r'function doSearch\(\)\s*\{[\s\S]*?\}\s*(?=if\(btnSearch\))'
    
    content = re.sub(pattern, new_js, content)

    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)
