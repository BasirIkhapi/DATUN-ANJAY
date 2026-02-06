<x-app-layout>
    {{-- HEADER: MONITORING & DETAIL --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="space-y-1">
                    <h2 class="text-2xl font-black text-slate-800 tracking-tighter uppercase leading-none">
                        @if(isset($perkaras))
                            MONITORING <span class="text-emerald-600 italic">DAFTAR PERKARA</span>
                        @else
                            PROGRES <span class="text-emerald-600 italic">TAHAPAN PERKARA</span>
                        @endif
                    </h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.4em]">
                        {{ isset($perkaras) ? 'Kelola Seluruh Data Perkara' : 'Registrasi: ' . $perkara->nomor_perkara }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4">
                @if(isset($perkaras))
                    {{-- DROPDOWN LAPORAN KHUSUS PIMPINAN --}}
                    @if(Auth::user()->role === 'pimpinan')
                        <div class="relative group">
                            <button class="flex items-center gap-3 bg-slate-900 text-white font-black py-3 px-8 rounded-2xl text-[10px] tracking-widest uppercase hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                LAPORAN & ARSIP
                            </button>
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 overflow-hidden">
                                <button onclick="document.getElementById('modalCetakPeriode').classList.remove('hidden')" 
                                    class="flex items-center gap-3 px-6 py-4 text-[10px] font-black text-slate-600 uppercase tracking-widest hover:bg-emerald-50 hover:text-emerald-600 transition-all w-full text-left">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                    Cetak Rekap Periode
                                </button>
                                <a href="{{ route('perkara.arsip') }}" class="flex items-center gap-3 px-6 py-4 text-[10px] font-black text-slate-600 uppercase tracking-widest hover:bg-emerald-50 hover:text-emerald-600 transition-all border-t border-slate-50">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                    Arsip Perkara Selesai
                                </a>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('perkara.create') }}" class="bg-slate-900 text-white font-black py-3 px-8 rounded-2xl text-[10px] tracking-widest uppercase hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200">
                            + Tambah Perkara
                        </a>
                    @endif
                @else
                    {{-- TOMBOL CETAK DETAIL --}}
                    <a href="{{ route('perkara.cetakDetail', $perkara->id) }}" target="_blank" class="group flex items-center gap-3 bg-white border-2 border-rose-600 text-rose-600 hover:bg-rose-600 hover:text-white font-black py-3 px-8 rounded-2xl transition-all duration-300 shadow-lg shadow-rose-100 uppercase text-[10px] tracking-widest active:scale-95">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Cetak Progres</span>
                    </a>

                    @if($perkara->status_akhir === 'Proses' && Auth::user()->role === 'admin')
                        <form action="{{ route('perkara.updateStatus', $perkara->id) }}" method="POST" onsubmit="return confirm('Apakah perkara ini benar-benar sudah selesai?')">
                            @csrf @method('PATCH')
                            <button type="submit" class="group flex items-center gap-3 bg-emerald-600 text-white hover:bg-emerald-700 font-black py-3 px-8 rounded-2xl transition-all duration-300 shadow-lg shadow-emerald-100 uppercase text-[10px] tracking-widest active:scale-95">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Selesaikan Perkara</span>
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfdfe] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            
            {{-- TAMPILAN 1: TABEL DAFTAR --}}
            @if(isset($perkaras))
                <div class="bg-white rounded-[4rem] shadow-xl border border-slate-100 overflow-hidden">
                    <div class="p-10 pb-6">
                        <input type="text" id="tableSearch" placeholder="Cari Perkara..." class="w-full h-14 pl-6 pr-8 bg-slate-50 border-slate-100 border-2 rounded-2xl focus:border-emerald-500 outline-none font-bold text-sm shadow-inner">
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50/50 uppercase">
                                <tr>
                                    <th class="px-10 py-7 text-[11px] font-black text-slate-400 tracking-widest">Nomor Perkara</th>
                                    <th class="px-10 py-7 text-[11px] font-black text-slate-400 tracking-widest">Pihak Terlibat</th>
                                    <th class="px-10 py-7 text-[11px] font-black text-slate-400 text-center tracking-widest">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($perkaras as $p)
                                <tr class="hover:bg-emerald-50/30 transition-all duration-300">
                                    <td class="px-10 py-8 font-black text-slate-800 uppercase italic tracking-tighter text-base">{{ $p->nomor_perkara }}</td>
                                    <td class="px-10 py-8 text-xs font-bold text-slate-500">
                                        <div class="flex flex-col gap-1 uppercase tracking-tight text-[11px]">
                                            <span class="text-emerald-700">P: {{ $p->penggugat }}</span>
                                            <span class="text-rose-700">T: {{ $p->tergugat }}</span>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8 text-center">
                                        <a href="{{ route('perkara.show', $p->id) }}" class="p-4 bg-white text-emerald-600 rounded-2xl shadow-md border border-slate-100 hover:bg-emerald-600 hover:text-white transition-all inline-block active:scale-90">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                    <tr><td colspan="3" class="py-20 text-center opacity-30 font-black uppercase tracking-[0.5em] italic">Data Perkara Kosong</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            {{-- TAMPILAN 2: DETAIL TIMELINE --}}
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-1">
                        <div class="bg-white p-10 rounded-[3rem] shadow-xl border border-slate-100 sticky top-10">
                            <h3 class="text-[10px] font-black text-slate-800 mb-8 uppercase tracking-widest italic border-b pb-4">Info Perkara</h3>
                            <div class="space-y-6">
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Jaksa JPN</p>
                                    <p class="text-sm font-bold text-slate-800">{{ $perkara->jaksa->nama_jaksa ?? 'Nama Jaksa Tidak Ada' }}</p>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Jenis Perkara</p>
                                    <p class="text-sm font-bold text-slate-800">{{ $perkara->jenis_perkara }}</p>
                                </div>
                            </div>

                            {{-- Form Update Progres (Eksklusif Admin) --}}
                            @if(Auth::user()->role === 'admin' && $perkara->status_akhir === 'Proses')
                                <div class="mt-10 pt-10 border-t border-slate-100">
                                    <h4 class="text-[10px] font-black text-emerald-600 mb-6 uppercase tracking-widest italic">Update Progres Baru</h4>
                                    <form action="{{ route('perkara.storeTahapan') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <input type="hidden" name="perkara_id" value="{{ $perkara->id }}">
                                        
                                        <div class="space-y-1">
                                            <label class="text-[9px] font-black text-slate-400 uppercase ml-2 tracking-widest">Nama Tahapan</label>
                                            <input type="text" name="nama_tahapan" required placeholder="Contoh: Replik / Duplik" class="w-full px-5 py-3 bg-slate-50 border-none rounded-2xl font-bold text-xs focus:ring-2 focus:ring-emerald-500 outline-none shadow-inner">
                                        </div>

                                        <div class="space-y-1">
                                            <label class="text-[9px] font-black text-slate-400 uppercase ml-2 tracking-widest">Tanggal</label>
                                            <input type="date" name="tanggal_tahapan" value="{{ date('Y-m-d') }}" required class="w-full px-5 py-3 bg-slate-50 border-none rounded-2xl font-bold text-xs focus:ring-2 focus:ring-emerald-500 outline-none shadow-inner">
                                        </div>

                                        <div class="space-y-1">
                                            <label class="text-[9px] font-black text-slate-400 uppercase ml-2 tracking-widest">Keterangan</label>
                                            <textarea name="keterangan" rows="2" placeholder="Hasil/Agenda Sidang..." class="w-full px-5 py-3 bg-slate-50 border-none rounded-2xl font-bold text-xs focus:ring-2 focus:ring-emerald-500 outline-none shadow-inner"></textarea>
                                        </div>

                                        <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">
                                            Simpan Progres
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="bg-white p-10 rounded-[3rem] shadow-xl border border-slate-100 min-h-[600px]">
                            <h3 class="text-[10px] font-black text-slate-800 mb-12 uppercase tracking-[0.4em] italic border-b pb-4 text-center">Timeline Progres</h3>
                            <div class="relative border-l-4 border-emerald-50 ml-6 space-y-12 pb-10 mt-8">
                                @forelse($perkara->tahapans as $tahap)
                                    <div class="relative pl-12 group">
                                        <div class="absolute -left-[14px] top-0 w-6 h-6 bg-emerald-500 rounded-full border-4 border-white shadow-lg shadow-emerald-200 transition-transform group-hover:scale-125 duration-500"></div>
                                        <div class="bg-slate-50/50 p-8 rounded-[2rem] border border-slate-100 group-hover:bg-white group-hover:shadow-2xl transition-all duration-500">
                                            <div class="flex justify-between items-center mb-4">
                                                <span class="text-[9px] font-black text-emerald-600 uppercase bg-emerald-50 px-4 py-1.5 rounded-xl">
                                                    {{ \Carbon\Carbon::parse($tahap->tanggal_tahapan)->translatedFormat('d F Y') }}
                                                </span>
                                            </div>
                                            <h4 class="font-black text-slate-900 text-sm tracking-tight italic">{{ $tahap->nama_tahapan }}</h4>
                                            <p class="text-[11px] font-bold text-slate-400 italic mt-2">{{ $tahap->keterangan ?? 'Sedang di Proses' }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="flex flex-col items-center justify-center py-20 opacity-20 text-center">
                                        <p class="text-[10px] font-black uppercase tracking-[0.4em]">Belum ada tahapan perkara terdeteksi</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- MODAL CETAK REKAP (PIMPINAN) --}}
    @if(Auth::user()->role === 'pimpinan')
    <div id="modalCetakPeriode" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
        <div class="bg-white w-full max-w-md rounded-[3rem] shadow-2xl border border-white overflow-hidden relative">
            <div class="p-10 space-y-8 relative z-10">
                <div class="text-center space-y-2">
                    <h3 class="text-xl font-black text-slate-800 uppercase italic tracking-tighter">Cetak Rekapitulasi</h3>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pilih Periode Laporan</p>
                </div>
                <form action="{{ route('perkara.cetakPeriode') }}" method="GET" target="_blank" class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] ml-2">Dari Tanggal</label>
                        <input type="date" name="tgl_mulai" required class="w-full h-14 px-6 bg-slate-50 border-slate-100 border-2 rounded-2xl font-bold text-sm focus:border-emerald-500 outline-none shadow-inner">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] ml-2">Sampai Tanggal</label>
                        <input type="date" name="tgl_selesai" required class="w-full h-14 px-6 bg-slate-50 border-slate-100 border-2 rounded-2xl font-bold text-sm focus:border-emerald-500 outline-none shadow-inner">
                    </div>
                    <div class="flex gap-4 pt-4">
                        <button type="button" onclick="document.getElementById('modalCetakPeriode').classList.add('hidden')" class="flex-1 py-4 bg-slate-100 text-slate-400 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all">Batal</button>
                        <button type="submit" class="flex-[2] py-4 bg-emerald-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition-all">Unduh PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>