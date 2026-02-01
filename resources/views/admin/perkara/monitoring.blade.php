<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="p-3 bg-white rounded-2xl shadow-sm hover:bg-emerald-50 transition-all text-gray-400 hover:text-emerald-600 border border-gray-100">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h2 class="font-black text-2xl text-emerald-900 leading-tight uppercase tracking-tight">DETAIL <span class="text-emerald-600">MONITORING</span></h2>
                    <p class="text-[10px] font-black text-gray-400 tracking-[0.2em] uppercase mt-1 italic">REGISTRASI: {{ $perkara->nomor_perkara }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('perkara.cetak', $perkara->id) }}" target="_blank" 
                    class="bg-white text-red-600 px-6 py-3 rounded-2xl font-black text-[10px] tracking-widest uppercase shadow-xl border border-red-50 hover:bg-red-50 transition-all flex items-center gap-2">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Progres
                </a>

                @if($perkara->status_akhir !== 'Selesai')
                    <form action="{{ route('perkara.updateStatus', $perkara->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" onclick="return confirm('Selesaikan perkara ini?')" 
                            class="bg-emerald-600 text-white px-6 py-3 rounded-2xl font-black text-[10px] tracking-widest uppercase shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition-all active:scale-95 flex items-center gap-2">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            Tandai Selesai
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-emerald-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 font-bold uppercase tracking-widest shadow-lg animate-bounce">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl shadow-emerald-900/5 border border-white grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="space-y-2">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pihak Penggugat</p>
                    <p class="font-black text-gray-800 uppercase tracking-tight">{{ $perkara->penggugat }}</p>
                </div>
                <div class="space-y-2">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pihak Tergugat</p>
                    <p class="font-black text-gray-800 uppercase tracking-tight">{{ $perkara->tergugat }}</p>
                </div>
                <div class="space-y-2">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Jaksa Pendamping (JPN)</p>
                    <p class="font-black text-emerald-600 uppercase tracking-tight">{{ $perkara->jaksa->nama_jaksa ?? 'BELUM DITUNJUK' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl shadow-emerald-900/5 border border-white sticky top-28">
                        <h3 class="text-[10px] font-black text-gray-800 mb-8 uppercase tracking-[0.3em] flex items-center gap-3 italic">
                            <span class="w-8 h-[2px] bg-emerald-500"></span> Input Progres Baru
                        </h3>
                        
                        @if($perkara->status_akhir !== 'Selesai')
                            <form action="{{ route('tahapan.store', $perkara->id) }}" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="perkara_id" value="{{ $perkara->id }}">
                                
                                <div class="space-y-1">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal Kegiatan</label>
                                    <input type="date" name="tanggal_tahapan" value="{{ date('Y-m-d') }}" required class="w-full px-6 py-4 bg-gray-50 border-gray-100 border-2 rounded-2xl font-bold text-sm focus:ring-emerald-500 focus:border-emerald-500">
                                </div>

                                <div class="space-y-1">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Tahapan Sidang</label>
                                    <input type="text" name="nama_tahapan" placeholder="CONTOH: MEDIASI / JAWABAN" required class="w-full px-6 py-4 bg-gray-50 border-gray-100 border-2 rounded-2xl font-bold text-sm uppercase focus:ring-emerald-500 focus:border-emerald-500">
                                </div>

                                <div class="space-y-1">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Hasil / Keterangan</label>
                                    <textarea name="keterangan" rows="4" placeholder="MASUKKAN HASIL KEGIATAN..." class="w-full px-6 py-4 bg-gray-50 border-gray-100 border-2 rounded-2xl font-bold text-sm uppercase focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                                </div>

                                <button type="submit" class="w-full py-5 bg-gray-900 text-white rounded-2xl font-black text-[10px] tracking-[0.3em] uppercase hover:bg-emerald-600 transition-all shadow-xl active:scale-95">
                                    Simpan Progres Sidang
                                </button>
                            </form>
                        @else
                            <div class="p-6 bg-red-50 rounded-2xl border border-red-100">
                                <p class="text-[10px] font-black text-red-600 uppercase text-center italic leading-relaxed">Perkara telah selesai diarsipkan. Penambahan tahapan dinonaktifkan.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl shadow-emerald-900/5 border border-white min-h-[600px]">
                        <h3 class="text-[10px] font-black text-gray-800 mb-12 uppercase tracking-[0.3em] flex items-center gap-3 italic">
                            <span class="w-8 h-[2px] bg-emerald-500"></span> Timeline Kegiatan Sidang
                        </h3>
                        
                        <div class="relative border-l-4 border-emerald-50 ml-6 space-y-12 pb-10">
                            @forelse($perkara->tahapans as $tahap)
                                <div class="relative pl-12 group">
                                    <div class="absolute -left-[14px] top-0 w-6 h-6 bg-emerald-500 rounded-full border-4 border-white shadow-lg shadow-emerald-200 transition-transform group-hover:scale-125"></div>
                                    <div class="bg-gray-50/50 p-6 rounded-3xl border border-gray-100 transition-all group-hover:bg-white group-hover:shadow-xl">
                                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
                                            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-lg">
                                                {{ \Carbon\Carbon::parse($tahap->tanggal_tahapan)->translatedFormat('d F Y') }}
                                            </span>
                                            <h4 class="font-black text-gray-900 uppercase text-sm tracking-tight italic">{{ $tahap->nama_tahapan }}</h4>
                                        </div>
                                        <p class="text-xs font-bold text-gray-500 uppercase leading-relaxed italic border-t border-gray-100 pt-4">
                                            {{ $tahap->keterangan ?? 'TIDAK ADA CATATAN HASIL KEGIATAN' }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-32 opacity-20 italic">
                                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mb-4"><path stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="text-[10px] font-black uppercase tracking-[0.4em]">Belum ada data progres tahapan</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>