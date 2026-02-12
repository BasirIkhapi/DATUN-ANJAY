<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-6 text-left">
                <div class="p-4 bg-white rounded-2xl shadow-sm border border-emerald-50 flex items-center transition-all hover:rotate-6">
                    <svg width="28" height="28" class="text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V21a2 2 0 01-2 2h-6a2 2 0 01-2-2m0-14l6 6m-6-6H8"/>
                    </svg>
                </div>
                <div class="space-y-1 text-left">
                    <h2 class="text-2xl font-black text-slate-800 tracking-tighter uppercase leading-none text-left">
                        PUSAT DATA <span class="text-emerald-600 italic">& ARSIP</span>
                    </h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.4em] text-left">Dokumentasi & Laporan Analisis Terpadu</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfdfe] min-h-screen relative overflow-hidden text-slate-900 font-sans antialiased text-left">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10 relative z-10">
            
            {{-- BAGIAN ATAS: STATISTIK & INSTRUMEN PELAPORAN --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-emerald-900 rounded-[3rem] p-10 text-white shadow-2xl relative overflow-hidden group text-left">
                    <div class="relative z-10 text-left">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] mb-2 opacity-60 text-left">Total Arsip Selesai</p>
                        <h4 class="text-6xl font-black italic tracking-tighter text-left">{{ $perkaras->count() }}</h4>
                        <p class="mt-4 text-xs font-medium text-emerald-100/60 leading-relaxed italic uppercase text-left">Perkara Berkekuatan Hukum Tetap (Inkracht).</p>
                    </div>
                    <svg class="absolute -right-8 -bottom-8 w-40 h-40 text-white/10 -rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2m-7 3l7 7h-7V6z"/></svg>
                </div>

                <div class="md:col-span-2 bg-white rounded-[3rem] p-10 border border-slate-100 shadow-xl flex flex-col justify-center text-left">
                    <h4 class="font-black text-slate-800 uppercase text-lg mb-6 italic leading-none text-left">Instrumen <span class="text-emerald-600 font-black">Laporan Strategis</span></h4>
                    
                    <div class="flex flex-wrap gap-4">
                        {{-- 1. Rekapitulasi (DIAKSES ADMIN & STAFF) --}}
                        <a href="{{ route('perkara.arsip.cetakArsip') }}" target="_blank" class="flex items-center gap-3 bg-emerald-600 text-white px-6 py-4 rounded-2xl font-black text-[9px] uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg active:scale-95">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1.01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Rekap Arsip
                        </a>

                        {{-- FITUR EKSKLUSIF ADMIN --}}
                        @if(Auth::user()->role === 'admin')
                            {{-- 2. Laporan Stagnansi --}}
                            <a href="{{ route('perkara.arsip.stagnansi') }}" target="_blank" class="flex items-center gap-3 bg-rose-600 text-white px-6 py-4 rounded-2xl font-black text-[9px] uppercase tracking-widest hover:bg-rose-700 transition-all shadow-lg active:scale-95">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                Stagnansi
                            </a>
                            {{-- 3. Kinerja JPN --}}
                            <a href="{{ route('perkara.arsip.kinerja') }}" target="_blank" class="flex items-center gap-3 bg-slate-900 text-white px-6 py-4 rounded-2xl font-black text-[9px] uppercase tracking-widest hover:bg-black transition-all shadow-lg active:scale-95">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                Kinerja JPN
                            </a>
                            {{-- 4. Laporan Statistik --}}
                            <a href="{{ route('perkara.arsip.statistik') }}" target="_blank" class="flex items-center gap-3 bg-blue-600 text-white px-6 py-4 rounded-2xl font-black text-[9px] uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg active:scale-95">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-width="3" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                                Statistik
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- FORM FILTER PENCARIAN --}}
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm text-left">
                <form action="{{ route('perkara.arsip.index') }}" method="GET" class="flex flex-wrap items-end gap-6 text-left">
                    <div class="flex-1 min-w-[200px] text-left">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block italic text-left">Filter Bulan</label>
                        <select name="bulan" class="w-full px-6 py-4 rounded-2xl border-none bg-slate-50 text-xs font-bold focus:ring-2 focus:ring-emerald-500 text-left">
                            <option value="">Semua Bulan</option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1 min-w-[200px] text-left">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block italic text-left">Filter Tahun</label>
                        <select name="tahun" class="w-full px-6 py-4 rounded-2xl border-none bg-slate-50 text-xs font-bold focus:ring-2 focus:ring-emerald-500 text-left">
                            <option value="">Semua Tahun</option>
                            @for($y = date('Y'); $y >= 2024; $y--)
                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <button type="submit" class="px-10 py-4 bg-emerald-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">
                        Terapkan Filter
                    </button>
                    
                    @if(request()->filled('bulan') || request()->filled('tahun'))
                        <a href="{{ route('perkara.arsip.index') }}" class="px-6 py-4 bg-slate-100 text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- TABEL VALIDASI AKURASI DATA --}}
            <div class="bg-white rounded-[3.5rem] shadow-2xl border border-slate-100 overflow-hidden text-left">
                <div class="p-10 border-b border-slate-50 flex items-center justify-between bg-gradient-to-r from-white to-slate-50/30 text-left">
                    <div class="flex items-center gap-4 text-left">
                        <div class="w-2 h-8 bg-emerald-600 rounded-full shadow-lg shadow-emerald-100 text-left"></div>
                        <h3 class="font-black text-slate-800 italic uppercase tracking-tighter text-xl text-left">Validasi & <span class="text-emerald-600 font-black">Akurasi Dokumen</span></h3>
                    </div>
                    <span class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-full text-[9px] font-black uppercase tracking-widest border border-emerald-100 italic">Arsip Digital Penanganan Perkara</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50">
                            <tr class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                                <th class="px-10 py-6 text-left">Perkara Selesai</th>
                                <th class="px-6 py-6 text-center">E-Doc SKK</th>
                                <th class="px-6 py-6 text-center">E-Doc Putusan</th>
                                <th class="px-6 py-6 text-center">Durasi Proses</th>
                                <th class="px-10 py-6 text-right">Output & Administrasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($perkaras as $p)
                            <tr class="hover:bg-emerald-50/30 transition-all group text-left">
                                <td class="px-10 py-8 text-left">
                                    <div class="font-black text-slate-800 text-[13px] uppercase italic leading-none truncate mb-2 text-left">{{ $p->nomor_perkara }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider italic leading-none text-left">JPN: {{ $p->jaksa->nama_jaksa ?? 'UNASSIGNED' }}</div>
                                </td>
                                <td class="px-6 py-8 text-center">
                                    @if($p->file_skk)
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[8px] font-black uppercase tracking-widest border border-emerald-200">TERSEDIA</span>
                                    @else
                                        <span class="px-3 py-1 bg-rose-100 text-rose-600 rounded-lg text-[8px] font-black uppercase tracking-widest border border-rose-200">KOSONG</span>
                                    @endif
                                </td>
                                <td class="px-6 py-8 text-center">
                                    @php $hasDoc = $p->tahapans->whereNotNull('file_tahapan')->count() > 0; @endphp
                                    @if($hasDoc)
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[8px] font-black uppercase tracking-widest border border-emerald-200">LENGKAP</span>
                                    @else
                                        <span class="px-3 py-1 bg-amber-100 text-amber-600 rounded-lg text-[8px] font-black uppercase tracking-widest border border-amber-200">PARSIAL</span>
                                    @endif
                                </td>
                                <td class="px-6 py-8 text-center">
                                    @php
                                        $tglMasuk = \Carbon\Carbon::parse($p->tanggal_masuk);
                                        $tglSelesai = \Carbon\Carbon::parse($p->tahapans->max('tanggal_tahapan') ?? $p->updated_at);
                                        $durasi = $tglMasuk->diffInDays($tglSelesai);
                                    @endphp
                                    <span class="text-[10px] font-black text-slate-700 italic uppercase leading-none">{{ $durasi }} Hari Kerja</span>
                                </td>
                                <td class="px-10 py-8 text-right">
                                    <div class="flex items-center justify-end gap-3 text-right">
                                        <a href="{{ route('perkara.cetakLabel', $p->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-50 text-blue-600 rounded-xl border border-blue-100 hover:bg-blue-600 hover:text-white transition-all text-[9px] font-black uppercase tracking-widest shadow-sm active:scale-90" title="Cetak Label Map Fisik">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M7 7h10M7 12h10m-8 5h8M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/></svg>
                                            Label Map
                                        </a>

                                        <a href="{{ route('perkara.cetakDetail', $p->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-900 hover:text-white transition-all text-[9px] font-black uppercase tracking-widest shadow-sm active:scale-90" title="Cetak Detail Laporan">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                            Detail PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-24 text-center opacity-30 italic font-black text-[11px] uppercase tracking-[0.4em] text-center">Belum Ada Data Arsip Selesai</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- FOOTER IDENTITAS --}}
            <div class="pt-20 pb-10 flex flex-col items-center gap-6 opacity-30 text-center">
                <p class="text-[11px] font-black text-slate-800 uppercase tracking-[1.5em] italic leading-none text-center underline decoration-emerald-500">Integritas • Profesionalisme • Kejari Banjarmasin</p>
            </div>
        </div>
    </div>
</x-app-layout>