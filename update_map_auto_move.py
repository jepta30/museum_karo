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

    # Find the data.length > 0 block
    # It looks like:
    # if(data.length > 0) {
    #     searchResults.classList.remove('hidden');
    
    target = """if(data.length > 0) {
                        searchResults.classList.remove('hidden');"""
                        
    # Replace with logic to auto-focus the first result
    # We need to detect if it's admin (marker.setLatLng) or educator (setMarker)
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

    replacement = """if(data.length > 0) {
                        searchResults.classList.remove('hidden');""" + auto_move
                        
    content = content.replace(target, replacement)
    
    # Also fix searchInput.value update for educator
    if is_educator:
        click_target = """setMarker(lat, lng);
                                searchResults.classList.add('hidden');"""
        click_replacement = """setMarker(lat, lng);
                                searchInput.value = item.display_name.split(',')[0];
                                searchResults.classList.add('hidden');"""
        content = content.replace(click_target, click_replacement)

    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)
