<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIMPUKA</title>
    <!-- Import Font Serif dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Fallback CDN Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'museum-red': '#4a1515', 
                        'museum-cream': '#faf5f0',
                        'museum-input': '#fffdfa',
                    },
                    fontFamily: {
                        'serif': ['"Playfair Display"', 'Georgia', 'serif'], 
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-900 font-sans min-h-screen flex flex-col relative">

    <!-- Background Image with Gradient Overlay -->
    <div class="absolute inset-0 z-0">
        <!-- Transparent Overlay -->
        <div class="absolute inset-0 bg-black/40 z-10"></div>
        <!-- Background Image -->
        <img src="{{ asset('images/museum-karo.jpg') }}" class="absolute inset-0 w-full h-full object-cover z-0" alt="Background Museum Karo">
    </div>

    <!-- Relative wrapper so content sits above background -->
    <div class="relative z-20 flex flex-col min-h-screen">
        
        <!-- Topbar -->
        <header class="p-6 md:px-12">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto drop-shadow-md">
                <div>
                    <h1 class="font-serif font-bold text-2xl leading-tight text-white tracking-wide drop-shadow-md">SIMPUKA</h1>
                    <p class="text-[11px] text-gray-200 uppercase tracking-widest mt-0.5 font-medium leading-tight drop-shadow-md">Sistem Informasi Museum Pusaka Karo</p>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 flex items-center justify-center p-6">
            <div class="bg-white/95 backdrop-blur-sm p-10 md:p-12 rounded-lg shadow-2xl w-full max-w-md border border-white/20">
                
                <!-- Logo / Icon -->
                <div class="flex justify-center mb-6">
                    <svg class="w-12 h-12 text-museum-red" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </div>

                <h2 class="text-2xl md:text-3xl font-serif font-bold text-[#4a1515] text-center mb-10">Masuk ke Sistem Manajemen</h2>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-md text-sm text-center">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Email / Username -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Pengguna / Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan kredensial Anda" class="w-full pl-10 p-3.5 bg-museum-input border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-museum-red focus:border-museum-red transition">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input type="password" name="password" required placeholder="********" class="w-full pl-10 pr-10 p-3.5 bg-museum-input border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-museum-red focus:border-museum-red transition">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                                <svg class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </div>
                        </div>
                        <div class="text-right mt-2">
                            <a href="#" class="text-xs font-bold text-museum-red hover:underline">Lupa Kata Sandi?</a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full mt-4 bg-museum-red text-white font-semibold p-3.5 rounded-md flex items-center justify-center gap-2 hover:bg-red-900 transition">
                        Masuk
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>

            </div>
        </main>

        <!-- Footer -->
        <footer class="p-6 md:px-12 mt-auto">
            <p class="text-xs font-medium text-gray-300 drop-shadow-md">&copy; {{ date('Y') }} SIMPUKA - Sistem Informasi Museum Pusaka Karo. All rights reserved.</p>
        </footer>
    </div>

</body>
</html>
