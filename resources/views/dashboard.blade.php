<x-app-layout>
    {{-- CSS Khusus - Optimasi Performa --}}
    <style>
        [x-cloak] { display: none !important; }
        /* Blur dikurangi agar render GPU lebih ringan */
        .glass-card { background: rgba(255, 255, 255, 0.9); border: 1px solid rgba(226, 232, 240, 0.8); }
        .stat-glow:hover { transform: translateY(-3px); box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.1); }
        .bg-pattern { background-image: radial-gradient(#10b981 0.5px, transparent 0.5px); background-size: 24px 24px; opacity: 0.05; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
    </style>

    <x-slot name="header">
        <div class="gsap-header flex flex-col md:flex-row md:items-center justify-between gap-6 opacity-0">
            <div class="flex items-center gap-6 text-left">
                <div class="relative p-2 bg-white rounded-2xl shadow-sm border border-emerald-50">
                    <img src="{{ asset('img/logo jaksa.png') }}" alt="Logo" class="w-12 h-12 object-contain">
                </div>
                <div class="space-y-1">
                    <h2 class="text-2xl font-black text-slate-800 tracking-tighter uppercase leading-none text-left">
                        DASHBOARD <span class="text-emerald-600 italic underline decoration-emerald-200 decoration-4 underline-offset-4">SYSTEM</span>
                    </h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.4em]">
                        {{ Auth::user()->role === 'admin' ? 'Otoritas Datun Terpusat' : 'Akses Operasional Staff' }}
                    </p>
                </div>
            </div>
            <div class="px-6 py-3 bg-white text-emerald-700 rounded-2xl font-black text-[10px] uppercase tracking-widest border border-emerald-100 flex items-center gap-3 shadow-sm">
                Waktu Sistem (WITA): <span id="real-time-clock" class="font-mono">00:00:00</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-[#fcfdfe] min-h-screen relative overflow-hidden text-slate-900 font-sans">
        <div class="absolute inset-0 bg-pattern pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 relative z-10">
            {{-- HERO SECTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <div class="gsap-hero lg:col-span-3 relative bg-gradient-to-br from-emerald-900 to-emerald-950 rounded-[3rem] p-10 overflow-hidden shadow-xl opacity-0">
                    <div class="relative z-10 flex flex-col md:flex-row items-center gap-10 text-left">
                        <div class="shrink-0"><img src="{{ asset('img/logo jaksa.png') }}" class="w-28 h-28 object-contain"></div>
                        <div class="space-y-4">
                            <div class="space-y-1 text-left">
                                <p class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.5em] mb-2">Kejaksaan Negeri Banjarmasin</p>
                                <h1 class="text-4xl md:text-5xl font-black text-white leading-tight tracking-tighter uppercase italic">Sistem Informasi<br><span class="text-emerald-400 italic">Monitoring Datun</span></h1>
                            </div>
                            <p class="text-emerald-100/60 text-[11px] font-bold tracking-widest uppercase italic text-left">Selamat Datang Kembali, <span class="text-white">{{ Auth::user()->name }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="gsap-hero relative bg-white p-8 rounded-[3rem] shadow-lg border border-slate-100 flex flex-col justify-center items-center text-center opacity-0">
                    <div class="w-16 h-16 bg-emerald-600 rounded-2xl flex flex-col items-center justify-center text-white mb-4">
                        <span class="text-[10px] font-black uppercase opacity-80">{{ now()->translatedFormat('M') }}</span>
                        <span class="text-2xl font-black">{{ now()->format('d') }}</span>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 uppercase italic">{{ now()->translatedFormat('l') }}</h3>
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
                <div class="gsap-card glass-card p-6 rounded-[2.5rem] shadow-sm opacity-0 text-left stat-glow">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 {{ $stat['color'] }} text-white rounded-xl"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="{{ $stat['icon'] }}"/></svg></div>
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none">{{ $stat['label'] }}</p>
                    </div>
                    <h4 class="text-3xl font-black text-slate-900 tracking-tighter italic leading-none">{{ $stat['value'] }}</h4>
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="gsap-content lg:col-span-2 bg-white rounded-[3rem] p-8 shadow-lg opacity-0 text-left border border-slate-50">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="font-black text-slate-800 uppercase italic text-lg tracking-tighter">Analisis Tren <span class="text-emerald-600">Perkara</span></h3>
                        <div class="flex gap-4">
                            <div class="flex items-center gap-2 text-[8px] font-black uppercase text-slate-400 italic">
                                <div class="w-2 h-2 bg-orange-500 rounded-full"></div> Perdata
                            </div>
                            <div class="flex items-center gap-2 text-[8px] font-black uppercase text-slate-400 italic">
                                <div class="w-2 h-2 bg-blue-600 rounded-full"></div> TUN
                            </div>
                        </div>
                    </div>
                    <div class="h-[300px] w-full"><canvas id="perkaraChart"></canvas></div>
                </div>

                <div class="gsap-content bg-white rounded-[3rem] p-8 shadow-lg opacity-0 text-left border border-slate-50 flex flex-col">
                    <h3 class="font-black text-slate-800 uppercase italic text-lg tracking-tighter mb-8">Masuk <span class="text-emerald-600">Terkini</span></h3>
                    <div class="space-y-4 overflow-y-auto pr-2 custom-scrollbar flex-grow" style="max-height: 280px;">
                        @forelse($perkaras->take(5) as $perkara)
                        <div class="flex items-center gap-4 p-4 bg-slate-50/50 rounded-[1.5rem] border border-slate-100 group transition-all duration-300">
                            <div class="w-10 h-10 bg-white rounded-xl flex flex-col items-center justify-center border border-slate-100 shrink-0">
                                <span class="text-[7px] font-black uppercase text-emerald-600">{{ \Carbon\Carbon::parse($perkara->tanggal_masuk)->translatedFormat('M') }}</span>
                                <span class="text-base font-black text-slate-800 leading-none">{{ \Carbon\Carbon::parse($perkara->tanggal_masuk)->format('d') }}</span>
                            </div>
                            <div class="text-left overflow-hidden">
                                <h4 class="text-[10px] font-black uppercase text-slate-800 truncate mb-1">{{ $perkara->nomor_perkara }}</h4>
                                <p class="text-[8px] text-slate-400 font-bold italic uppercase tracking-tighter">JPN: {{ strtoupper($perkara->jaksa->nama_jaksa ?? '-') }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="py-12 text-center opacity-30 italic font-black text-[10px] uppercase">Data kosong</div>
                        @endforelse
                    </div>
                    <a href="{{ route('perkara.index') }}" class="mt-6 text-[9px] font-black uppercase text-emerald-600 border-b border-emerald-100 hover:border-emerald-500 transition-all inline-block pb-1">Selengkapnya &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS GSAP & CHART.JS - OPTIMIZED --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setInterval(() => {
                const now = new Date();
                document.getElementById('real-time-clock').innerText = now.toLocaleTimeString('id-ID');
            }, 1000);

            // ANIMASI RINGAN (Lightweight Animation)
            const tl = gsap.timeline({defaults: {ease: "power2.out"}});
            tl.to(".gsap-header", { opacity: 1, duration: 0.5 })
              .to(".gsap-hero", { opacity: 1, y: 0, duration: 0.6, stagger: 0.1 }, "-=0.3")
              .to(".gsap-card", { opacity: 1, duration: 0.4, stagger: 0.05 }, "-=0.4")
              .to(".gsap-content", { opacity: 1, y: 0, duration: 0.6, stagger: 0.1 }, "-=0.3");

            // Grafik Chart.js
            const ctx = document.getElementById('perkaraChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [
                        { label: 'Perdata', data: @json($dataGrafikPerdata), borderColor: '#f97316', borderWidth: 3, tension: 0.4, pointRadius: 2, fill: false },
                        { label: 'TUN', data: @json($dataGrafikTun), borderColor: '#2563eb', borderWidth: 3, tension: 0.4, pointRadius: 2, fill: false }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.02)' }, ticks: { font: { size: 10, weight: 'bold' }, stepSize: 1 } },
                        x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' } } }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
</x-app-layout>