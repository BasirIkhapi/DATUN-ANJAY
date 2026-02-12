<x-app-layout>
    {{-- HEADER: MANAJEMEN PERSONEL JPN --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-6 text-left">
                <div class="relative group">
                    <div class="absolute -inset-1.5 bg-gradient-to-r from-emerald-500 to-teal-400 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-1000"></div>
                    <div class="relative p-4 bg-white rounded-2xl shadow-sm border border-emerald-50 flex items-center">
                        <svg width="28" height="28" class="text-emerald-600 transform group-hover:rotate-12 transition-all duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <h2 class="text-2xl font-black text-slate-800 tracking-tighter uppercase leading-none">
                        PERSONEL <span class="text-emerald-600 italic">JPN</span>
                    </h2>
                    <div class="flex items-center gap-3">
                        <div class="h-[2px] w-8 bg-emerald-500"></div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.4em]">Jaksa Pengacara Negara Terdaftar</p>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('jaksa.cetak') }}" target="_blank" class="group flex items-center gap-3 bg-white border-2 border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white font-black py-3 px-8 rounded-2xl transition-all duration-300 shadow-lg shadow-emerald-100 uppercase text-[10px] tracking-widest active:scale-95">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="group-hover:animate-bounce"><path stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Daftar Jaksa</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfdfe] min-h-screen relative overflow-hidden text-slate-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 relative z-10">
            
            {{-- FORM REGISTRASI: SINKRON DENGAN DATABASE --}}
            @if(Auth::user()->role === 'admin')
            <div class="bg-white p-10 rounded-[3.5rem] shadow-2xl shadow-slate-200/50 border border-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-40 h-40 bg-emerald-500/5 rounded-bl-full -mr-10 -mt-10"></div>
                
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-1.5 h-6 bg-emerald-600 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.3)]"></div>
                    <h4 class="font-black text-slate-800 uppercase text-xs tracking-[0.3em] italic text-left">Registrasi Personel Baru</h4>
                </div>
                
                <form action="{{ route('jaksa.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-4 gap-4 items-end text-left">
                    @csrf
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_jaksa" required placeholder="NAMA LENGKAP" 
                            class="w-full h-14 px-6 bg-slate-50 border-slate-100 border-2 rounded-[1.2rem] focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-slate-700 transition-all outline-none text-xs uppercase">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">NIP (18 Digit)</label>
                        {{-- FIX: Menggunakan name="nip" sesuai database --}}
                        <input type="text" name="nip" required placeholder="MASUKKAN NIP" 
                            class="w-full h-14 px-6 bg-slate-50 border-slate-100 border-2 rounded-[1.2rem] focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-slate-700 transition-all outline-none text-xs">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4">Pangkat / Golongan</label>
                        {{-- FIX: Menggunakan name="pangkat_golongan" sesuai database --}}
                        <select name="pangkat_golongan" required 
                            class="w-full h-14 px-6 bg-slate-50 border-slate-100 border-2 rounded-[1.2rem] focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-slate-700 transition-all outline-none text-xs appearance-none cursor-pointer">
                            <option value="" disabled selected>Pilih Golongan</option>
                            <option value="Jaksa Pratama (III/c)">Jaksa Pratama (III/c)</option>
                            <option value="Jaksa Muda (III/d)">Jaksa Muda (III/d)</option>
                            <option value="Jaksa Madya (IV/a)">Jaksa Madya (IV/a)</option>
                            <option value="Jaksa Utama Pratama (IV/b)">Jaksa Utama Pratama (IV/b)</option>
                        </select>
                    </div>

                    <div class="h-14">
                        <button type="submit" class="w-full h-full bg-slate-900 text-white font-black rounded-[1.2rem] shadow-xl shadow-slate-200 hover:bg-emerald-600 hover:-translate-y-1 transition-all active:scale-95 uppercase tracking-widest text-[11px]">
                            Simpan Personel
                        </button>
                    </div>
                </form>
            </div>
            @endif

            {{-- TABEL PERSONEL JPN --}}
            <div class="bg-white rounded-[4rem] shadow-2xl border border-slate-100 overflow-hidden">
                <div class="p-10 border-b border-slate-50 bg-gradient-to-r from-white via-white to-emerald-50/20 flex items-center justify-between text-left">
                    <div class="flex items-center gap-4">
                        <div class="w-3.5 h-12 bg-emerald-600 rounded-full shadow-lg shadow-emerald-200"></div>
                        <h4 class="font-black text-slate-800 uppercase text-2xl tracking-tighter italic leading-none text-left">
                            Personel JPN <span class="text-emerald-600 font-black">Aktif</span>
                        </h4>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100 uppercase tracking-[0.4em]">
                                <th class="px-10 py-7 text-[11px] font-black text-slate-400">Profil Jaksa</th>
                                <th class="px-10 py-7 text-[11px] font-black text-slate-400 text-center">Pangkat / Golongan</th>
                                <th class="px-10 py-7 text-[11px] font-black text-slate-400 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($jaksas as $jaksa)
                            <tr class="group hover:bg-emerald-50/30 transition-all duration-500">
                                <td class="px-10 py-8 text-left">
                                    <div class="flex items-center gap-5">
                                        <div class="w-14 h-14 bg-emerald-600 rounded-2xl flex items-center justify-center text-white font-black shadow-lg shadow-emerald-100 border border-white/20 text-xl italic">
                                            {{ substr($jaksa->nama_jaksa, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col text-left">
                                            <span class="font-black text-base text-slate-800 tracking-tight italic leading-tight">
                                                {{ $jaksa->nama_jaksa }}
                                            </span>
                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">NIP. {{ $jaksa->nip }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-8 text-center font-bold text-[10px] text-slate-600 uppercase tracking-tighter italic">
                                    {{ $jaksa->pangkat_golongan ?? 'Belum Diatur' }}
                                </td>
                                <td class="px-10 py-8 text-center">
                                    @if(Auth::user()->role === 'admin')
                                    <form action="{{ route('jaksa.destroy', $jaksa->id) }}" method="POST" onsubmit="return confirm('Hapus Jaksa ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-4 bg-rose-50 text-rose-600 rounded-2xl hover:bg-rose-600 hover:text-white transition-all shadow-lg shadow-rose-100/50 border border-rose-100 active:scale-90">
                                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="py-40 text-center opacity-30 italic font-black text-[10px] uppercase tracking-[0.5em]">No Personnel Records Detected</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>