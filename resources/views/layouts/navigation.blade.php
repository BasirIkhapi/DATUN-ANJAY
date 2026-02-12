<nav x-data="{ open: false }" class="bg-gradient-to-r from-emerald-600 to-emerald-700 border-b border-emerald-500 shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-6">
                
                {{-- LOGO --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center p-2 bg-white/10 rounded-xl border border-white/10 hover:bg-white/20 transition-all">
                        <x-application-logo class="block h-6 w-auto fill-current text-white" />
                    </a>
                </div>

                {{-- MENU NAVIGASI UTAMA (UKURAN & FONT DISERAGAMKAN) --}}
                <div class="hidden sm:flex sm:items-center gap-1">
                    
                    @php
                        // Style seragam untuk estetika yang konsisten
                        $baseStyle = "px-4 py-2 text-[11px] font-bold uppercase tracking-wider text-white/90 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-200";
                        $activeStyle = "bg-white/20 text-white shadow-sm border-none";
                    @endphp

                    {{-- 1. Dashboard --}}
                    <a href="{{ route('dashboard') }}" 
                       class="{{ $baseStyle }} {{ request()->routeIs('dashboard') ? $activeStyle : '' }}">
                        Dashboard
                    </a>

                    {{-- 2. Kontrol Admin (Dropdown) --}}
                    @if(Auth::user()->role === 'admin')
                    <div class="relative">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="{{ $baseStyle }} flex items-center gap-1 focus:outline-none {{ (request()->routeIs('users.*') || request()->routeIs('logs.*')) ? $activeStyle : '' }}">
                                    <span>Kontrol Admin</span>
                                    <svg class="h-3.5 w-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="p-1 bg-white">
                                    <x-dropdown-link :href="route('users.index')" class="rounded-md font-bold text-[10px] uppercase tracking-tight text-slate-600 hover:bg-emerald-50">
                                        Manajemen User
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('logs.index')" class="rounded-md font-bold text-[10px] uppercase tracking-tight text-emerald-600 border-t border-slate-50 hover:bg-emerald-50">
                                        Riwayat Aktivitas
                                    </x-dropdown-link>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    {{-- 3. Data Jaksa --}}
                    <a href="{{ route('jaksa.index') }}" 
                       class="{{ $baseStyle }} {{ request()->routeIs('jaksa.*') ? $activeStyle : '' }}">
                        Data Jaksa
                    </a>
                    @endif

                    {{-- 4. Pantauan Perkara --}}
                    <a href="{{ route('perkara.index') }}" 
                       class="{{ $baseStyle }} {{ (request()->routeIs('perkara.index') || (request()->routeIs('perkara.*') && !request()->routeIs('perkara.arsip.*'))) ? $activeStyle : '' }}">
                        Pantauan Perkara
                    </a>

                    {{-- 5. Pusat & Arsip --}}
                    <a href="{{ route('perkara.arsip.index') }}" 
                       class="{{ $baseStyle }} {{ request()->routeIs('perkara.arsip.*') ? $activeStyle : '' }}">
                        Pusat & Arsip
                    </a>
                </div>
            </div>

            {{-- USER PROFILE (SISI KANAN - VERSI PREMIUM) --}}
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-4 px-5 py-2 bg-white/10 border border-white/20 rounded-2xl hover:bg-white/20 transition-all duration-300 focus:outline-none group">
                            {{-- Info User --}}
                            <div class="flex flex-col items-end text-right">
                                <span class="text-[11px] font-bold text-white leading-tight">{{ Auth::user()->name }}</span>
                                <span class="text-[9px] font-black text-emerald-300 uppercase tracking-widest mt-0.5 opacity-80 group-hover:opacity-100 transition-opacity">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                            
                            {{-- Avatar Initial --}}
                            <div class="relative">
                                <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center text-[12px] font-bold text-white shadow-lg border border-white/20 group-hover:scale-105 transition-transform">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-emerald-600 rounded-full animate-pulse"></div>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="p-2 bg-white rounded-xl">
                            <div class="px-4 py-3 mb-1 bg-slate-50 rounded-lg">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Sesi</p>
                                <p class="text-[10px] font-bold text-slate-700 truncate italic">Aktif sebagai {{ Auth::user()->role }}</p>
                            </div>

                            <x-dropdown-link :href="route('profile.edit')" class="rounded-lg font-bold text-[10px] uppercase tracking-wider text-slate-600 hover:bg-emerald-50">
                                {{ __('Setelan Profil') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" 
                                        class="rounded-lg font-bold text-[10px] uppercase tracking-wider text-rose-600 hover:bg-rose-50"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Keluar Sistem') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>