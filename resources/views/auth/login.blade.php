<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-[#fcfdfe] relative overflow-hidden">
        {{-- Background Decoration serasi Dashboard --}}
        <div class="absolute top-0 right-0 w-[50%] h-[50%] bg-emerald-50/60 rounded-full blur-[120px] -z-10 translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-0 w-[40%] h-[40%] bg-blue-50/40 rounded-full blur-[100px] -z-10 -translate-x-1/4 translate-y-1/4"></div>

        <div class="w-full max-w-md px-6 relative z-10">
            {{-- LOGO AREA: EFEK FLOATING --}}
            <div class="text-center mb-12">
                <div class="inline-block relative group">
                    <div class="absolute -inset-2 bg-gradient-to-r from-emerald-500 to-teal-400 rounded-[2.5rem] blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                    <div class="relative p-6 bg-white rounded-[2.5rem] shadow-xl border border-white/50 flex items-center justify-center">
                        <img src="{{ asset('img/logo jaksa.png') }}" alt="Logo Kejaksaan" class="w-20 h-auto drop-shadow-2xl transform group-hover:scale-110 transition-transform duration-500">
                    </div>
                </div>
                <div class="mt-6 space-y-2">
                    <h1 class="text-3xl font-black text-slate-800 tracking-tighter uppercase italic leading-none">
                        SIM-<span class="text-emerald-600">DATUN</span>
                    </h1>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.4em]">Kejaksaan Negeri Banjarmasin</p>
                </div>
            </div>

            {{-- LOGIN CARD: GLASSMORPHISM STYLE --}}
            <div class="bg-white/70 backdrop-blur-2xl p-10 rounded-[3.5rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.08)] border border-white relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 via-teal-400 to-emerald-500"></div>
                
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    {{-- INPUT NIP --}}
                    <div class="space-y-2">
                        <label for="nip" class="font-black text-slate-500 uppercase tracking-[0.2em] text-[10px] ml-4 italic">Identitas Pegawai (NIP)</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-6 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            <input id="nip" type="text" name="nip" :value="old('nip')" required autofocus placeholder="Masukkan NIP Anda"
                                class="block w-full h-16 pl-14 pr-6 bg-slate-50 border-slate-100 border-2 rounded-[1.5rem] focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-slate-700 transition-all outline-none text-sm tracking-widest shadow-inner">
                        </div>
                        <x-input-error :messages="$errors->get('nip')" class="mt-2 ml-4" />
                    </div>

                    {{-- INPUT PASSWORD --}}
                    <div class="space-y-2">
                        <label for="password" class="font-black text-slate-500 uppercase tracking-[0.2em] text-[10px] ml-4 italic">Kata Sandi Sistem</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-6 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-11V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <input id="password" type="password" name="password" required placeholder="••••••••"
                                class="block w-full h-16 pl-14 pr-6 bg-slate-50 border-slate-100 border-2 rounded-[1.5rem] focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-slate-700 transition-all outline-none text-sm shadow-inner">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 ml-4" />
                    </div>

                    {{-- REMEMBER & FORGOT --}}
                    <div class="flex items-center justify-between px-2">
                        <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded-md border-slate-200 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                            <span class="ms-2 text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-emerald-600 transition-colors">Ingat Saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-[10px] font-black text-slate-400 hover:text-rose-500 uppercase tracking-widest transition-colors" href="{{ route('password.request') }}">Lupa Sandi?</a>
                        @endif
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <div class="pt-2">
                        <button type="submit" class="w-full h-16 bg-slate-900 text-white font-black py-4 px-8 rounded-[1.5rem] transition-all shadow-xl shadow-slate-200 flex items-center justify-center gap-4 text-[11px] tracking-[0.3em] uppercase active:scale-95 hover:bg-emerald-600 hover:-translate-y-1 group">
                            <span>Autentikasi Masuk</span>
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="group-hover:translate-x-2 transition-transform duration-300"><path stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- FOOTER SLOGAN --}}
            <p class="mt-12 text-center text-[10px] font-black text-slate-800/20 uppercase tracking-[1em] italic leading-none">
                INTEGRITAS • PROFESIONAL • MELAYANI
            </p>
        </div>
    </div>
</x-guest-layout>