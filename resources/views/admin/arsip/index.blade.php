<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="p-4 bg-white rounded-2xl shadow-sm border border-emerald-50 flex items-center">
                    <svg width="28" height="28" class="text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V21a2 2 0 01-2 2h-6a2 2 0 01-2-2m0-14l6 6m-6-6H8"/>
                    </svg>
                </div>
                <div class="space-y-1">
                    <h2 class="text-2xl font-black text-slate-800 tracking-tighter uppercase leading-none">
                        PUSAT DATA <span class="text-emerald-600 italic">& ARSIP</span>
                    </h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.4em]">Dokumentasi & Laporan Analisis Terpadu</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfdfe] min-h-screen relative overflow-hidden text-slate-900 font-sans antialiased">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 relative z-10">
            
            {{-- BAGIAN ATAS: STATISTIK UTAMA & QUICK REKAP --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-emerald-900 rounded-[3rem] p-10 text-white shadow-2xl relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] mb-2 opacity-60">Total Arsip Selesai</p>
                        <h4 class="text-6xl font-black italic tracking-tighter">{{ $total_arsip }}</h4>
                        <p class="mt-4 text-xs font-medium text-emerald-100/60 leading-relaxed italic">Perkara berkekuatan hukum tetap (Inkracht).</p>
                    </div>
                    <svg class="absolute -right-8 -bottom-8 w-40 h-40 text-white/10 -rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2m-7 3l7 7h-7V6z"/></svg>
                </div>

                <div class="md:col-span-2 bg-white rounded-[3rem] p-10 border border-slate-100 shadow-xl flex flex-col justify-center">
                    <h4 class="font-black text-slate-800 uppercase text-lg mb-4 italic">Cetak Laporan <span class="text-emerald-600">Berkala</span></h4>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('admin.perkara.rekap') }}" target="_blank" class="flex items-center gap-3 bg-slate-900 text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg active:scale-95">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Rekapitulasi Umum
                        </a>
                        <a href="{{ route('perkara.statistik') }}" target="_blank" class="flex items-center gap-3 bg-white border-2 border-slate-200 text-slate-600 px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:border-emerald-600 hover:text-emerald-600 transition-all active:scale-95">
                            Statistik Grafik
                        </a>
                    </div>
                </div>
            </div>

            {{-- BAGIAN TENGAH: GRID REPORT ANALITIS (4 CARD UTAMA) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Card 1: Efektivitas JPN --}}
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 transition-colors">
                        <svg width="24" height="24" class="text-emerald-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h5 class="font-black text-slate-800 uppercase text-[11px] tracking-widest mb-2">Kinerja JPN</h5>
                    <p class="text-[10px] text-slate-400 italic mb-6">Analisis rasio keberhasilan perkara.</p>
                    <a href="{{ route('perkara.arsip.kinerja') }}" target="_blank" class="text-[9px] font-black text-emerald-600 uppercase border-b-2 border-emerald-100 hover:border-emerald-600 transition-all">Download Report &rarr;</a>
                </div>

                {{-- Card 2: Aging Report --}}
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 transition-colors">
                        <svg width="24" height="24" class="text-blue-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h5 class="font-black text-slate-800 uppercase text-[11px] tracking-widest mb-2">Durasi Kerja</h5>
                    <p class="text-[10px] text-slate-400 italic mb-6">Rata-rata penyelesaian (hari).</p>
                    <a href="{{ route('perkara.arsip.durasi') }}" target="_blank" class="text-[9px] font-black text-blue-600 uppercase border-b-2 border-blue-100 hover:border-blue-600 transition-all">Download Report &rarr;</a>
                </div>

                {{-- Card 3: Stagnansi Report --}}
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-rose-600 transition-colors">
                        <svg width="24" height="24" class="text-rose-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <h5 class="font-black text-slate-800 uppercase text-[11px] tracking-widest mb-2">Evaluasi Macet</h5>
                    <p class="text-[10px] text-slate-400 italic mb-6">Perkara tanpa update > 14 hari.</p>
                    <a href="{{ route('perkara.arsip.stagnansi') }}" target="_blank" class="text-[9px] font-black text-rose-600 uppercase border-b-2 border-rose-100 hover:border-rose-600 transition-all">Download Report &rarr;</a>
                </div>

                {{-- Card 4: Laporan Arsip Selesai (INKRACHT) --}}
                <div class="bg-slate-900 p-8 rounded-[2.5rem] border border-slate-800 shadow-xl hover:-translate-y-2 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-bl-full -mr-10 -mt-10"></div>
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-500 transition-colors">
                        <svg width="24" height="24" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h5 class="font-black text-white uppercase text-[11px] tracking-widest mb-2">Arsip Selesai</h5>
                    <p class="text-[10px] text-slate-400 italic mb-6">Daftar perkara tuntas (Inkracht).</p>
                    <a href="{{ route('perkara.arsip.cetakArsip') }}" target="_blank" class="text-[9px] font-black text-emerald-400 uppercase border-b-2 border-emerald-900 hover:border-emerald-400 transition-all">Download Rekap &darr;</a>
                </div>
            </div>

            {{-- FOOTER IDENTITAS --}}
            <div class="pt-32 pb-10 flex flex-col items-center gap-6 opacity-30">
                <img src="{{ asset('img/logo jaksa.png') }}" class="w-12 h-auto grayscale transition-all duration-500 hover:grayscale-0">
                <p class="text-[11px] font-black text-slate-800 uppercase tracking-[1.5em] italic leading-none text-center">Integritas • Profesionalisme • Kejari Banjarmasin</p>
            </div>
        </div>
    </div>
</x-app-layout>