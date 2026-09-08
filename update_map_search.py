import re

for file in ['resources/views/admin/koleksi/create.blade.php', 'resources/views/admin/koleksi/edit.blade.php']:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()

    # Modify the search input wrapper to include the button
    input_wrapper_target = """<div class="relative w-full">
                        <input type="text" id="map-search" placeholder="Cari desa / kecamatan di Kab. Karo..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-md text-sm focus:border-museum-red">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>"""
    input_wrapper_new = """<div class="flex gap-2 relative w-full">
                        <div class="relative flex-1">
                            <input type="text" id="map-search" placeholder="Ketik nama desa atau kecamatan di Karo..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-md text-sm focus:border-museum-red">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <button type="button" id="btn-search-map" class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700 transition shadow-sm">Cari</button>
                    </div>"""
    content = content.replace(input_wrapper_target, input_wrapper_new)

    # Modify the JS logic to use the button and format the query better for Karo villages
    js_target = """const searchInput = document.getElementById('map-search');
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
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}, Karo, Sumatera Utara`)"""
    
    js_new = """const searchInput = document.getElementById('map-search');
        const searchResults = document.getElementById('search-results');
        const btnSearch = document.getElementById('btn-search-map');

        function doSearch() {
            const query = searchInput.value.trim();
            if(query.length < 3) {
                searchResults.classList.add('hidden');
                return;
            }

            // Gunakan variasi query untuk memastikan desa di Karo bisa dicari
            // Kita gunakan format: "query, Kabupaten Karo" atau "Desa query, Kabupaten Karo"
            const searchQuery = encodeURIComponent(query + ", Kabupaten Karo, Sumatera Utara");
            
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${searchQuery}`)"""
            
    content = content.replace(js_target, js_new)

    # Add event listener for the button and enter key
    js_target2 = """                        }
                    });
            }, 500);
        });"""
        
    js_new2 = """                        }
                    });
        }

        // Jalankan pencarian saat tombol diklik
        btnSearch.addEventListener('click', doSearch);
        
        // Jalankan pencarian saat menekan enter (mencegah form submit)
        searchInput.addEventListener('keypress', function(e) {
            if(e.key === 'Enter') {
                e.preventDefault();
                doSearch();
            }
        });"""
        
    content = content.replace(js_target2, js_new2)

    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)

