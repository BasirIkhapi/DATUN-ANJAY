<x-app-layout>
    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="space-y-1">
                    <h2 class="text-2xl font-black text-slate-800 tracking-tighter uppercase leading-none">
                        PROGRES <span class="text-emerald-600 italic">TAHAPAN PERKARA</span>
                    </h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.4em]">
                        Nomor Perkara: {{ $perkara->nomor_perkara }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('perkara.cetakDetail', $perkara->id) }}" target="_blank" class="flex items-center gap-3 bg-white border-2 border-rose-600 text-rose-600 hover:bg-rose-600 hover:text-white font-black py-3 px-8 rounded-2xl transition-all shadow-lg shadow-rose-100 uppercase text-[10px] tracking-widest">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Cetak Monitoring</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfdfe] min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- SIDEBAR KIRI: TUGAS STAFF (POIN 1, 2, 3) --}}
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white p-10 rounded-[3rem] shadow-xl border border-slate-100 sticky top-10">
                        <h3 class="text-[10px] font-black text-slate-800 mb-8 uppercase tracking-widest italic border-b pb-4 text-center">Manajemen Berkas & E-Doc</h3>
                        
                        {{-- STATUS SKK (POIN 2) --}}
                        <div class="mb-8 p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3 text-center">Surat Kuasa Khusus (SKK)</p>
                            @if($perkara->file_skk)
                                <a href="{{ asset('storage/skk/' . $perkara->file_skk) }}" target="_blank" class="flex justify-center items-center gap-2 w-full py-3 bg-emerald-600 text-white rounded-xl text-[10px] font-black hover:bg-emerald-700 transition-all shadow-md">
                                    ✓ SKK TERSEDIA (PDF)
                                </a>
                            @else
                                <div class="text-center py-2 bg-rose-50 text-rose-500 rounded-xl text-[9px] font-black border border-rose-100 uppercase tracking-widest">SKK Belum Ada</div>
                            @endif
                        </div>

                        {{-- AKSI STAFF: VERIFIKASI (POIN 1) --}}
                        @if(Auth::user()->role === 'staff' && !$perkara->is_verified)
                            <div class="space-y-6">
                                <form action="{{ route('perkara.upload-skk', $perkara->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-2 italic">1. Unggah Scan SKK</label>
                                    <input type="file" name="file_skk" required class="w-full text-[10px] text-slate-500 file:bg-slate-800 file:text-white file:rounded-xl file:px-4 file:py-1 file:border-0">
                                    <button type="submit" class="w-full py-2 bg-slate-800 text-white rounded-xl font-black text-[9px] uppercase hover:bg-emerald-600 transition-all">Simpan Dokumen</button>
                                </form>

                                @if($perkara->file_skk)
                                <form action="{{ route('perkara.verifikasi', $perkara->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="w-full py-4 bg-amber-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-amber-100 hover:bg-amber-600 transition-all">
                                        2. Validasi & Verifikasi
                                    </button>
                                </form>
                                @endif
                            </div>
                        @endif

                        {{-- AKSI STAFF: UPDATE TAHAPAN (POIN 3) --}}
                        @if(Auth::user()->role === 'staff' && $perkara->is_verified && $perkara->status_akhir === 'Proses')
                            <div class="mt-4 pt-6 border-t border-slate-100">
                                <h4 class="text-[10px] font-black text-emerald-600 mb-6 uppercase tracking-widest italic text-center underline decoration-wavy">Update Tahapan Baru</h4>
                                <form action="{{ route('perkara.storeTahapan') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="perkara_id" value="{{ $perkara->id }}">
                                    
                                    <input type="text" name="nama_tahapan" required placeholder="Nama Tahapan (Misal: REPLIK)" class="w-full px-5 py-3 bg-slate-50 border-none rounded-2xl font-bold text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
                                    
                                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full px-5 py-3 bg-slate-50 border-none rounded-2xl font-bold text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
                                    
                                    <textarea name="keterangan" rows="2" placeholder="Keterangan hasil sidang..." class="w-full px-5 py-3 bg-slate-50 border-none rounded-2xl font-bold text-xs focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>

                                    {{-- POIN 2: UPLOAD DOKUMEN TAHAPAN --}}
                                    <div class="p-3 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                                        <label class="text-[8px] font-black text-slate-400 uppercase block mb-2">Unggah Putusan/Penetapan (PDF)</label>
                                        <input type="file" name="file_tahapan" class="text-[10px] w-full file:bg-emerald-100 file:text-emerald-700 file:rounded-lg file:px-3 file:border-0">
                                    </div>

                                    <div class="flex items-center gap-3 p-3 bg-emerald-50 rounded-xl">
                                        <input type="checkbox" name="set_selesai" id="set_selesai" class="rounded text-emerald-600">
                                        <label for="set_selesai" class="text-[9px] font-black text-emerald-700 uppercase">Tandai Perkara Selesai</label>
                                    </div>

                                    <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100">
                                        Simpan Progres Sidang
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- TIMELINE KANAN: KRONOLOGIS (POIN 4) --}}
                <div class="lg:col-span-2">
                    <div class="bg-white p-10 rounded-[3rem] shadow-xl border border-slate-100 min-h-[600px]">
                        <h3 class="text-[10px] font-black text-slate-800 mb-12 uppercase tracking-[0.4em] italic border-b pb-4 text-center">Kronologis Perkembangan Perkara</h3>
                        
                        @if(!$perkara->is_verified)
                            <div class="flex flex-col items-center justify-center py-20 text-center space-y-4 opacity-40">
                                <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-[10px] font-black uppercase tracking-widest">Menunggu Staff melakukan verifikasi berkas awal</p>
                            </div>
                        @else
                            <div class="relative border-l-4 border-emerald-50 ml-6 space-y-12 pb-10 mt-8">
                                @forelse($perkara->tahapans->sortByDesc('tanggal') as $tahap)
                                    <div class="relative pl-12 group">
                                        {{-- DOT TIMELINE --}}
                                        <div class="absolute -left-[14px] top-0 w-6 h-6 bg-emerald-500 rounded-full border-4 border-white shadow-lg transition-transform group-hover:scale-125 duration-500"></div>
                                        
                                        <div class="bg-slate-50/50 p-8 rounded-[2rem] border border-slate-100 group-hover:bg-white group-hover:shadow-2xl transition-all duration-500">
                                            <div class="flex justify-between items-center mb-4">
                                                <span class="text-[9px] font-black text-emerald-600 uppercase bg-emerald-50 px-4 py-1.5 rounded-xl">
                                                    {{ \Carbon\Carbon::parse($tahap->tanggal)->translatedFormat('d F Y') }}
                                                </span>

                                                {{-- POIN 2: DOWNLOAD PDF PUTUSAN --}}
                                                @if($tahap->file_tahapan)
                                                    <a href="{{ asset('storage/dokumen_tahapan/' . $tahap->file_tahapan) }}" target="_blank" class="flex items-center gap-2 px-4 py-1.5 bg-rose-600 text-white rounded-full text-[9px] font-black hover:scale-105 transition-all shadow-md">
                                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                        E-DOC PUTUSAN
                                                    </a>
                                                @endif
                                            </div>
                                            <h4 class="font-black text-slate-900 text-sm tracking-tight italic uppercase">{{ $tahap->nama_tahapan }}</h4>
                                            <p class="text-[11px] font-bold text-slate-400 italic mt-2">{{ $tahap->keterangan ?? 'Hasil sidang sedang diproses.' }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-20 opacity-20 font-black uppercase tracking-[0.5em] text-[10px]">Belum ada update tahapan</div>
                                @endforelse
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>