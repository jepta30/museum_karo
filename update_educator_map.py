import re

for file in ['resources/views/educator/modul_create.blade.php', 'resources/views/educator/modul_edit.blade.php']:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()

    # Update input wrapper to include the search-results <ul>
    input_wrapper_target = """<button type="button" id="btn-search-map" class="absolute right-2 top-1.5 px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs rounded border border-gray-300">Cari</button>
                            </div>
                        </div>"""
    input_wrapper_new = """<button type="button" id="btn-search-map" class="absolute right-2 top-1.5 px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs rounded border border-gray-300">Cari</button>
                            </div>
                            <ul id="search-results" class="absolute z-10 w-full bg-white border border-gray-200 rounded-md shadow-lg top-11 max-h-48 overflow-y-auto hidden"></ul>
                        </div>"""
    if 'id="search-results"' not in content:
        content = content.replace(input_wrapper_target, input_wrapper_new)

    # Replace the JS logic for btn-search-map
    js_target = r"document\.getElementById\('btn-search-map'\)\.addEventListener\('click', function\(\) \{[\s\S]*?\}\);"
    
    js_new = """const searchInput = document.getElementById('map-search');
        const searchResults = document.getElementById('search-results');
        const btnSearch = document.getElementById('btn-search-map');

        function doSearch() {
            const query = searchInput.value.trim();
            if(query.length < 3) {
                if(searchResults) searchResults.classList.add('hidden');
                return;
            }

            const searchQuery = encodeURIComponent(query + ", Kabupaten Karo, Sumatera Utara");
            
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${searchQuery}`)
                .then(res => res.json())
                .then(data => {
                    if(!searchResults) return;
                    searchResults.innerHTML = '';
                    if(data.length > 0) {
                        searchResults.classList.remove('hidden');
                        data.forEach(item => {
                            const li = document.createElement('li');
                            li.className = 'px-4 py-2 hover:bg-gray-50 cursor-pointer text-sm text-gray-700 border-b last:border-0';
                            li.textContent = item.display_name;
                            li.onclick = () => {
                                const lat = parseFloat(item.lat);
                                const lng = parseFloat(item.lon);
                                map.setView([lat, lng], 14);
                                setMarker(lat, lng);
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

        if(btnSearch) {
            btnSearch.addEventListener('click', doSearch);
        }
        
        if(searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if(e.key === 'Enter') {
                    e.preventDefault();
                    doSearch();
                }
            });
        }"""
        
    content = re.sub(js_target, js_new, content)

    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)
