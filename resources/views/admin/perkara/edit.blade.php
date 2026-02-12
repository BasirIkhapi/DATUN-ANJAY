<x-app-layout>
    {{-- CSS Khusus dropdown dan upload --}}
    <style>
        .clean-select { -webkit-appearance: none !important; -moz-appearance: none !important; appearance: none !important; background-image: none !important; }
        .clean-select::-ms-expand { display: none !important; }
        .upload-area:hover { border-color: #f43f5e; background-color: #fff1f2; }
    </style>

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4 text-left">
                <div class="p-3 bg-gradient-to-br from-rose-600 to-rose-800 rounded-2xl shadow-lg shadow-rose-100 transition-transform hover:scale-105 duration-300">
                    <svg width="22" height="22" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-xl text-slate-800 leading-tight uppercase tracking-tight">
                        Edit / Revisi <span class="text-rose-600">Data Perkara</span>
                    </h2>
                    <p class="text-[9px] font-bold text-slate-400 tracking-[0.2em] uppercase mt-0.5 leading-none">{{ $perkara->nomor_perkara }}</p>
                </div>
            </div>
            
            <a href="{{ route('perkara.index') }}" class="group flex items-center gap-2 px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-[10px] font-black uppercase text-slate-500 hover:border-emerald-500 hover:text-emerald-600 transition-all tracking-widest shadow-sm">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="group-hover:-translate-x-1 transition-transform"><path stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Pantauan
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-[#f8fafc] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ALERT: JIKA ADA PENOLAKAN DARI STAFF --}}
            @if($perkara->alasan_penolakan)
                <div class="mb-8 p-8 bg-rose-50 border-l-8 border-rose-500 rounded-[2.5rem] shadow-xl shadow-rose-100/50 flex items-start gap-6 animate-pulse text-left">
                    <div class="p-3 bg-white rounded-2xl text-rose-600 shadow-sm shrink-0">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-rose-800 uppercase tracking-widest mb-1">Catatan Revisi dari Staff:</h4>
                        <p class="text-xs font-bold text-rose-600 italic leading-relaxed">"{{ $perkara->alasan_penolakan }}"</p>
                        <p class="text-[9px] font-black text-rose-400 uppercase mt-3 tracking-tighter">*Harap unggah ulang berkas SKK yang sesuai</p>
                    </div>
                </div>
            @endif

            {{-- FORM CARD UTAMA --}}
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-200/60 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-rose-500 via-rose-400 to-rose-600"></div>
                
                <div class="p-10 md:p-12">
                    <form action="{{ route('perkara.update', $perkara->id) }}" method="POST" enctype="multipart/form-data" class="space-y-10 text-left">
                        @csrf
                        @method('PATCH')
                        
                        {{-- SECTION 1: IDENTITAS --}}
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 text-left">
                                <div class="w-8 h-[2px] bg-slate-800"></div>
                                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] italic">1. Informasi Dasar Perkara</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">
                                <div class="space-y-2.5">
                                    <label for="nomor_perkara" class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nomor Registrasi Perkara</label>
                                    <input type="text" id="nomor_perkara" name="nomor_perkara" value="{{ old('nomor_perkara', $perkara->nomor_perkara) }}" required 
                                        class="w-full h-14 px-6 bg-slate-50 border-slate-200 border-2 rounded-2xl focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 font-bold text-slate-700 transition-all outline-none text-sm shadow-sm">
                                </div>
                                
                                <div class="space-y-2.5">
                                    <label for="jaksa_id" class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jaksa Pengacara Negara (JPN)</label>
                                    <div class="relative group">
                                        <select id="jaksa_id" name="jaksa_id" required 
                                            class="clean-select w-full h-14 pl-6 pr-12 bg-slate-50 border-slate-200 border-2 rounded-2xl focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 font-bold text-slate-700 transition-all outline-none text-sm cursor-pointer shadow-sm">
                                            @foreach($jaksas as $jaksa)
                                                <option value="{{ $jaksa->id }}" {{ old('jaksa_id', $perkara->jaksa_id) == $jaksa->id ? 'selected' : '' }}>
                                                    {{ strtoupper($jaksa->nama_jaksa) }} (NIP. {{ $jaksa->nip }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-5 top-1/2 -translate-y-1/2 text-rose-600 pointer-events-none transition-colors">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="stroke-[3]"><path d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 2: REVISI SKK --}}
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 text-left">
                                <div class="w-8 h-[2px] bg-rose-500"></div>
                                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] italic">2. Lampiran Berkas Kuasa (Revisi)</h3>
                            </div>

                            <div class="space-y-4">
                                <label for="file_skk" class="text-[10px] font-black text-rose-600 uppercase tracking-widest ml-1 flex items-center gap-2">
                                    Revisi Surat Kuasa Khusus (Format PDF)
                                </label>
                                
                                <div class="upload-area relative group p-10 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2.5rem] transition-all duration-300 flex flex-col items-center justify-center gap-4 cursor-pointer">
                                    <input type="file" id="file_skk" name="file_skk" 
                                        class="absolute inset-0 opacity-0 cursor-pointer z-10"
                                        accept="application/pdf">
                                    
                                    <div class="p-4 bg-white rounded-2xl shadow-sm text-rose-500 group-hover:scale-110 transition-transform duration-300">
                                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    </div>
                                    
                                    <div class="text-center">
                                        <p class="text-[10px] font-black text-slate-700 uppercase tracking-widest mb-1">Pilih Berkas Baru untuk Mengganti</p>
                                        <p class="text-[8px] text-slate-400 font-bold italic">File lama akan otomatis terhapus</p>
                                    </div>
                                </div>

                                {{-- Informasi Berkas Sekarang --}}
                                @if($perkara->file_skk)
                                    <div class="mt-4 px-6 py-4 bg-emerald-50 rounded-2xl border border-emerald-100 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1.01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                            <p class="text-[9px] font-black text-emerald-800 uppercase tracking-widest">Berkas Saat Ini Tersedia</p>
                                        </div>
                                        <a href="{{ asset('storage/skk/' . $perkara->file_skk) }}" target="_blank" class="text-[8px] font-black text-white px-4 py-2 bg-emerald-600 rounded-xl uppercase hover:bg-emerald-700 transition-all">Lihat Berkas Lama</a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- ACTION BUTTON --}}
                        <div class="pt-6">
                            <button type="submit" class="group relative w-full h-20 bg-slate-900 rounded-3xl overflow-hidden transition-all hover:shadow-2xl hover:shadow-rose-200 active:scale-[0.98]">
                                <div class="absolute inset-0 bg-gradient-to-r from-rose-600 to-rose-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative flex items-center justify-center gap-4 text-white text-left">
                                    <svg width="22" height="22" class="transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                    <span class="font-black text-[11px] uppercase tracking-[0.4em]">Perbarui & Kirim Verifikasi Ulang</span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <p class="mt-8 text-center text-[9px] font-bold text-slate-400 uppercase tracking-widest italic">
                Sistem Otoritas Administrasi - Kejaksaan Negeri Banjarmasin
            </p>
        </div>
    </div>
</x-app-layout>