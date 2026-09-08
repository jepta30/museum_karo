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

    if 'firstLat' in content:
        continue # Already processed

    is_educator = 'setMarker' in content and 'modul_' in file
    
    auto_move = ""
    if is_educator:
        auto_move = """
                        // Auto-move ke hasil pertama
                        const firstLat = parseFloat(data[0].lat);
                        const firstLng = parseFloat(data[0].lon);
                        map.setView([firstLat, firstLng], 14);
                        setMarker(firstLat, firstLng);
"""
    else:
        auto_move = """
                        // Auto-move ke hasil pertama
                        const firstLat = parseFloat(data[0].lat);
                        const firstLng = parseFloat(data[0].lon);
                        map.setView([firstLat, firstLng], 14);
                        marker.setLatLng([firstLat, firstLng]);
                        latInput.value = firstLat.toFixed(6);
                        lngInput.value = firstLng.toFixed(6);
"""

    content = re.sub(
        r"(if\s*\(\s*data\.length\s*>\s*0\s*\)\s*\{\s*searchResults\.classList\.remove\('hidden'\);)",
        r"\1" + auto_move,
        content
    )
    
    if is_educator:
        content = re.sub(
            r"(setMarker\(lat,\s*lng\);\s*searchResults\.classList\.add\('hidden'\);)",
            r"setMarker(lat, lng);\n                                searchInput.value = item.display_name.split(',')[0];\n                                searchResults.classList.add('hidden');",
            content
        )

    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)
