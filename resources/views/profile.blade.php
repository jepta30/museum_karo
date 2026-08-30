@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 font-serif">Pengaturan Akun</h1>
        <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil dan kata sandi Anda.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <form action="{{ route('profile.update') }}" method="POST" class="p-6 md:p-8">
            @csrf
            @method('PUT')
            
            <h2 class="text-lg font-bold text-gray-900 mb-6 border-b pb-2">Informasi Profil</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:ring-[#8b1c1c] focus:border-[#8b1c1c] text-sm @error('name') border-red-500 @enderror">
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email (Username)</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:ring-[#8b1c1c] focus:border-[#8b1c1c] text-sm @error('email') border-red-500 @enderror">
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <h2 class="text-lg font-bold text-gray-900 mb-6 border-b pb-2">Ubah Kata Sandi <span class="text-sm font-normal text-gray-500 ml-2">(Opsional)</span></h2>
            
            <div class="space-y-5 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" placeholder="Biarkan kosong jika tidak ingin mengubah sandi" class="w-full md:w-1/2 px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:ring-[#8b1c1c] focus:border-[#8b1c1c] text-sm @error('current_password') border-red-500 @enderror">
                    @error('current_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Baru</label>
                        <input type="password" name="new_password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:ring-[#8b1c1c] focus:border-[#8b1c1c] text-sm @error('new_password') border-red-500 @enderror">
                        @error('new_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="new_password_confirmation" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:ring-[#8b1c1c] focus:border-[#8b1c1c] text-sm">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="px-6 py-2.5 bg-[#8b1c1c] hover:bg-[#6a1515] text-white font-semibold rounded-md shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
