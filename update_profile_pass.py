import re

with open('resources/views/profile.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Current Password
old_current = """                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" placeholder="Biarkan kosong jika tidak ingin mengubah sandi" class="w-full md:w-1/2 px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:ring-[#8b1c1c] focus:border-[#8b1c1c] text-sm @error('current_password') border-red-500 @enderror">
                    @error('current_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>"""

new_current = """                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                    <div class="relative w-full md:w-1/2">
                        <input type="password" id="current_password" name="current_password" placeholder="Biarkan kosong jika tidak ingin mengubah sandi" class="w-full pr-10 px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:ring-[#8b1c1c] focus:border-[#8b1c1c] text-sm @error('current_password') border-red-500 @enderror">
                        <button type="button" onclick="togglePassword('current_password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#8b1c1c]">
                            <svg id="icon_current_password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                    @error('current_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>"""
content = content.replace(old_current, new_current)

# New Password
old_new = """                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Baru</label>
                        <input type="password" name="new_password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:ring-[#8b1c1c] focus:border-[#8b1c1c] text-sm @error('new_password') border-red-500 @enderror">
                        @error('new_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>"""

new_new = """                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Baru</label>
                        <div class="relative w-full">
                            <input type="password" id="new_password" name="new_password" class="w-full pr-10 px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:ring-[#8b1c1c] focus:border-[#8b1c1c] text-sm @error('new_password') border-red-500 @enderror">
                            <button type="button" onclick="togglePassword('new_password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#8b1c1c]">
                                <svg id="icon_new_password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                        @error('new_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>"""
content = content.replace(old_new, new_new)

# New Password Confirmation
old_confirm = """                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="new_password_confirmation" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:ring-[#8b1c1c] focus:border-[#8b1c1c] text-sm">
                    </div>"""

new_confirm = """                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative w-full">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full pr-10 px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:ring-[#8b1c1c] focus:border-[#8b1c1c] text-sm">
                            <button type="button" onclick="togglePassword('new_password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#8b1c1c]">
                                <svg id="icon_new_password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>"""
content = content.replace(old_confirm, new_confirm)

# Add Script at the end
script = """
@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById('icon_' + inputId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
    }
}
</script>
@endpush
"""

content = content.replace('@endsection', script + '\n@endsection')

with open('resources/views/profile.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
