<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-emerald-50 to-emerald-100/50 py-12">
        <div class="w-full max-w-md">
            
            <div class="text-center mb-10">
                <div class="inline-block p-5 bg-white rounded-[2.5rem] shadow-2xl shadow-emerald-900/10 mb-2 border border-white">
                    <img src="{{ asset('img/logo jaksa.png') }}" alt="Logo Kejaksaan" class="w-24 h-auto mx-auto drop-shadow-md">
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[3rem] shadow-2xl shadow-emerald-900/10 border border-white">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="space-y-2">
                        <x-input-label for="name" :value="__('Nama Lengkap')" class="font-black text-emerald-900 uppercase tracking-widest text-[10px] ml-1" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-emerald-500">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            <x-text-input id="name" class="block w-full pl-11 pr-4 py-4 bg-gray-50/50 border-gray-100 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 font-bold text-sm uppercase" 
                                            type="text" name="name" :value="old('name')" placeholder="NAMA LENGKAP..." required autofocus autocomplete="name" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-6 space-y-2">
                        <x-input-label for="nip" :value="__('Nomor Induk Pegawai (NIP)')" class="font-black text-emerald-900 uppercase tracking-widest text-[10px] ml-1" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-emerald-500">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                            </span>
                            <x-text-input id="nip" class="block w-full pl-11 pr-4 py-4 bg-gray-50/50 border-gray-100 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 font-bold text-sm" 
                                            type="text" name="nip" :value="old('nip')" placeholder="MASUKKAN NIP..." required />
                        </div>
                        <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                    </div>

                    <div class="mt-6 space-y-2">
                        <x-input-label for="role" :value="__('Otoritas Akses')" class="font-black text-emerald-900 uppercase tracking-widest text-[10px] ml-1" />
                        <select name="role" id="role" class="block w-full px-4 py-4 bg-gray-50/50 border-gray-100 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 font-black text-xs uppercase tracking-widest text-emerald-700">
                            <option value="admin">Staf / Admin (Akses Penuh)</option>
                            <option value="pimpinan">Pimpinan (Akses Monitoring)</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="mt-6 space-y-2">
                        <x-input-label for="password" :value="__('Kata Sandi')" class="font-black text-emerald-900 uppercase tracking-widest text-[10px] ml-1" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-emerald-500">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-11V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <x-text-input id="password" class="block w-full pl-11 pr-4 py-4 bg-gray-50/50 border-gray-100 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 font-bold text-sm"
                                            type="password" name="password" placeholder="••••••••" required autocomplete="new-password" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-6 space-y-2">
                        <x-input-label for="password_confirmation" :value="__('Ulangi Kata Sandi')" class="font-black text-emerald-900 uppercase tracking-widest text-[10px] ml-1" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-emerald-500">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </span>
                            <x-text-input id="password_confirmation" class="block w-full pl-11 pr-4 py-4 bg-gray-50/50 border-gray-100 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 font-bold text-sm"
                                            type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-8">
                        <a class="text-[10px] font-black text-gray-400 hover:text-emerald-600 uppercase tracking-widest transition-colors" href="{{ route('login') }}">
                            {{ __('Sudah Punya Akun?') }}
                        </a>

                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 px-8 rounded-2xl transition-all shadow-xl shadow-emerald-200 flex items-center justify-center gap-3 text-[10px] tracking-[0.2em] uppercase active:scale-95 group">
                            <span>Daftarkan Personil</span>
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="group-hover:translate-x-1 transition-transform"><path stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>