<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang - SIM-DATUN</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-emerald-500/10 to-teal-600/10 z-0"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-200/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-teal-200/20 rounded-full blur-3xl"></div>

        <div class="z-10 w-full max-w-4xl px-6 text-center">
            <div class="mb-8 inline-block p-6 bg-white rounded-[3rem] shadow-2xl shadow-emerald-900/10 border border-white transition-transform hover:scale-105 duration-500">
                <img src="{{ asset('img/logo jaksa.png') }}" alt="Logo Kejaksaan" class="w-32 h-auto mx-auto drop-shadow-md">
            </div>

            <h1 class="text-4xl md:text-6xl font-black text-emerald-900 tracking-tighter uppercase mb-4">
                SIM-DATUN <span class="text-emerald-600">KEJAKSAAN</span>
            </h1>
            <p class="text-sm md:text-lg font-bold text-gray-500 uppercase tracking-[0.3em] italic mb-12">
                Sistem Informasi Monitoring Perdata & Tata Usaha Negara
            </p>

            <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="group relative px-10 py-5 bg-emerald-600 text-white rounded-2xl font-black text-xs tracking-widest uppercase overflow-hidden shadow-xl shadow-emerald-200 transition-all hover:bg-emerald-700 active:scale-95">
                            <span class="relative z-10 flex items-center gap-3">
                                Ke Dashboard
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="transition-transform group-hover:translate-x-1"><path stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="group relative px-12 py-5 bg-emerald-600 text-white rounded-2xl font-black text-xs tracking-widest uppercase overflow-hidden shadow-xl shadow-emerald-200 transition-all hover:bg-emerald-700 active:scale-95">
                            <span class="relative z-10 flex items-center gap-3">
                                Masuk ke Sistem
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="transition-transform group-hover:translate-x-1"><path stroke-width="2.5" d="M11 16l4-4m0 0l-4-4m4 4H9m6 4a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-10 py-5 bg-white text-emerald-700 border border-emerald-100 rounded-2xl font-black text-xs tracking-widest uppercase shadow-lg shadow-emerald-900/5 hover:bg-emerald-50 transition-all active:scale-95">
                                Registrasi Akun
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <div class="mt-20 flex items-center justify-center gap-8 opacity-40">
                <div class="h-[1px] w-12 bg-emerald-900"></div>
                <span class="text-[9px] font-black text-emerald-900 uppercase tracking-[0.5em] italic">Integritas & Profesionalisme</span>
                <div class="h-[1px] w-12 bg-emerald-900"></div>
            </div>
        </div>
    </div>
</body>
</html>