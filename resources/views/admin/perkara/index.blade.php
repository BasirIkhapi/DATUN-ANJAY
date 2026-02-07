<x-app-layout>
    {{-- HEADER HALAMAN --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="relative group">
                    <div class="absolute -inset-1.5 bg-gradient-to-r from-emerald-600 to-teal-500 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-1000"></div>
                    <div class="relative p-4 bg-white rounded-2xl shadow-sm border border-emerald-50 flex items-center">
                        <svg width="28" height="28" class="text-emerald-600 transform group-hover:scale-110 transition-all duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <h2 class="text-2xl font-black text-slate-800 tracking-tighter uppercase leading-none">
                        PANTAUAN <span class="text-emerald-600 italic">PERKARA</span>
                    </h2>
                    <div class="flex items-center gap-3">
                        <div class="h-[2px] w-8 bg-emerald-500"></div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.4em]">Monitoring Registrasi & Progress Perkara</p>
                    </div>
                </div>
            </div>
            
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('perkara.create') }}" class="group flex items-center gap-3 bg-white border-2 border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white font-black py-3 px-8 rounded-2xl transition-all duration-300 shadow-lg shadow-emerald-100 uppercase text-[10px] tracking-widest active:scale-95">
                    <span>Tambah Perkara Baru</span>
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="group-hover:rotate-90 transition-transform duration-500"><path stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfdfe] min-h-screen relative overflow-hidden text-slate-900">
        {{-- Background Decoration --}}
        <div class="absolute top-0 right-0 w-[50%] h-[50%] bg-emerald-50/50 rounded-full blur-[120px] -z-10 translate-x-1/2 -translate-y-1/2"></div>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            
            {{-- TABEL MONITORING LENGKAP --}}
            <div class="bg-white rounded-[4rem] shadow-2xl border border-slate-100 overflow-hidden">
                
                <div class="p-10 border-b border-slate-50 bg-gradient-to-r from-white to-emerald-50/20 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-3 h-10 bg-emerald-600 rounded-full shadow-lg shadow-emerald-200"></div>
                        <h3 class="font-black text-slate-800 italic uppercase tracking-tighter text-xl">
                            Daftar <span class="text-emerald-600">Perkara Aktif</span>
                        </h3>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <div class="min-w-[1100px]">
                        
                        {{-- HEADER KOLOM --}}
                        <div class="flex bg-slate-50/50 border-b border-slate-100 px-12 py-7 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">
                            <div class="w-[22%]">Registrasi</div>
                            <div class="w-[20%]">Para Pihak</div>
                            <div class="w-[15%] text-center">Status</div>
                            <div class="w-[28%] text-center">Tim JPN (Jaksa)</div>
                            <div class="w-[15%] text-center">Aksi</div>
                        </div>

                        {{-- BODY DATA --}}
                        <div class="divide-y divide-slate-50">
                            @forelse($perkaras as $perkara)
                                <div class="group hover:bg-emerald-50/30 transition-all duration-500 px-12 py-10 flex items-center min-h-[120px]">
                                    
                                    {{-- 1. Registrasi --}}
                                    <div class="w-[22%] pr-4 space-y-1">
                                        <div class="font-black text-[14px] text-slate-800 uppercase tracking-tighter italic group-hover:text-emerald-600 transition-colors truncate">
                                            {{ $perkara->nomor_perkara }}
                                        </div>
                                        <span class="inline-block px-3 py-1 bg-slate-100 text-[8px] font-black text-slate-500 uppercase tracking-widest rounded-lg">
                                            {{ $perkara->jenis_perkara }}
                                        </span>
                                    </div>

                                    {{-- 2. Para Pihak --}}
                                    <div class="w-[20%] pr-4 flex flex-col gap-2 uppercase font-black text-[10px] tracking-tighter italic">
                                        <div class="flex items-center gap-2">
                                            <span class="w-4 h-4 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center text-[8px] font-black">P</span>
                                            <span class="text-emerald-700 truncate">{{ $perkara->penggugat }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="w-4 h-4 rounded-md bg-rose-100 text-rose-700 flex items-center justify-center text-[8px] font-black">T</span>
                                            <span class="text-rose-700 truncate">{{ $perkara->tergugat }}</span>
                                        </div>
                                    </div>

                                    {{-- 3. Status --}}
                                    <div class="w-[15%] flex justify-center">
                                        <span class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-black text-[9px] uppercase tracking-widest border {{ $perkara->status_akhir == 'Selesai' ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-orange-100 text-orange-700 border-orange-200' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $perkara->status_akhir == 'Selesai' ? 'bg-emerald-500' : 'bg-orange-500 animate-pulse' }}"></span>
                                            {{ $perkara->status_akhir }}
                                        </span>
                                    </div>

                                    {{-- 4. Tim JPN (Jaksa) --}}
                                    <div class="w-[28%] flex justify-center">
                                        <div class="flex items-center gap-4 p-1.5 pr-6 bg-slate-50 rounded-2xl border border-slate-100 group-hover:bg-white transition-all shadow-sm w-[260px]">
                                            <div class="w-11 h-11 bg-emerald-600 rounded-xl flex items-center justify-center text-[14px] font-black text-white shadow-lg border border-white/20 flex-shrink-0">
                                                {{ substr($perkara->jaksa->nama_jaksa ?? '?', 0, 1) }}
                                            </div>
                                            <div class="flex flex-col truncate text-left">
                                                <span class="text-[10px] font-black text-slate-700 italic uppercase tracking-tighter leading-tight truncate">
                                                    {{ $perkara->jaksa->nama_jaksa ?? 'BELUM DITUNJUK' }}
                                                </span>
                                                <span class="text-[7px] font-bold text-emerald-600 uppercase tracking-widest mt-1">Personel JPN</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 5. Aksi --}}
                                    <div class="w-[15%] flex justify-center items-center gap-3">
                                        <a href="{{ route('perkara.show', $perkara->id) }}" class="p-4 bg-white text-blue-600 rounded-2xl shadow-md border border-slate-100 hover:bg-emerald-600 hover:text-white transition-all active:scale-90" title="Detail">
                                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        @if(Auth::user()->role === 'admin')
                                        <form action="{{ route('perkara.destroy', $perkara->id) }}" method="POST" onsubmit="return confirm('Hapus perkara ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-4 bg-rose-50 text-rose-600 rounded-2xl shadow-md border border-rose-100 hover:bg-rose-600 hover:text-white transition-all active:scale-95">
                                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="py-40 text-center italic font-black text-slate-300 uppercase tracking-widest text-[11px]">Database Kosong</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- FOOTER --}}
            <div class="pt-20 pb-10 flex flex-col items-center gap-6 opacity-30">
                <div class="flex items-center gap-10">
                    <div class="h-[1px] w-48 bg-gradient-to-r from-transparent via-slate-400 to-transparent"></div>
                    <img src="{{ asset('img/logo jaksa.png') }}" class="w-12 h-auto grayscale">
                    <div class="h-[1px] w-48 bg-gradient-to-l from-transparent via-slate-400 to-transparent"></div>
                </div>
                <p class="text-[11px] font-black text-slate-800 uppercase tracking-[1.5em] italic leading-none text-center">Integritas • Profesionalisme • Kejari Banjarmasin</p>
            </div>
        </div>
    </div>
</x-app-layout>