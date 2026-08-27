@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-10 mt-6 px-4">
    <div class="mb-8">
        <h1 class="text-3xl font-serif font-bold text-[#4a1c1c] mb-2">Peran & Izin Akses</h1>
        <p class="text-gray-600 text-sm">Manajemen kewenangan pengguna, pendaftaran staf, dan pengaturan hak akses.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Form Tambah User -->
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm sticky top-6">
                <h2 class="text-lg font-bold text-[#4a1c1c] mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Buat Akun Baru
                </h2>
                
                <form action="{{ route('admin.store_user') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#8b1c1c] focus:border-[#8b1c1c] sm:text-sm" placeholder="Contoh: Budi Santoso">
                        @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#8b1c1c] focus:border-[#8b1c1c] sm:text-sm" placeholder="email@museum.com">
                        @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kata Sandi (Password)</label>
                        <!-- Menggunakan type="text" agar admin bisa melihat apa yang dia ketikkan saat membuat akun -->
                        <input type="text" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#8b1c1c] focus:border-[#8b1c1c] sm:text-sm" placeholder="Ketik kata sandi di sini...">
                        @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Tetapkan Sebagai</label>
                        <select name="peran" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#8b1c1c] focus:border-[#8b1c1c] sm:text-sm text-gray-700">
                            <option value="">-- Pilih Akses / Peran --</option>
                            <option value="pendaftar">Pendaftar (Registrar)</option>
                            <option value="edukator">Edukator</option>
                            <option value="kurator">Kurator Utama</option>
                            <option value="pimpinan">Direktur (Pimpinan)</option>
                            <option value="admin">Administrator IT</option>
                        </select>
                        @error('peran') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-[#62231c] hover:bg-red-900 focus:outline-none transition">
                            Daftarkan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Pengguna -->
        <div class="lg:col-span-2">
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800">Daftar Hak Akses Sistem</h3>
                    <span class="bg-[#f7f2ed] text-[#8b1c1c] text-xs font-bold px-3 py-1 rounded-full border border-orange-200">{{ count($users) }} Terdaftar</span>
                </div>
                
                <table class="w-full text-left text-sm text-gray-700">
                    <thead class="text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-white">
                        <tr>
                            <th class="px-6 py-4">Pengguna</th>
                            <th class="px-6 py-4">Kata Sandi</th>
                            <th class="px-6 py-4">Izin Akses</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                <div class="text-[11px] text-gray-500">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 font-mono text-gray-400 text-xs tracking-widest" title="Kata sandi dienkripsi">
                                ••••••••
                            </td>
                            <td class="px-6 py-4">
                                @if($user->peran === 'admin')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-purple-100 text-purple-700 text-[10px] font-bold uppercase tracking-wider">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                        Administrator
                                    </span>
                                @elseif($user->peran === 'pimpinan')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-wider">Direktur</span>
                                @elseif($user->peran === 'kurator')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-orange-100 text-orange-700 text-[10px] font-bold uppercase tracking-wider">Kurator Utama</span>
                                @elseif($user->peran === 'edukator')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider">Edukator</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-gray-100 text-gray-700 text-[10px] font-bold uppercase tracking-wider">Pendaftar</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
