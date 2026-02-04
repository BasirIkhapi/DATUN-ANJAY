<nav x-data="{ open: false }" class="bg-gradient-to-r from-emerald-600 to-emerald-700 border-b border-emerald-500 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center group transition-all duration-300 p-2 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/10 hover:bg-white/20">
                        <x-application-logo />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-12 sm:flex items-center">
                    
                    {{-- Dashboard (Dibuat Lebih Besar & Dominan) --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="font-black text-[13px] uppercase tracking-[0.2em] text-white hover:text-emerald-200 transition-all border-b-2 {{ request()->routeIs('dashboard') ? 'border-white' : 'border-transparent' }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- Data Jaksa (Ukuran Seimbang dengan font-black) --}}
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('jaksa.index')" :active="request()->routeIs('jaksa.*')" 
                            class="font-black text-[10px] uppercase tracking-[0.2em] text-white hover:text-white transition-colors border-none">
                            {{ __('Data Jaksa') }}
                        </x-nav-link>
                    @endif

                    {{-- Dropdown Laporan & Arsip (Ukuran Seimbang dengan font-black) --}}
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="56">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 text-[10px] font-black uppercase tracking-[0.2em] text-white hover:text-white focus:outline-none transition duration-150">
                                    <div>Laporan & Arsip</div>
                                    <div class="ms-2">
                                        <svg class="fill-current h-4 w-4 opacity-60" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="p-2 space-y-1">
                                    <x-dropdown-link :href="route('perkara.statistik')" target="_blank" class="rounded-xl font-black text-[10px] uppercase tracking-wider text-emerald-900">
                                        {{ __('Statistik Perkara') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('perkara.arsip')" target="_blank" class="rounded-xl font-black text-[10px] uppercase tracking-wider text-emerald-900">
                                        {{ __('Arsip Selesai') }}
                                    </x-dropdown-link>
                                    <div class="border-t border-emerald-50 my-1"></div>
                                    <x-dropdown-link :href="route('admin.perkara.rekap')" target="_blank" class="rounded-xl font-black text-[10px] uppercase tracking-wider text-red-600 bg-red-50">
                                        {{ __('Rekapitulasi PDF') }}
                                    </x-dropdown-link>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-5 py-2.5 bg-white/10 backdrop-blur-md border border-white/20 text-[10px] font-black rounded-2xl text-white hover:bg-white/20 transition-all duration-300 uppercase tracking-widest italic group">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 bg-emerald-300 rounded-full animate-pulse shadow-[0_0_8px_rgba(110,231,183,0.8)]"></div>
                                {{ Auth::user()->name }}
                            </div>
                            <div class="ms-3 opacity-50 group-hover:opacity-100 transition-opacity">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 text-[9px] font-black text-emerald-900/40 uppercase tracking-[0.2em] border-b border-emerald-50">
                            Role: {{ Auth::user()->role }}
                        </div>
                        <div class="p-2">
                            <x-dropdown-link :href="route('profile.edit')" class="rounded-xl font-bold text-[10px] uppercase tracking-wider text-emerald-900">
                                {{ __('Profil Akun') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" class="rounded-xl font-bold text-[10px] uppercase tracking-wider text-red-600"
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