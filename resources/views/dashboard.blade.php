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
                <div class="px-8 py-3 bg-emerald-50 text-emerald-700 rounded-2xl font-black text-[10px] uppercase tracking-widest border border-emerald-100 flex items-center gap-3 shadow-sm shadow-emerald-100">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    Sesi Akses Terverifikasi
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfdfe] min-h-screen relative overflow-hidden text-slate-900 font-sans antialiased">
        <div class="absolute top-0 right-0 w-[50%] h-[50%] bg-emerald-50/50 rounded-full blur-[120px] -z-10 translate-x-1/2 -translate-y-1/2"></div>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10 relative z-10">
            
            {{-- HERO SECTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 relative bg-emerald-900 rounded-[3.5rem] p-12 overflow-hidden shadow-2xl border border-white/10">
                    <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-emerald-400/10 to-transparent opacity-50"></div>
                    <div class="relative z-10 space-y-8">
                        <div class="inline-flex items-center gap-3 px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-full border border-white/10">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                            <span class="text-[10px] font-black text-emerald-100 uppercase tracking-[0.5em]">Sinkronisasi Data Terpadu</span>
                        </div>
                        <h1 class="text-5xl md:text-7xl font-black text-white leading-none tracking-tighter uppercase italic drop-shadow-2xl">
                            Sistem Informasi<br><span class="text-emerald-400">Monitoring Terintegrasi</span>
                        </h1>
                        <p class="text-emerald-100/60 text-sm font-medium tracking-wide max-w-md italic leading-relaxed uppercase">
                            Manajemen database perkara Perdata dan Tata Usaha Negara pada Kejaksaan Negeri Banjarmasin berbasis akuntabilitas digital.
                        </p>
                    </div>
                    <img src="{{ asset('img/logo jaksa.png') }}" class="absolute -right-10 -bottom-10 w-96 h-auto opacity-10 grayscale brightness-200 -rotate-12 pointer-events-none">
                </div>

                <div class="flex flex-col gap-6">
                    <div class="flex-1 bg-white p-8 rounded-[3rem] shadow-xl border border-slate-100 flex flex-col justify-center items-center text-center group hover:shadow-emerald-200/50 transition-all duration-500">
                        <div class="w-28 h-28 bg-emerald-600 rounded-[2.5rem] flex flex-col items-center justify-center mb-6 text-white shadow-xl shadow-emerald-200 group-hover:rotate-6 transition-transform">
                            <span class="text-sm font-black uppercase opacity-70">{{ \Carbon\Carbon::now()->translatedFormat('M') }}</span>
                            <span class="text-5xl font-black">{{ \Carbon\Carbon::now()->format('d') }}</span>
                        </div>
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.4em] mb-1">Kalender Operasional</p>
                        <p class="text-2xl font-black text-slate-800 uppercase tracking-tighter">{{ \Carbon\Carbon::now()->translatedFormat('l') }}</p>
                    </div>
                </div>
            </div>

            {{-- GRID STATISTIK --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $stats = [
                        ['label' => 'Total Laporan', 'value' => $total_perkara, 'color' => 'bg-rose-500', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2'],
                        ['label' => 'Sengketa Perdata', 'value' => $perdata, 'color' => 'bg-orange-500', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                        ['label' => 'Perkara T.U.N', 'value' => $tun, 'color' => 'bg-blue-500', 'icon' => 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z'],
                        ['label' => 'Inkracht Selesai', 'value' => $selesai, 'color' => 'bg-emerald-500', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z']
                    ];
                @endphp
                @foreach($stats as $stat)
                <div class="bg-white p-8 rounded-[3rem] shadow-xl border border-slate-50 relative overflow-hidden group hover:-translate-y-2 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-slate-50 rounded-bl-[4rem] -z-10 group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ $stat['label'] }}</p>
                        <svg width="20" height="20" class="text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                    </div>
                    <h4 class="text-6xl font-black text-slate-900 tracking-tighter leading-none">{{ $stat['value'] }}</h4>
                    <div class="mt-8 h-1.5 w-12 {{ $stat['color'] }} rounded-full group-hover:w-full transition-all duration-700"></div>
                </div>
                @endforeach
            </div>

            {{-- DUA KOLOM INSIGHTS (AGENDA & PERSONEL) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- 1. AGENDA TAHAPAN TERDEKAT --}}
                <div class="lg:col-span-2 bg-white rounded-[3.5rem] p-10 shadow-2xl border border-slate-100 flex flex-col relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -mr-10 -mt-10 opacity-50"></div>
                    
                    <div class="flex items-center justify-between mb-10 relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-8 bg-emerald-600 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.3)]"></div>
                            <h3 class="font-black text-slate-800 italic uppercase tracking-tighter text-xl">Agenda <span class="text-emerald-600">Tahapan Terkini</span></h3>
                        </div>
                        <span class="text-[9px] font-black text-emerald-600 bg-emerald-50 px-4 py-2 rounded-full uppercase tracking-widest animate-pulse border border-emerald-100">Live Schedule</span>
                    </div>

                    <div class="space-y-6 flex-1">
                        @php
                            $agenda_terkini = \App\Models\Tahapan::with('perkara')->latest('tanggal_tahapan')->take(3)->get();
                        @endphp

                        @forelse($agenda_terkini as $agenda)
                        <div class="flex items-center gap-6 p-6 bg-slate-50 rounded-[2rem] border border-slate-100 hover:bg-white transition-all duration-500 group/item">
                            <div class="flex flex-col items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-sm border border-slate-100 group-hover/item:bg-emerald-600 group-hover/item:text-white transition-colors">
                                <span class="text-[10px] font-black uppercase leading-none mb-1">{{ \Carbon\Carbon::parse($agenda->tanggal_tahapan)->translatedFormat('M') }}</span>
                                <span class="text-xl font-black leading-none">{{ \Carbon\Carbon::parse($agenda->tanggal_tahapan)->format('d') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-tight truncate pr-4">{{ $agenda->nama_tahapan }}</h4>
                                    <span class="text-[8px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md uppercase tracking-tighter whitespace-nowrap">{{ $agenda->perkara->jenis_perkara ?? 'UMUM' }}</span>
                                </div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest truncate italic">{{ $agenda->perkara->nomor_perkara ?? 'N/A' }}</p>
                            </div>
                            <div class="hidden md:block">
                                <a href="{{ route('perkara.show', $agenda->perkara_id) }}" class="p-3 bg-white text-slate-400 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="flex flex-col items-center justify-center h-full opacity-20 italic font-black uppercase tracking-[0.5em] text-[10px] py-10">
                            Belum Ada Agenda Terdaftar
                        </div>
                        @endforelse
                    </div>

                    <a href="{{ route('perkara.index') }}" class="mt-8 text-center py-4 bg-slate-50 rounded-2xl text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] hover:bg-emerald-600 hover:text-white transition-all duration-300">Pantau Seluruh Progress Perkara</a>
                </div>

                {{-- 2. PERSONEL JPN TERAKTIF --}}
                <div class="bg-slate-900 rounded-[3.5rem] p-10 shadow-2xl text-white flex flex-col justify-between relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-emerald-500/10 to-transparent opacity-30"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-10">
                            <div class="w-1.5 h-6 bg-emerald-500 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
                            <h3 class="font-black italic uppercase tracking-tighter text-xl text-emerald-400">Efektifitas <span class="text-white">Personel</span></h3>
                        </div>

                        <div class="space-y-8">
                            @php
                                $topJaksas = \App\Models\Jaksa::withCount('perkaras')->orderBy('perkaras_count', 'desc')->take(3)->get();
                            @endphp

                            @foreach($topJaksas as $index => $top)
                            <div class="flex items-center gap-5 group/item">
                                <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center font-black text-emerald-400 text-lg group-hover/item:bg-emerald-600 group-hover/item:text-white transition-all">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-[11px] font-black uppercase tracking-tight leading-none mb-2 italic">{{ $top->nama_jaksa }}</h4>
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 h-1 bg-white/5 rounded-full overflow-hidden">
                                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" style="width: {{ ($top->perkaras_count > 0 ? ($top->perkaras_count / 10) * 100 : 0) }}%"></div>
                                        </div>
                                        <span class="text-[9px] font-black text-emerald-400 uppercase tracking-tighter">{{ $top->perkaras_count }} Case</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-12 p-6 bg-white/5 border border-white/10 rounded-[2rem] text-center relative z-10 group-hover:bg-emerald-600/10 transition-all">
                        <p class="text-[9px] font-black text-emerald-400 uppercase tracking-widest mb-1 italic">Visi Bidang Datun</p>
                        <p class="text-[10px] font-medium text-slate-400 italic leading-relaxed group-hover:text-emerald-100">"Menegakkan Keadilan Melalui Administrasi Perkara yang Transparan dan Akuntabel."</p>
                    </div>
                </div>
            </div>

            {{-- FOOTER IDENTITAS --}}
            <div class="pt-20 pb-10 flex flex-col items-center gap-8 opacity-40 group">
                <div class="flex items-center gap-10">
                    <div class="h-[1px] w-48 bg-gradient-to-r from-transparent via-emerald-400 to-transparent group-hover:w-64 transition-all duration-1000"></div>
                    <img src="{{ asset('img/logo jaksa.png') }}" class="w-12 h-auto grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                    <div class="h-[1px] w-48 bg-gradient-to-l from-transparent via-emerald-400 to-transparent group-hover:w-64 transition-all duration-1000"></div>
                </div>
                <p class="text-[11px] font-black text-slate-800 uppercase tracking-[1.2em] italic leading-none ml-[1.2em]">Integritas • Profesionalisme • Kejari Banjarmasin</p>
            </div>
        </div>
    </div>
</x-app-layout>