<x-app-layout>
    {{-- HEADER: PANEL KENDALI MODERN --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="relative group">
                    <div class="absolute -inset-1.5 bg-gradient-to-r from-emerald-600 to-teal-500 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-1000"></div>
                    <div class="relative p-4 bg-white rounded-2xl shadow-sm border border-emerald-50 flex items-center">
                        <svg width="28" height="28" class="text-emerald-600 transform group-hover:scale-110 transition-all duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <h2 class="text-2xl font-black text-slate-800 tracking-tighter uppercase leading-none">
                        DASHBOARD <span class="text-emerald-600 italic">SYSTEM</span>
                    </h2>
                    <div class="flex items-center gap-3">
                        <div class="h-[2px] w-8 bg-emerald-500"></div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.4em]">
                            {{ Auth::user()->role === 'pimpinan' ? 'Otoritas Pengawas Terpusat' : 'Otoritas Datun Terpusat' }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('perkara.create') }}" class="group flex items-center gap-3 bg-white border-2 border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white font-black py-3 px-8 rounded-2xl transition-all duration-300 shadow-lg shadow-emerald-100 uppercase text-[10px] tracking-widest active:scale-95">
                        <span>Tambah Perkara Baru</span>
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="group-hover:rotate-90 transition-transform duration-500"><path stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    </a>
                @else
                    <div class="px-8 py-3 bg-emerald-50 text-emerald-700 rounded-2xl font-black text-[10px] uppercase tracking-widest border border-emerald-100 flex items-center gap-3 shadow-sm shadow-emerald-100">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        Mode Monitoring Pimpinan
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfdfe] min-h-screen relative overflow-hidden text-slate-900 font-sans antialiased">
        {{-- Background Decoration --}}
        <div class="absolute top-0 right-0 w-[50%] h-[50%] bg-emerald-50/50 rounded-full blur-[120px] -z-10 translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-[30%] h-[30%] bg-blue-50/50 rounded-full blur-[100px] -z-10 -translate-x-1/2 translate-y-1/2"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10 relative z-10">
            
            {{-- HERO SECTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 relative bg-emerald-900 rounded-[3.5rem] p-12 overflow-hidden shadow-2xl border border-white/10 animate__animated animate__fadeInLeft">
                    <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-emerald-400/10 to-transparent opacity-50"></div>
                    <div class="relative z-10 space-y-8">
                        <div class="inline-flex items-center gap-3 px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-full border border-white/10">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-ping"></span>
                            <span class="text-[10px] font-black text-emerald-100 uppercase tracking-[0.5em]">Live Monitoring Aktif</span>
                        </div>
                        <h1 class="text-6xl md:text-8xl font-black text-white leading-none tracking-tighter uppercase italic drop-shadow-2xl">
                            SIM-DATUN<br><span class="text-emerald-400">CONTROL</span>
                        </h1>
                        <p class="text-emerald-100/60 text-sm font-medium tracking-wide max-w-md italic leading-relaxed uppercase">
                            Integrasi data perkara perdata dan tata usaha negara Kejaksaan Negeri Banjarmasin.
                        </p>
                    </div>
                    <img src="{{ asset('img/logo jaksa.png') }}" class="absolute -right-10 -bottom-10 w-96 h-auto opacity-10 grayscale brightness-200 -rotate-12 pointer-events-none">
                </div>

                <div class="flex flex-col gap-6 animate__animated animate__fadeInRight">
                    <div class="flex-1 bg-white p-8 rounded-[3rem] shadow-xl border border-slate-100 flex flex-col justify-center items-center text-center group hover:shadow-emerald-200/50 transition-all duration-500">
                        <div class="w-28 h-28 bg-emerald-600 rounded-[2.5rem] flex flex-col items-center justify-center mb-6 text-white shadow-xl shadow-emerald-200 group-hover:rotate-6 transition-transform">
                            <span class="text-sm font-black uppercase opacity-70">{{ \Carbon\Carbon::now()->translatedFormat('M') }}</span>
                            <span class="text-5xl font-black">{{ \Carbon\Carbon::now()->format('d') }}</span>
                        </div>
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.4em] mb-1">Hari Operasional</p>
                        <p class="text-2xl font-black text-slate-800 uppercase tracking-tighter">{{ \Carbon\Carbon::now()->translatedFormat('l') }}</p>
                    </div>
                    <div class="bg-slate-900 p-7 rounded-[2.5rem] shadow-2xl flex items-center gap-6 group relative border border-white/5 overflow-hidden">
                        <div class="p-4 bg-white/5 border border-white/10 rounded-2xl group-hover:bg-emerald-600 transition-colors">
                            <svg width="24" height="24" class="text-emerald-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] leading-none mb-1.5 italic">Status Akses</p>
                            <p class="text-sm font-black text-white uppercase tracking-tight italic">Encrypted Secure</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- GRID STATISTIK --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $stats = [
                        ['label' => 'Total Laporan', 'value' => $total_perkara, 'color' => 'bg-rose-500', 'bg' => 'bg-rose-50'],
                        ['label' => 'Sengketa Perdata', 'value' => $perdata, 'color' => 'bg-orange-500', 'bg' => 'bg-orange-50'],
                        ['label' => 'Perkara T.U.N', 'value' => $tun, 'color' => 'bg-blue-500', 'bg' => 'bg-blue-50'],
                        ['label' => 'Inkracht Selesai', 'value' => $selesai, 'color' => 'bg-emerald-500', 'bg' => 'bg-emerald-50']
                    ];
                @endphp
                @foreach($stats as $stat)
                <div class="bg-white p-8 rounded-[3rem] shadow-xl border border-slate-50 relative overflow-hidden group hover:-translate-y-2 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-24 h-24 {{ $stat['bg'] }} rounded-bl-[4rem] -z-10 group-hover:scale-150 transition-transform duration-700"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">{{ $stat['label'] }}</p>
                    <h4 class="text-6xl font-black text-slate-900 tracking-tighter leading-none">{{ $stat['value'] }}</h4>
                    <div class="mt-8 h-1.5 w-12 {{ $stat['color'] }} rounded-full group-hover:w-full transition-all duration-700"></div>
                </div>
                @endforeach
            </div>

            {{-- TABEL MONITORING TERBARU - SEJAJAR PRESISI 100% --}}
            <div class="bg-white rounded-[4rem] shadow-2xl border border-slate-100 overflow-hidden">
                <div class="p-12 border-b border-slate-50 flex items-center justify-between bg-gradient-to-r from-white to-emerald-50/20">
                    <div class="flex items-center gap-4">
                        <div class="w-2.5 h-10 bg-emerald-600 rounded-full shadow-lg shadow-emerald-200"></div>
                        <h3 class="font-black text-slate-800 italic uppercase tracking-tighter text-2xl">
                            Pantauan Perkara <span class="text-emerald-600">Terbaru</span>
                        </h3>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    {{-- table-fixed untuk mengunci lebar kolom agar tidak bergeser --}}
                    <table class="w-full text-left border-collapse table-fixed min-w-[1100px]">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100 uppercase text-[10px] font-black text-slate-400 tracking-[0.3em]">
                                <th class="w-[22%] px-12 py-8">Registrasi</th>
                                <th class="w-[18%] px-8 py-8">Para Pihak</th>
                                <th class="w-[15%] px-8 py-8 text-center">Status</th>
                                <th class="w-[30%] px-8 py-8 text-center">Tim JPN (Jaksa)</th>
                                <th class="w-[15%] px-12 py-8 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($perkaras->take(5) as $perkara)
                                <tr class="group hover:bg-emerald-50/30 transition-all duration-700">
                                    {{-- Kolom 1: Registrasi --}}
                                    <td class="px-12 py-10 align-middle">
                                        <div class="flex flex-col justify-center min-h-[60px]">
                                            <div class="font-black text-[15px] text-slate-800 uppercase tracking-tighter italic mb-1 group-hover:text-emerald-600 transition-colors truncate">
                                                {{ $perkara->nomor_perkara }}
                                            </div>
                                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] italic truncate block">
                                                {{ $perkara->jenis_perkara }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Kolom 2: Para Pihak --}}
                                    <td class="px-8 py-10 align-middle">
                                        <div class="flex flex-col justify-center gap-1 uppercase font-black text-[10px] tracking-tighter italic min-h-[60px]">
                                            <span class="text-emerald-700 truncate font-bold">P: {{ $perkara->penggugat }}</span>
                                            <span class="text-rose-700 truncate font-bold">T: {{ $perkara->tergugat }}</span>
                                        </div>
                                    </td>

                                    {{-- Kolom 3: Status --}}
                                    <td class="px-8 py-10 align-middle">
                                        <div class="flex items-center justify-center min-h-[60px]">
                                            <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-black text-[9px] uppercase tracking-widest {{ $perkara->status_akhir == 'Selesai' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-orange-100 text-orange-700 border border-orange-200' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $perkara->status_akhir == 'Selesai' ? 'bg-emerald-500' : 'bg-orange-500 animate-pulse' }}"></span>
                                                {{ $perkara->status_akhir }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Kolom 4: Tim JPN (Jaksa) - FIX SEJAJAR MATI --}}
                                    <td class="px-8 py-10 align-middle text-center">
                                        <div class="flex items-center justify-center min-h-[60px]">
                                            {{-- FIX: Mengunci lebar kontainer w-[260px] agar titik tengah tidak goyang --}}
                                            <div class="flex items-center gap-3 p-1.5 pr-6 bg-slate-50 rounded-2xl border border-slate-100 group-hover:bg-white transition-all shadow-sm w-[260px]">
                                                <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-[13px] font-black text-white shadow-lg border border-white/20 flex-shrink-0">
                                                    {{ substr($perkara->jaksa->nama_jaksa ?? '?', 0, 1) }}
                                                </div>
                                                <span class="text-[10px] font-black text-slate-700 italic uppercase tracking-tighter whitespace-nowrap truncate overflow-hidden text-left flex-1">
                                                    {{ $perkara->jaksa->nama_jaksa ?? 'BELUM DITUNJUK' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom 5: Aksi --}}
                                    <td class="px-12 py-10 align-middle">
                                        <div class="flex items-center justify-center gap-3 min-h-[60px]">
                                            <a href="{{ route('perkara.show', $perkara->id) }}" class="p-4 bg-white text-blue-600 rounded-2xl shadow-md border border-slate-100 hover:bg-emerald-600 hover:text-white transition-all inline-block active:scale-90" title="Monitoring">
                                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            @if(Auth::user()->role === 'admin')
                                            <form action="{{ route('perkara.destroy', $perkara->id) }}" method="POST" onsubmit="return confirm('Hapus perkara?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-4 bg-rose-50 text-rose-600 rounded-2xl shadow-md border border-rose-100 hover:bg-rose-600 hover:text-white transition-all inline-block active:scale-95" title="Hapus">
                                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-40 text-center font-black italic uppercase tracking-[1em] text-slate-300 text-[10px]">Database SIM-DATUN Kosong</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- FOOTER IDENTITAS (FLUTTER KAREN PREMIUM) --}}
            <div class="pt-20 pb-10 flex flex-col items-center gap-8 opacity-40 group">
                <div class="flex items-center gap-10">
                    <div class="h-[1px] w-48 bg-gradient-to-r from-transparent via-emerald-400 to-transparent group-hover:w-64 transition-all duration-1000"></div>
                    <img src="{{ asset('img/logo jaksa.png') }}" class="w-12 h-auto grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                    <div class="h-[1px] w-48 bg-gradient-to-l from-transparent via-emerald-400 to-transparent group-hover:w-64 transition-all duration-1000"></div>
                </div>
                <div class="space-y-2 text-center">
                    <p class="text-[11px] font-black text-slate-800 uppercase tracking-[1.2em] italic leading-none ml-[1.2em]">Integritas • Profesionalisme • Kejari Banjarmasin</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.5em] mt-3">Sistem Informasi Monitoring - Bidang DATUN Kejaksaan</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>