import re

files = [
    'resources/views/admin/koleksi/create.blade.php',
    'resources/views/admin/koleksi/edit.blade.php',
    'resources/views/educator/modul_create.blade.php',
    'resources/views/educator/modul_edit.blade.php'
]

new_js = """        let karoVillages = [];
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

            if(matchedVillages.length > 0) {
                if(!searchResults) return;
                searchResults.innerHTML = '';
                searchResults.classList.remove('hidden');
                
                matchedVillages.slice(0, 5).forEach(village => {
                    const li = document.createElement('li');
                    li.className = 'px-4 py-2 hover:bg-gray-50 cursor-pointer text-sm text-gray-700 border-b last:border-0';
                    li.innerHTML = `<strong>${village.name}</strong> <span class="text-xs text-gray-500">Kec. ${village.kecamatan}</span>`;
                    
                    li.onclick = () => {
                        searchInput.value = village.name;
                        searchResults.classList.add('hidden');
                        
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
                                    alert(`Titik koordinat untuk ${village.name} belum terdata akurat di peta OpenStreetMap.`);
                                }
                            });
                    };
                    searchResults.appendChild(li);
                });
                
                // Auto-click the first one to move pin
                searchResults.firstChild.click();
                
            } else {
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
        }"""

for file in files:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()

    # The block we want to replace starts with "function doSearch() {"
    # and ends right before "if(btnSearch) {" or "if(searchInput) {"
    # Let's find "function doSearch()" and replace everything up to the line BEFORE "if(btnSearch)"
    
    start_idx = content.find("function doSearch() {")
    if start_idx == -1:
        continue
        
    end_idx = content.find("if(btnSearch) {", start_idx)
    if end_idx == -1:
        # try without space
        end_idx = content.find("if(btnSearch){", start_idx)
    if end_idx == -1:
        # maybe it's just btnSearch.addEventListener in older code?
        end_idx = content.find("document.getElementById('btn-search-map').addEventListener", start_idx)
    if end_idx == -1:
        end_idx = content.find("if(searchInput)", start_idx)

    if start_idx != -1 and end_idx != -1:
        new_content = content[:start_idx] + new_js + "\n\n        " + content[end_idx:]
        with open(file, 'w', encoding='utf-8') as f:
            f.write(new_content)

