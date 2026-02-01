<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-black text-2xl text-emerald-900 leading-tight flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg shadow-emerald-200">
                    <svg width="24" height="24" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <span class="tracking-tight text-emerald-600 uppercase">SIM-DATUN KEJAKSAAN</span>
            </h2>
            <div class="px-5 py-2 bg-white/80 backdrop-blur-md rounded-full border border-emerald-100 shadow-sm flex items-center gap-2">
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                <span class="text-[10px] font-black text-emerald-800 uppercase tracking-widest italic">
                    {{ Auth::user()->role }}: {{ Auth::user()->name }}
                </span>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div id="alert-success" class="fixed top-24 right-5 z-[100] transform transition-all duration-500 ease-in-out">
            <div class="bg-emerald-600 text-white px-8 py-4 rounded-2xl shadow-2xl shadow-emerald-900/20 flex items-center gap-4 border border-emerald-400/30 backdrop-blur-md">
                <div class="bg-white/20 p-2 rounded-full">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80">Notifikasi Sistem</p>
                    <p class="font-bold text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>

        <script>
            setTimeout(() => {
                const alert = document.getElementById('alert-success');
                if(alert) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(20px)';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 4000);
        </script>
    @endif

    <div class="py-12 bg-gradient-to-b from-gray-50 to-emerald-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-6">
                <div class="bg-white p-6 rounded-[2rem] shadow-xl shadow-gray-200/50 border border-white flex justify-between items-center transition-all hover:shadow-emerald-100 hover:-translate-y-1">
                    <div>
                        <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Total Perkara</p>
                        <h4 class="text-4xl font-black text-gray-900 mt-1">{{ $total_perkara }}</h4>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-xl text-emerald-500">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-[2rem] shadow-xl shadow-gray-200/50 border border-white flex justify-between items-center transition-all hover:shadow-blue-100 hover:-translate-y-1">
                    <div>
                        <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Perdata</p>
                        <h4 class="text-4xl font-black text-gray-900 mt-1">{{ $perdata }}</h4>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-500">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-[2rem] shadow-xl shadow-gray-200/50 border border-white flex justify-between items-center transition-all hover:shadow-teal-100 hover:-translate-y-1">
                    <div>
                        <p class="text-[10px] font-black text-teal-600 uppercase tracking-widest">T.U.N</p>
                        <h4 class="text-4xl font-black text-gray-900 mt-1">{{ $tun }}</h4>
                    </div>
                    <div class="p-3 bg-teal-50 rounded-xl text-teal-500">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-[2rem] shadow-xl shadow-gray-200/50 border border-white flex justify-between items-center transition-all hover:shadow-orange-100 hover:-translate-y-1">
                    <div>
                        <p class="text-[10px] font-black text-orange-600 uppercase tracking-widest">Proses</p>
                        <h4 class="text-4xl font-black text-gray-900 mt-1">{{ $proses }}</h4>
                    </div>
                    <div class="p-3 bg-orange-50 rounded-xl text-orange-500">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-[2rem] shadow-xl shadow-gray-200/50 border border-white flex justify-between items-center transition-all hover:shadow-emerald-100 hover:-translate-y-1">
                    <div>
                        <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Selesai</p>
                        <h4 class="text-4xl font-black text-gray-900 mt-1">{{ $selesai }}</h4>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-xl text-emerald-500">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white/40 backdrop-blur-xl p-8 rounded-[2.5rem] border border-white shadow-xl shadow-emerald-900/5">
                <h3 class="text-[10px] font-black text-emerald-900 mb-6 uppercase tracking-[0.3em] flex items-center gap-2 italic">
                    <span class="w-8 h-[2px] bg-emerald-500"></span> Menu Navigasi & Cetak Laporan
                </h3>
                <div class="flex flex-wrap gap-4">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('perkara.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 px-8 rounded-2xl transition-all shadow-lg shadow-emerald-200 flex items-center gap-3 text-xs tracking-widest active:scale-95">
                            <span>+ TAMBAH PERKARA</span>
                        </a>
                        <a href="{{ route('jaksa.index') }}" class="bg-white hover:bg-gray-50 text-gray-800 font-black py-4 px-8 rounded-2xl transition-all border border-gray-100 shadow-sm flex items-center gap-3 text-xs tracking-widest active:scale-95">
                            <svg width="20" height="20" fill="currentColor" class="text-blue-500" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            <span>DAFTAR JAKSA</span>
                        </a>
                    @endif

                    <div class="w-full md:w-[2px] h-auto bg-gray-200 mx-2 hidden md:block opacity-30"></div>

                    <a href="{{ route('admin.perkara.rekap') }}" target="_blank" class="bg-white hover:bg-red-50 text-red-600 font-black py-4 px-6 rounded-2xl transition-all border border-red-50 shadow-sm flex items-center gap-3 text-xs tracking-widest active:scale-95">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>REKAP PERKARA</span>
                    </a>
                    <a href="{{ route('perkara.statistik') }}" target="_blank" class="bg-white hover:bg-blue-50 text-blue-600 font-black py-4 px-6 rounded-2xl transition-all border border-blue-50 shadow-sm flex items-center gap-3 text-xs tracking-widest active:scale-95">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                        <span>STATISTIK</span>
                    </a>
                    <a href="{{ route('perkara.arsip') }}" target="_blank" class="bg-white hover:bg-gray-100 text-gray-600 font-black py-4 px-6 rounded-2xl transition-all border border-gray-100 shadow-sm flex items-center gap-3 text-xs tracking-widest active:scale-95">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                        <span>ARSIP SELESAI</span>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex items-center justify-between bg-gradient-to-r from-white to-emerald-50/30">
                    <h3 class="font-black text-gray-800 flex items-center gap-3 italic uppercase tracking-tighter">
                        <div class="w-2 h-8 bg-emerald-500 rounded-full"></div> Pantauan Perkara Real-Time
                    </h3>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">SISTEM TERKONEKSI</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse uppercase">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 tracking-widest">No. Perkara</th>
                                <th class="px-6 py-5 text-[10px] font-black text-gray-400 tracking-widest">Pihak Berperkara</th>
                                <th class="px-6 py-5 text-[10px] font-black text-gray-400 tracking-widest">Jaksa (JPN)</th>
                                <th class="px-6 py-5 text-[10px] font-black text-gray-400 tracking-widest text-center">Status</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 tracking-widest text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($perkaras as $perkara)
                                <tr class="group hover:bg-emerald-50/20 transition-all duration-300">
                                    <td class="px-8 py-6">
                                        <div class="font-black text-sm text-blue-700 leading-tight">
                                            {{ $perkara->nomor_perkara }}
                                        </div>
                                        <span class="text-[9px] font-bold text-gray-400 tracking-tighter italic">MASUK: {{ \Carbon\Carbon::parse($perkara->tanggal_masuk)->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="px-6 py-6 text-[11px] font-bold">
                                        <div class="flex flex-col">
                                            <span class="text-gray-800 tracking-tighter">P: {{ $perkara->penggugat }}</span>
                                            <span class="text-gray-400 italic my-1 tracking-tighter ml-2 text-[9px]">Vs T: {{ $perkara->tergugat }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center text-[11px] font-black text-blue-600 shadow-sm">
                                                {{ substr($perkara->jaksa->nama_jaksa ?? '?', 0, 1) }}
                                            </div>
                                            <span class="text-[11px] font-black italic text-gray-700">{{ $perkara->jaksa->nama_jaksa ?? 'BELUM DITUNJUK' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full {{ $perkara->status_akhir == 'Selesai' ? 'bg-emerald-50' : 'bg-red-50' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $perkara->status_akhir == 'Selesai' ? 'bg-emerald-500' : 'bg-red-500 animate-ping' }}"></span>
                                            <span class="text-[11px] font-black {{ $perkara->status_akhir == 'Selesai' ? 'text-emerald-700' : 'text-red-700' }}">
                                                {{ $perkara->status_akhir }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <div class="flex justify-center items-center gap-3">
                                            <a href="{{ route('perkara.monitoring', $perkara->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm border border-blue-100" title="Monitor Perkara">
                                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            @if(Auth::user()->role === 'admin')
                                                <form action="{{ route('perkara.destroy', $perkara->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perkara ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-500 hover:text-white transition-all shadow-sm border border-red-100" title="Hapus Perkara">
                                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-24 text-center text-gray-400 font-black tracking-[0.3em] italic opacity-30 italic">DATABASE BELUM SINKRON</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>