<div x-data="{ modalInputOpen: false }">
    <x-app-layout>
        {{-- CSS Khusus --}}
        <style>
            [x-cloak] { display: none !important; }
            .modal-scrollbar::-webkit-scrollbar { width: 4px; }
            .modal-scrollbar::-webkit-scrollbar-track { background: #f8fafc; }
            .modal-scrollbar::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
        </style>

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
                    <button type="button" @click="modalInputOpen = true" class="group flex items-center gap-3 bg-white border-2 border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white font-black py-3 px-8 rounded-2xl transition-all duration-300 shadow-lg shadow-emerald-100 uppercase text-[10px] tracking-widest active:scale-95">
                        <span>Tambah Perkara Baru</span>
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="group-hover:rotate-90 transition-transform duration-500"><path stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    </button>
                @endif
            </div>
        </x-slot>

        <div class="py-12 bg-[#fcfdfe] min-h-screen relative overflow-hidden text-slate-900 font-sans antialiased">
            <div class="absolute top-0 right-0 w-[50%] h-[50%] bg-emerald-50/50 rounded-full blur-[120px] -z-10 translate-x-1/2 -translate-y-1/2"></div>
            
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
                <div class="bg-white rounded-[4rem] shadow-2xl border border-slate-100 overflow-hidden">
                    <div class="p-10 border-b border-slate-50 bg-gradient-to-r from-white to-emerald-50/20">
                        <div class="flex items-center gap-4">
                            <div class="w-3 h-10 bg-emerald-600 rounded-full shadow-lg shadow-emerald-200"></div>
                            <h3 class="font-black text-slate-800 italic uppercase tracking-tighter text-xl">Daftar <span class="text-emerald-600">Perkara Aktif</span></h3>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="min-w-[1200px]">
                            <div class="flex bg-slate-50/50 border-b border-slate-100 px-12 py-7 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">
                                <div class="w-[20%]">Registrasi</div>
                                <div class="w-[18%]">Para Pihak</div>
                                <div class="w-[12%] text-center">Status</div>
                                <div class="w-[25%] text-center">Tim JPN (Jaksa)</div>
                                <div class="w-[25%] text-center">Aksi Monitoring & Cetak</div>
                            </div>

                            <div class="divide-y divide-slate-50">
                                @forelse($perkaras as $perkara)
                                    <div x-data="{ modalTimelineOpen: false, modalProgresOpen: false }">
                                        <div class="group hover:bg-emerald-50/30 transition-all duration-500 px-12 py-10 flex items-center min-h-[120px]">
                                            <div class="w-[20%] pr-4 space-y-1">
                                                <div class="font-black text-[14px] text-slate-800 uppercase tracking-tighter italic truncate">{{ $perkara->nomor_perkara }}</div>
                                                <span class="inline-block px-3 py-1 bg-slate-100 text-[8px] font-black text-slate-500 uppercase rounded-lg">{{ $perkara->jenis_perkara }}</span>
                                            </div>
                                            <div class="w-[18%] pr-4 flex flex-col gap-2 uppercase font-black text-[10px] italic">
                                                <span class="text-emerald-700 truncate">P: {{ $perkara->penggugat }}</span>
                                                <span class="text-rose-700 truncate">T: {{ $perkara->tergugat }}</span>
                                            </div>
                                            <div class="w-[12%] flex justify-center text-center">
                                                <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-black text-[8px] uppercase tracking-widest border {{ $perkara->status_akhir == 'Selesai' ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-orange-100 text-orange-700 border-orange-200' }}">
                                                    {{ $perkara->status_akhir }}
                                                </span>
                                            </div>
                                            <div class="w-[25%] flex justify-center">
                                                <div class="flex items-center gap-4 p-1.5 pr-6 bg-slate-50 rounded-2xl border border-slate-100 w-[240px]">
                                                    <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-[13px] font-black text-white shadow-lg flex-shrink-0">{{ substr($perkara->jaksa->nama_jaksa ?? '?', 0, 1) }}</div>
                                                    <span class="text-[10px] font-black text-slate-700 italic uppercase truncate">{{ $perkara->jaksa->nama_jaksa ?? 'BELUM DITUNJUK' }}</span>
                                                </div>
                                            </div>
                                            <div class="w-[25%] flex justify-center items-center gap-3">
                                                <button type="button" @click="modalTimelineOpen = true" class="p-4 bg-white text-emerald-600 rounded-2xl shadow-md border border-slate-100 hover:bg-emerald-600 hover:text-white transition-all">
                                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </button>
                                                <a href="{{ route('perkara.cetakDetail', $perkara->id) }}" target="_blank" class="p-4 bg-slate-800 text-white rounded-2xl shadow-md border border-slate-700 hover:bg-slate-700 transition-all">
                                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                                </a>
                                                @if(Auth::user()->role === 'admin')
                                                <form action="{{ route('perkara.destroy', $perkara->id) }}" method="POST" onsubmit="return confirm('Hapus perkara ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-4 bg-rose-50 text-rose-600 rounded-2xl shadow-md border border-rose-100 hover:bg-rose-600 hover:text-white transition-all">
                                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- MODAL TIMELINE --}}
                                        <template x-teleport="body">
                                            <div x-show="modalTimelineOpen" x-transition x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm">
                                                <div @click.away="modalTimelineOpen = false" class="relative w-full max-w-2xl bg-white rounded-[3.5rem] shadow-2xl p-10">
                                                    <div class="flex justify-between items-start mb-8">
                                                        <div><h4 class="text-2xl font-black text-slate-800 uppercase italic">Timeline <span class="text-emerald-600">Perkara</span></h4><p class="text-[10px] font-bold text-slate-400 mt-1 uppercase">{{ $perkara->nomor_perkara }}</p></div>
                                                        <button @click="modalTimelineOpen = false" class="text-slate-400 hover:text-rose-500 transition-all"><svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg></button>
                                                    </div>
                                                    <div class="max-h-[45vh] overflow-y-auto pr-4 modal-scrollbar text-left">
                                                        @forelse($perkara->tahapans->sortByDesc('tanggal_tahapan') as $tahapan)
                                                            <div class="flex gap-6 mb-8 relative">
                                                                <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center text-white shrink-0 z-10 shadow-lg"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                                                                <div class="bg-slate-50 p-5 rounded-3xl border border-slate-100 w-full">
                                                                    <span class="text-[9px] font-black text-emerald-600 uppercase">{{ \Carbon\Carbon::parse($tahapan->tanggal_tahapan)->translatedFormat('d M Y') }}</span>
                                                                    <h5 class="text-[12px] font-black text-slate-800 uppercase mt-1">{{ $tahapan->nama_tahapan }}</h5>
                                                                    <p class="text-[10px] text-slate-500 mt-2 italic leading-relaxed">{{ $tahapan->keterangan }}</p>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="py-10 text-center opacity-30 italic font-black text-[11px] uppercase">Data Tahapan Belum Diinput</div>
                                                        @endforelse
                                                    </div>
                                                    <div class="mt-8 pt-6 border-t border-slate-50 flex justify-end">
                                                        <button @click="modalTimelineOpen = false; modalProgresOpen = true" class="px-6 py-3 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase hover:bg-emerald-600 transition-all italic">Input Progres Baru &rarr;</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        {{-- MODAL INPUT PROGRES TAHAPAN (WITH TOGGLE SELESAI) --}}
                                        <template x-teleport="body">
                                            <div x-show="modalProgresOpen" x-transition x-cloak class="fixed inset-0 z-[130] flex items-center justify-center bg-emerald-950/70 backdrop-blur-md">
                                                <div @click.away="modalProgresOpen = false" class="relative w-full max-w-xl bg-white rounded-[3.5rem] shadow-2xl p-12 text-left">
                                                    <div class="flex justify-between items-start mb-8">
                                                        <div><h4 class="text-2xl font-black text-slate-800 uppercase italic">Input <span class="text-emerald-600">Progres Tahapan</span></h4><p class="text-[10px] font-bold text-slate-400 mt-1 uppercase">{{ $perkara->nomor_perkara }}</p></div>
                                                        <button @click="modalProgresOpen = false" class="p-2 text-slate-400 hover:text-rose-500 transition-all"><svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg></button>
                                                    </div>

                                                    <form action="{{ route('perkara.storeTahapan') }}" method="POST" class="space-y-6">
                                                        @csrf
                                                        <input type="hidden" name="perkara_id" value="{{ $perkara->id }}">
                                                        
                                                        <div class="space-y-2">
                                                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Nama Tahapan Perkara</label>
                                                            <input type="text" name="nama_tahapan" required placeholder="Contoh: Sidang Putusan" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 font-bold text-slate-700">
                                                        </div>

                                                        <div class="space-y-2">
                                                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Tanggal Pelaksanaan</label>
                                                            <input type="date" name="tanggal_tahapan" required value="{{ date('Y-m-d') }}" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 font-bold text-slate-700">
                                                        </div>

                                                        <div class="space-y-2">
                                                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Keterangan Singkat</label>
                                                            <textarea name="keterangan" rows="3" placeholder="Hasil sidang atau catatan perkembangan..." class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 font-bold text-slate-700"></textarea>
                                                        </div>

                                                        {{-- TOGGLE SELESAIKAN PERKARA --}}
                                                        <div class="p-6 bg-emerald-50 rounded-3xl border border-emerald-100 flex items-center justify-between group">
                                                            <div class="flex items-center gap-4">
                                                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-emerald-600 shadow-sm"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                                                <div>
                                                                    <p class="text-[11px] font-black text-emerald-800 uppercase leading-none">Selesaikan Perkara?</p>
                                                                    <p class="text-[9px] text-emerald-600/60 font-bold mt-1 italic uppercase">Ubah status ke 'Selesai'</p>
                                                                </div>
                                                            </div>
                                                            <label class="relative inline-flex items-center cursor-pointer">
                                                                <input type="checkbox" name="set_selesai" value="1" class="sr-only peer">
                                                                <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                                            </label>
                                                        </div>

                                                        <div class="flex justify-end gap-4 pt-4">
                                                            <button type="button" @click="modalProgresOpen = false; modalTimelineOpen = true" class="px-8 py-4 bg-slate-100 text-slate-400 rounded-3xl font-black uppercase text-[10px]">Batal</button>
                                                            <button type="submit" class="px-8 py-4 bg-emerald-600 text-white rounded-3xl font-black uppercase text-[10px] hover:bg-emerald-700 shadow-lg italic transition-all active:scale-95">Simpan & Selesaikan &rarr;</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                @empty
                                    <div class="py-40 text-center italic font-black text-slate-300 uppercase tracking-widest text-[11px]">Database Kosong</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL INPUT PERKARA BARU (HEADER) --}}
        <template x-teleport="body">
            <div x-show="modalInputOpen" x-transition x-cloak class="fixed inset-0 z-[120] flex items-center justify-center bg-emerald-950/70 backdrop-blur-md">
                <div @click.away="modalInputOpen = false" class="relative w-full max-w-4xl bg-white rounded-[4rem] shadow-2xl p-12 overflow-hidden text-left">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50 rounded-bl-full -mr-20 -mt-20 opacity-50"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-10">
                            <div><h3 class="text-3xl font-black text-slate-800 uppercase tracking-tighter italic">Registrasi <span class="text-emerald-600">Perkara Baru</span></h3><p class="text-[10px] font-bold text-slate-400 uppercase mt-2 tracking-widest">Input Data Monitoring Perdata & TUN</p></div>
                            <button type="button" @click="modalInputOpen = false" class="p-4 bg-slate-50 rounded-2xl text-slate-400 hover:text-rose-500 transition-all"><svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        </div>
                        <form action="{{ route('perkara.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">
                            @csrf
                            <div class="space-y-2"><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Nomor Perkara</label><input type="text" name="nomor_perkara" required placeholder="01/Pdt.G/2026/PN Bjm" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 font-bold text-slate-700"></div>
                            <div class="space-y-2"><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">JPN</label><select name="jaksa_id" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-700">@foreach(\App\Models\Jaksa::all() as $jaksa)<option value="{{ $jaksa->id }}">{{ $jaksa->nama_jaksa }}</option>@endforeach</select></div>
                            <div class="space-y-2"><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Penggugat</label><input type="text" name="penggugat" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-700"></div>
                            <div class="space-y-2"><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Tergugat</label><input type="text" name="tergugat" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-700"></div>
                            <div class="space-y-2"><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Klasifikasi</label><select name="jenis_perkara" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-700"><option value="PERDATA">PERDATA</option><option value="TATA USAHA NEGARA">TATA USAHA NEGARA</option></select></div>
                            <div class="space-y-2"><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Tanggal</label><input type="date" name="tanggal_masuk" required value="{{ date('Y-m-d') }}" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-700"></div>
                            <div class="md:col-span-2 mt-8 flex justify-end gap-4">
                                <button type="button" @click="modalInputOpen = false" class="px-10 py-4 bg-slate-100 text-slate-400 rounded-3xl font-black uppercase text-[10px]">Batal</button>
                                <button type="submit" class="px-10 py-4 bg-emerald-600 text-white rounded-3xl font-black uppercase text-[10px] shadow-xl italic">Simpan Registrasi &rarr;</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </x-app-layout>
</div>