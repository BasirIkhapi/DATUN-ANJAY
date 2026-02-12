<div x-data="{ modalInputOpen: false }">
    <x-app-layout>
        {{-- CSS Khusus --}}
        <style>
            [x-cloak] { display: none !important; }
            .modal-scrollbar::-webkit-scrollbar { width: 4px; }
            .modal-scrollbar::-webkit-scrollbar-track { background: #f8fafc; }
            .modal-scrollbar::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
            .table-custom-layout { table-layout: auto; width: 100%; border-collapse: collapse; }
            
            @keyframes soft-pulse {
                0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.4); }
                70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(249, 115, 22, 0); }
                100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(249, 115, 22, 0); }
            }
            .status-proses-active { animation: soft-pulse 2s infinite; background-color: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; }
            .btn-action-square { display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 12px; transition: all 0.3s ease; }
        </style>

        <x-slot name="header">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 text-left">
                <div class="flex items-center gap-6">
                    <div class="p-4 bg-white rounded-2xl shadow-sm border border-emerald-50 flex items-center transition-all hover:rotate-6">
                        <svg width="28" height="28" class="text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div class="space-y-1 text-left">
                        <h2 class="text-2xl font-black text-slate-800 tracking-tighter uppercase leading-none text-left">PANTAUAN <span class="text-emerald-600 italic">PERKARA</span></h2>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.4em]">Monitoring Registrasi & Progress Perkara</p>
                    </div>
                </div>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('perkara.create') }}" class="bg-white border-2 border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white font-black py-3 px-8 rounded-2xl transition-all shadow-lg text-[10px] tracking-widest uppercase">+ Registrasi Perkara</a>
                @endif
            </div>
        </x-slot>

        <div class="py-12 bg-[#fcfdfe] min-h-screen relative overflow-hidden">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
                
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-5 bg-emerald-600 text-white rounded-[2rem] shadow-xl shadow-emerald-100 flex items-center justify-between transition-all text-left">
                        <div class="flex items-center gap-4 text-left">
                            <div class="p-2 bg-white/20 rounded-lg"><svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                            <span class="font-black text-[10px] uppercase tracking-widest text-left">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="opacity-50 hover:opacity-100"><svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                @endif

                <div class="bg-white rounded-[4rem] shadow-2xl border border-slate-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="table-custom-layout min-w-[1150px]">
                            <thead>
                                <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] border-b border-slate-100">
                                    <th class="px-10 py-7 text-left w-[22%]">Registrasi</th>
                                    <th class="px-6 py-7 text-left w-[18%]">Para Pihak</th>
                                    <th class="px-6 py-7 text-left w-[25%]">Tim JPN (Jaksa)</th>
                                    <th class="px-6 py-7 text-center w-[15%]">Status Perkara</th>
                                    <th class="px-10 py-7 text-center w-[20%]">@if(Auth::user()->role === 'admin') AKSI @else MONITORING @endif</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($perkaras as $perkara)
                                    <tr id="perkara-{{ $perkara->id }}" 
                                        x-data="{ modalTimelineOpen: {{ request('open_modal') == $perkara->id ? 'true' : 'false' }} }" 
                                        class="group hover:bg-emerald-50/10 transition-all duration-500 {{ request('open_modal') == $perkara->id ? 'bg-emerald-50/50' : '' }}">
                                        
                                        <td class="px-10 py-8 align-middle text-left">
                                            <div class="font-black text-[14px] text-slate-800 uppercase italic leading-tight text-left">{{ $perkara->nomor_perkara }}</div>
                                            <span class="inline-block px-3 py-1 bg-slate-100 text-[8px] font-black text-slate-500 uppercase rounded-lg mt-2">{{ $perkara->jenis_perkara }}</span>
                                        </td>

                                        <td class="px-6 py-8 align-middle text-left text-xs font-black italic uppercase text-emerald-700">
                                            <div class="truncate text-left">P: {{ $perkara->penggugat }}</div>
                                            <div class="text-rose-700 truncate mt-1 text-left">T: {{ $perkara->tergugat }}</div>
                                        </td>
                                        
                                        <td class="px-6 py-8 align-middle text-left font-black text-[10px] text-slate-700 uppercase italic">
                                            {{ strtoupper($perkara->jaksa->nama_jaksa ?? 'BELUM DITUNJUK') }}
                                        </td>
                                        
                                        <td class="px-6 py-8 align-middle text-center">
                                            <div class="flex flex-col items-center gap-2">
                                                {{-- LABEL 1: STATUS VERIFIKASI --}}
                                                @if($perkara->is_verified)
                                                    <span class="inline-flex px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 font-black text-[7px] uppercase tracking-tighter border border-emerald-100">SKK Terverifikasi</span>
                                                @elseif($perkara->alasan_penolakan)
                                                    <span class="inline-flex px-3 py-1 rounded-full bg-rose-50 text-rose-600 font-black text-[7px] uppercase tracking-tighter border border-rose-100">SKK Ditolak</span>
                                                @else
                                                    <span class="inline-flex px-3 py-1 rounded-full bg-amber-50 text-amber-600 font-black text-[7px] uppercase tracking-tighter animate-pulse border border-amber-100">Menunggu Staff</span>
                                                @endif

                                                {{-- LABEL 2: STATUS PROGRES (REVISI WARNA HIJAU) --}}
                                                @if($perkara->status_akhir == 'Selesai')
                                                    <span class="inline-flex px-4 py-1.5 rounded-xl bg-emerald-600 text-white font-black text-[8px] uppercase tracking-widest shadow-sm">Selesai</span>
                                                @else
                                                    <span class="inline-flex px-4 py-1.5 rounded-xl status-proses-active font-black text-[8px] uppercase tracking-widest shadow-sm">Proses</span>
                                                @endif
                                            </div>
                                        </td>
                                        
                                        <td class="px-10 py-8 align-middle">
                                            {{-- CONTAINER UNTUK MEMASTIKAN TOMBOL SEJAJAR --}}
                                            <div class="flex items-center justify-center gap-3">
                                                <button type="button" @click="modalTimelineOpen = true" class="btn-action-square bg-white text-emerald-600 shadow-md border border-slate-100 hover:bg-emerald-600 hover:text-white transition-all active:scale-95">
                                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </button>

                                                @if(Auth::user()->role === 'admin')
                                                    <form action="{{ route('perkara.destroy', $perkara->id) }}" method="POST" onsubmit="return confirm('Hapus data master perkara?')" class="m-0">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn-action-square bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-100 transition-all shadow-sm">
                                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>

                                            <template x-teleport="body">
                                                <div x-show="modalTimelineOpen" x-transition x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm px-4">
                                                    <div @click.away="modalTimelineOpen = false" class="relative w-full max-w-5xl bg-white rounded-[3.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row h-[85vh] text-left">
                                                        
                                                        {{-- PANEL KIRI: KRONOLOGIS --}}
                                                        <div class="w-full md:w-3/5 p-12 overflow-y-auto modal-scrollbar bg-white">
                                                            <div class="flex justify-between items-center mb-10 text-left">
                                                                <div class="text-left">
                                                                    <h4 class="text-2xl font-black text-slate-800 uppercase italic leading-none text-left">Kronologis <span class="text-emerald-600">Perkara</span></h4>
                                                                    <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-widest text-left">{{ $perkara->nomor_perkara }}</p>
                                                                </div>
                                                                <button @click="modalTimelineOpen = false" class="text-slate-300 hover:text-rose-500 transition-all"><svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg></button>
                                                            </div>

                                                            <div class="space-y-10 relative before:absolute before:inset-0 before:ml-5 before:w-0.5 before:bg-slate-100">
                                                                @forelse($perkara->tahapans->sortByDesc('tanggal_tahapan') as $t)
                                                                    <div class="flex gap-8 relative group text-left">
                                                                        <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center text-white shrink-0 z-10 shadow-lg"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                                                                        <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 w-full text-left">
                                                                            <div class="flex justify-between items-start mb-3 text-left">
                                                                                <span class="text-[9px] font-black text-emerald-600 uppercase bg-emerald-50 px-4 py-1.5 rounded-xl text-left">{{ \Carbon\Carbon::parse($t->tanggal_tahapan)->translatedFormat('d F Y') }}</span>
                                                                                @if($t->file_tahapan)
                                                                                    <a href="{{ asset('storage/dokumen_tahapan/' . $t->file_tahapan) }}" target="_blank" class="px-3 py-1.5 bg-rose-600 text-white rounded-lg text-[8px] font-black uppercase italic shadow-sm hover:bg-rose-500 transition-all">Lihat E-Doc</a>
                                                                                @endif
                                                                            </div>
                                                                            <h5 class="text-[12px] font-black text-slate-800 uppercase italic text-left">{{ $t->nama_tahapan }}</h5>
                                                                            <p class="text-[10px] text-slate-500 mt-3 italic leading-relaxed text-left">{{ $t->keterangan }}</p>
                                                                        </div>
                                                                    </div>
                                                                @empty
                                                                    <div class="py-20 text-center opacity-30 italic font-black text-[10px] uppercase text-center">Belum ada progres kronologis</div>
                                                                @endforelse
                                                            </div>
                                                        </div>

                                                        {{-- PANEL KANAN: ALUR REVISI --}}
                                                        <div class="w-full md:w-2/5 bg-slate-50 p-12 overflow-y-auto modal-scrollbar border-l border-slate-100 text-left">
                                                            
                                                            {{-- STAFF: HANYA VERIFIKASI --}}
                                                            @if(Auth::user()->role === 'staff')
                                                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-10 italic text-left">Otoritas Verifikasi Staff</h4>
                                                                
                                                                @if(!$perkara->is_verified)
                                                                    <div class="p-8 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm text-left">
                                                                        <label class="text-[9px] font-black text-slate-400 uppercase italic mb-4 block text-left">Lampiran SKK dari Admin</label>
                                                                        
                                                                        @if($perkara->file_skk)
                                                                            <a href="{{ asset('storage/skk/' . $perkara->file_skk) }}" target="_blank" class="mb-6 flex items-center justify-center gap-3 w-full py-4 bg-emerald-50 text-emerald-700 rounded-2xl font-black text-[10px] uppercase tracking-widest border border-emerald-100 hover:bg-emerald-100 transition-all shadow-sm">
                                                                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1.01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                                                Cek Dokumen
                                                                            </a>

                                                                            <div x-data="{ showRejectInput: false }" class="space-y-4">
                                                                                <form action="{{ route('perkara.verifikasi', $perkara->id) }}" method="POST">
                                                                                    @csrf @method('PATCH')
                                                                                    <input type="hidden" name="status" value="setuju">
                                                                                    <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black text-[10px] uppercase shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-all active:scale-95">Setujui & Verifikasi</button>
                                                                                </form>

                                                                                <button @click="showRejectInput = !showRejectInput" class="w-full py-4 bg-white text-rose-600 border border-rose-100 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-rose-50 transition-all">Tolak / Revisi</button>

                                                                                <form x-show="showRejectInput" x-transition action="{{ route('perkara.verifikasi', $perkara->id) }}" method="POST" class="mt-4 space-y-4 text-left">
                                                                                    @csrf @method('PATCH')
                                                                                    <input type="hidden" name="status" value="tolak">
                                                                                    <textarea name="alasan_penolakan" required class="w-full p-4 bg-slate-50 rounded-2xl border-none text-[10px] font-bold text-left" placeholder="Tulis alasan revisi..."></textarea>
                                                                                    <button type="submit" class="w-full py-3 bg-rose-600 text-white rounded-xl font-black text-[9px] uppercase tracking-widest">Kirim Penolakan</button>
                                                                                </form>
                                                                            </div>
                                                                        @else
                                                                            <div class="py-10 text-center opacity-40 italic font-black text-[9px] uppercase text-center">Menunggu Admin Unggah SKK</div>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="h-full flex flex-col items-center justify-center text-center opacity-40">
                                                                        <div class="p-4 bg-emerald-100 text-emerald-600 rounded-full mb-4">
                                                                            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                                        </div>
                                                                        <p class="text-[10px] font-black uppercase italic tracking-widest leading-relaxed text-slate-500 text-center text-center">Berkas SKK Sah.<br>Progres Kini Dikelola Admin.</p>
                                                                    </div>
                                                                @endif

                                                            {{-- ADMIN: OPERASIONAL --}}
                                                            @elseif(Auth::user()->role === 'admin')
                                                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-10 italic text-left">Otoritas Operasional Admin</h4>
                                                                
                                                                @if(!$perkara->is_verified)
                                                                    <div class="p-8 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm text-left mb-6 text-left">
                                                                        @if($perkara->alasan_penolakan)
                                                                            <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl text-rose-600 text-left">
                                                                                <p class="text-[8px] font-black uppercase mb-1 text-left">Catatan Revisi:</p>
                                                                                <p class="text-[10px] font-bold italic leading-tight text-left">"{{ $perkara->alasan_penolakan }}"</p>
                                                                            </div>
                                                                        @endif

                                                                        <form action="{{ route('perkara.upload-skk', $perkara->id) }}" method="POST" enctype="multipart/form-data" class="text-left">
                                                                            @csrf
                                                                            <label class="text-[9px] font-black text-slate-800 uppercase italic mb-3 block ml-2 text-left">Unggah / Revisi SKK (Admin)</label>
                                                                            <div class="p-6 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 mb-4 text-center group hover:border-emerald-400 transition-all text-center">
                                                                                <input type="file" name="file_skk" required class="text-[10px] w-full file:bg-emerald-600 file:text-white file:rounded-lg file:border-none cursor-pointer">
                                                                            </div>
                                                                            <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition-all shadow-lg active:scale-95">Kirim Berkas ke Staff</button>
                                                                        </form>
                                                                    </div>
                                                                @else
                                                                    <div class="mb-10 text-left">
                                                                        <label class="text-[9px] font-black text-slate-400 uppercase italic mb-3 block ml-2 text-left">Arsip SKK Terverifikasi</label>
                                                                        <div class="p-4 bg-white rounded-2xl border border-emerald-100 flex items-center justify-between shadow-sm text-left">
                                                                            <div class="flex items-center gap-3 text-left">
                                                                                <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600"><svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1.01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                                                                                <p class="text-[9px] font-black text-emerald-800 uppercase tracking-widest leading-none text-left">Berkas Sah</p>
                                                                            </div>
                                                                            <a href="{{ asset('storage/skk/' . $perkara->file_skk) }}" target="_blank" class="px-4 py-2 bg-emerald-600 text-white rounded-xl font-black text-[8px] uppercase hover:bg-emerald-700 shadow-md transition-all text-left">Buka Dokumen</a>
                                                                        </div>
                                                                    </div>

                                                                    @if($perkara->status_akhir == 'Proses')
                                                                        <form action="{{ route('perkara.storeTahapan') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-left" x-data="{ isFinal: false }">
                                                                            @csrf
                                                                            <input type="hidden" name="perkara_id" value="{{ $perkara->id }}">
                                                                            <div class="text-left">
                                                                                <label class="text-[9px] font-black text-slate-500 uppercase italic mb-2 block ml-2 text-left">Tahapan Sidang</label>
                                                                                <input type="text" name="nama_tahapan" required class="w-full px-6 py-4 rounded-2xl border-none shadow-sm text-xs font-bold focus:ring-2 focus:ring-emerald-500 text-left" placeholder="Replik, Duplik, Pembuktian, dll...">
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <label class="text-[9px] font-black text-slate-500 uppercase italic mb-2 block ml-2 text-left">Tanggal</label>
                                                                                <input type="date" name="tanggal_tahapan" required value="{{ date('Y-m-d') }}" class="w-full px-6 py-4 rounded-2xl border-none shadow-sm text-xs font-bold focus:ring-2 focus:ring-emerald-500 text-left">
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <label class="text-[9px] font-black text-slate-800 uppercase italic mb-2 block ml-2 text-left text-left">
                                                                                    <span x-show="!isFinal">Unggah Berkas Sidang (PDF)</span>
                                                                                    <span x-show="isFinal" class="text-rose-600" x-cloak>Unggah Berkas Putusan Sidang (PDF)</span>
                                                                                </label>
                                                                                <div class="p-4 bg-white rounded-2xl border-2 border-dashed transition-all" :class="isFinal ? 'border-rose-200 bg-rose-50/30' : 'border-slate-200'">
                                                                                    <input type="file" name="file_tahapan" class="text-[10px] w-full file:bg-emerald-600 file:text-white file:rounded-lg file:px-4 file:py-1 file:border-none text-left">
                                                                                </div>
                                                                            </div>
                                                                            <div class="text-left">
                                                                                <label class="text-[9px] font-black text-slate-500 uppercase italic mb-2 block ml-2 text-left">Ringkasan Hasil</label>
                                                                                <textarea name="keterangan" rows="3" class="w-full px-6 py-4 rounded-2xl border-none shadow-sm text-xs font-bold focus:ring-2 focus:ring-emerald-500 text-left" placeholder="Ringkasan sidang..."></textarea>
                                                                            </div>
                                                                            <div class="flex items-center gap-4 p-5 bg-emerald-600 rounded-3xl shadow-lg shadow-emerald-100/50 transition-all hover:scale-[1.02] text-left">
                                                                                <input type="checkbox" name="set_selesai" value="1" id="sel_{{ $perkara->id }}" x-model="isFinal" class="w-5 h-5 rounded-lg text-emerald-800 border-none focus:ring-0 cursor-pointer">
                                                                                <label for="sel_{{ $perkara->id }}" class="text-[10px] font-black text-white uppercase italic cursor-pointer text-left">Tandai Selesai / Putusan Final</label>
                                                                            </div>
                                                                            <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-3xl font-black text-[10px] uppercase tracking-[0.2em] shadow-xl hover:bg-black transition-all active:scale-95 text-center">
                                                                                <span x-show="!isFinal">Simpan Progres Sidang</span>
                                                                                <span x-show="isFinal">Selesaikan & Arsipkan</span>
                                                                            </button>
                                                                        </form>
                                                                    @elseif($perkara->status_akhir == 'Selesai')
                                                                        <div class="bg-emerald-100 p-8 rounded-[2.5rem] border border-emerald-200 text-center shadow-inner text-center">
                                                                            <p class="text-[10px] font-black text-emerald-800 uppercase italic text-center">Perkara Inkracht / Selesai</p>
                                                                            <p class="text-[8px] text-emerald-600 font-bold uppercase mt-2 tracking-widest leading-none underline decoration-emerald-400 decoration-2 text-center">Arsip Digital Terkunci</p>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <p class="mt-8 text-center text-[9px] font-bold text-slate-400 uppercase tracking-widest italic text-center">
            Sistem Informasi Monitoring - Kejaksaan Negeri Banjarmasin
        </p>
    </x-app-layout>
</div>