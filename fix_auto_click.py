import re

files = [
    'resources/views/admin/koleksi/create.blade.php',
    'resources/views/admin/koleksi/edit.blade.php',
    'resources/views/educator/modul_create.blade.php',
    'resources/views/educator/modul_edit.blade.php'
]

for file in files:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()

    # We want to replace the auto-click logic:
    # searchResults.firstChild.click();
    # with logic that moves the pin to the first result but DOES NOT hide the dropdown.
    
    target = "searchResults.firstChild.click();"
    new_code = """
                // Auto-move ke hasil pertama TANPA menyembunyikan dropdown
                const firstVillage = matchedVillages[0];
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(firstVillage.search_query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if(data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            map.setView([lat, lon], 14);
                            if(typeof setMarker === 'function') {
                                setMarker(lat, lon);
                            } else {
                                marker.setLatLng([lat, lon]);
                                latInput.value = lat.toFixed(6);
                                lngInput.value = lon.toFixed(6);
                            }
                        }
                    });
"""

    content = content.replace(target, new_code)

    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)
