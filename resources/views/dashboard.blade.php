<x-app-layout>
    {{-- CSS Khusus untuk Visual Premium --}}
    <style>
        [x-cloak] { display: none !important; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.5); }
        .stat-glow:hover { box-shadow: 0 20px 40px -15px rgba(16, 185, 129, 0.2); transform: translateY(-5px); }
        .bg-pattern { background-image: radial-gradient(#10b981 0.5px, transparent 0.5px); background-size: 24px 24px; opacity: 0.1; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
    </style>

    {{-- HEADER: PANEL KENDALI MODERN --}}
    <x-slot name="header">
        <div class="gsap-reveal flex flex-col md:flex-row md:items-center justify-between gap-6 opacity-0 translate-y-[-20px]">
            <div class="flex items-center gap-6 text-left">
                <div class="relative p-2 bg-white rounded-2xl shadow-sm border border-emerald-50 transition-all duration-500 hover:rotate-12 hover:scale-110">
                    <img src="{{ asset('img/logo jaksa.png') }}" alt="Logo" class="w-12 h-12 object-contain">
                </div>
                
                <div class="space-y-1">
                    <h2 class="text-2xl font-black text-slate-800 tracking-tighter uppercase leading-none text-left">
                        DASHBOARD <span class="text-emerald-600 italic underline decoration-emerald-200 decoration-4 underline-offset-4">SYSTEM</span>
                    </h2>
                    <div class="flex items-center gap-3">
                        <div class="h-[2px] w-8 bg-emerald-500"></div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.4em]">
                            {{ Auth::user()->role === 'admin' ? 'Otoritas Datun Terpusat' : 'Akses Operasional Staff' }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="px-6 py-3 bg-white text-emerald-700 rounded-2xl font-black text-[10px] uppercase tracking-widest border border-emerald-100 flex items-center gap-3 shadow-sm shadow-emerald-50">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    Waktu Sistem (WITA): <span id="real-time-clock" class="font-mono">00:00:00</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-[#fcfdfe] min-h-screen relative overflow-hidden text-slate-900 font-sans">
        <div class="absolute inset-0 bg-pattern pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 relative z-10">
            
            {{-- HERO SECTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <div class="gsap-reveal lg:col-span-3 relative bg-gradient-to-br from-emerald-900 to-emerald-950 rounded-[3rem] p-10 overflow-hidden shadow-2xl opacity-0 border border-emerald-800 group translate-y-[20px]">
                    <div class="absolute -top-24 -left-24 w-64 h-64 bg-emerald-500/20 rounded-full blur-[80px] group-hover:bg-emerald-400/30 transition-all duration-700"></div>
                    <img src="{{ asset('img/logo jaksa.png') }}" class="absolute -right-8 -bottom-12 w-64 opacity-5 grayscale brightness-200 -rotate-12 pointer-events-none group-hover:scale-110 transition-transform duration-700" alt="">

                    <div class="relative z-10 flex flex-col md:flex-row items-center gap-10 text-left">
                        <div class="shrink-0 relative">
                            <div class="absolute inset-0 bg-white/20 blur-3xl rounded-full"></div>
                            <img src="{{ asset('img/logo jaksa.png') }}" alt="Logo Kejaksaan" class="w-28 h-28 object-contain filter drop-shadow-[0_10px_10px_rgba(0,0,0,0.5)]">
                        </div>
                        <div class="space-y-4">
                            <div class="space-y-1 text-left">
                                <p class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.5em] mb-3 border-l-2 border-emerald-500 pl-3">Kejaksaan Negeri Banjarmasin</p>
                                <h1 class="text-4xl md:text-5xl font-black text-white leading-tight tracking-tighter uppercase italic">Sistem Informasi<br><span class="text-emerald-400 italic">Monitoring Datun</span></h1>
                            </div>
                            <p class="text-emerald-100/60 text-[11px] font-bold tracking-widest uppercase italic">Selamat Datang Kembali, <span class="text-white underline underline-offset-4 decoration-emerald-500">{{ Auth::user()->name }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="gsap-reveal relative bg-white p-8 rounded-[3rem] shadow-xl border border-slate-100 flex flex-col justify-center items-center text-center opacity-0 translate-y-[20px] group">
                    <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-[2rem] flex flex-col items-center justify-center text-white shadow-xl shadow-emerald-100 mb-5 border-4 border-white group-hover:rotate-6 transition-transform duration-500">
                        <span class="text-[10px] font-black uppercase opacity-80 mb-0.5">{{ now()->translatedFormat('M') }}</span>
                        <span class="text-3xl font-black">{{ now()->format('d') }}</span>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter italic">{{ now()->translatedFormat('l') }}</h3>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-2">Tahun Anggaran {{ now()->format('Y') }}</p>
                </div>
            </div>

            {{-- GRID STATISTIK --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @php
                    $stats = [
                        ['label' => 'Total Perkara', 'value' => $total_perkara, 'color' => 'bg-slate-800', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2'],
                        ['label' => 'Perdata', 'value' => $perdata, 'color' => 'bg-orange-500', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16'],
                        ['label' => 'T.U.N', 'value' => $tun, 'color' => 'bg-blue-600', 'icon' => 'M3 10h18M3 14h18m-9-4v8'],
                        ['label' => 'Sedang Proses', 'value' => $proses, 'color' => 'bg-rose-600', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['label' => 'Selesai', 'value' => $selesai, 'color' => 'bg-emerald-600', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z']
                    ];
                @endphp

                @foreach($stats as $stat)
                <div class="gsap-stat-card glass-card p-6 rounded-[2.5rem] shadow-sm opacity-0 scale-90 text-left stat-glow transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 {{ $stat['color'] }} text-white rounded-xl shadow-lg">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="{{ $stat['icon'] }}"/></svg>
                        </div>
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none text-right">{{ $stat['label'] }}</p>
                    </div>
                    <h4 class="text-4xl font-black text-slate-900 tracking-tighter italic leading-none">{{ $stat['value'] }}</h4>
                    <div class="mt-5 h-[4px] w-full bg-slate-100 rounded-full overflow-hidden">
                        <div class="gsap-progress-bar h-full w-0 {{ $stat['color'] }} rounded-full" data-width="100%"></div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- GRAFIK TREN PERKARA (DIREVISI) --}}
                <div class="gsap-reveal lg:col-span-2 bg-white rounded-[3rem] p-8 shadow-xl opacity-0 translate-y-[20px] text-left border border-slate-50 relative overflow-hidden">
                    <div class="flex items-center justify-between mb-8 relative z-10">
                        <div class="flex items-center gap-3">
                            <div class="w-1.5 h-6 bg-emerald-500 rounded-full shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>
                            <h3 class="font-black text-slate-800 uppercase italic text-lg tracking-tighter">Analisis Tren <span class="text-emerald-600">Perkara {{ $tahunSekarang }}</span></h3>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                                <span class="text-[8px] font-black uppercase text-slate-400 italic">Perdata</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-blue-600 rounded-full"></div>
                                <span class="text-[8px] font-black uppercase text-slate-400 italic">TUN</span>
                            </div>
                        </div>
                    </div>
                    <div class="h-[320px] w-full relative z-10">
                        <canvas id="perkaraChart"></canvas>
                    </div>
                </div>

                {{-- PERKARA MASUK TERKINI --}}
                <div class="gsap-reveal bg-white rounded-[3rem] p-8 shadow-xl opacity-0 translate-y-[20px] text-left border border-slate-50 flex flex-col">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-3">
                            <div class="w-1.5 h-6 bg-emerald-500 rounded-full"></div>
                            <h3 class="font-black text-slate-800 uppercase italic text-lg tracking-tighter">Masuk <span class="text-emerald-600">Terkini</span></h3>
                        </div>
                        <span class="px-2 py-1 bg-emerald-50 rounded text-[7px] font-black text-emerald-600 uppercase tracking-widest animate-pulse">Live</span>
                    </div>
                    <div class="space-y-4 overflow-y-auto pr-2 custom-scrollbar flex-grow" style="max-height: 320px;">
                        @forelse($perkaras->take(5) as $perkara)
                        <div class="flex items-center gap-4 p-4 bg-slate-50/50 rounded-[1.8rem] border border-slate-100 group hover:bg-emerald-50/50 hover:border-emerald-100 transition-all duration-300">
                            <div class="w-11 h-11 bg-white rounded-2xl flex flex-col items-center justify-center shadow-sm border border-slate-100 shrink-0 group-hover:scale-110 group-hover:rotate-3 transition-transform">
                                <span class="text-[8px] font-black uppercase text-emerald-600 mb-0.5">{{ \Carbon\Carbon::parse($perkara->tanggal_masuk)->translatedFormat('M') }}</span>
                                <span class="text-lg font-black text-slate-800">{{ \Carbon\Carbon::parse($perkara->tanggal_masuk)->format('d') }}</span>
                            </div>
                            <div class="text-left overflow-hidden flex-grow">
                                <h4 class="text-[10px] font-black uppercase text-slate-800 truncate mb-1">{{ $perkara->nomor_perkara }}</h4>
                                <p class="text-[8px] text-slate-400 font-bold italic truncate uppercase tracking-tighter">JPN: {{ strtoupper($perkara->jaksa->nama_jaksa ?? '-') }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="py-12 text-center opacity-30 italic font-black text-[10px] uppercase">Antrian data kosong</div>
                        @endforelse
                    </div>
                    <a href="{{ route('perkara.index') }}" class="mt-6 text-[9px] font-black uppercase text-emerald-600 border-b border-emerald-100 hover:border-emerald-500 transition-all tracking-widest inline-block text-center pb-1">Buka Pantauan &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS GSAP & CHART.JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Animasi Real-time Clock
            setInterval(() => {
                const now = new Date();
                document.getElementById('real-time-clock').innerText = now.toLocaleTimeString('id-ID');
            }, 1000);

            // GSAP Reveals
            gsap.to(".gsap-reveal", { y: 0, opacity: 1, duration: 1.2, stagger: 0.3, ease: "power4.out" });
            gsap.to(".gsap-stat-card", { scale: 1, opacity: 1, duration: 0.8, stagger: 0.15, ease: "back.out(1.7)", delay: 0.6 });
            gsap.to(".gsap-progress-bar", { width: "100%", duration: 2, ease: "power2.inOut", delay: 1.2 });

            // Grafik Chart.js (REVISI DATA PERDATA & TUN SEJAJAR)
            const ctx = document.getElementById('perkaraChart').getContext('2d');
            
            const gradPerdata = ctx.createLinearGradient(0, 0, 0, 300);
            gradPerdata.addColorStop(0, 'rgba(249, 115, 22, 0.2)');
            gradPerdata.addColorStop(1, 'rgba(249, 115, 22, 0.0)');

            const gradTun = ctx.createLinearGradient(0, 0, 0, 300);
            gradTun.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
            gradTun.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [
                        {
                            label: 'Perdata',
                            data: @json($dataGrafikPerdata), 
                            borderColor: '#f97316',
                            backgroundColor: gradPerdata,
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#f97316',
                        },
                        {
                            label: 'Tata Usaha Negara',
                            data: @json($dataGrafikTun), 
                            borderColor: '#2563eb',
                            backgroundColor: gradTun,
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#2563eb',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.03)', borderDash: [5, 5] }, ticks: { font: { size: 10, weight: 'bold' }, stepSize: 1 } },
                        x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' } } }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: { backgroundColor: '#0f172a', padding: 12, titleFont: { size: 14, weight: 'black' }, bodyFont: { weight: 'bold' }, cornerRadius: 12, displayColors: true }
                    }
                }
            });
        });
    </script>
</x-app-layout>