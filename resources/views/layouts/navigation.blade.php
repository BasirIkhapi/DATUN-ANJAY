<nav x-data="{ open: false }" class="bg-gradient-to-r from-emerald-600 to-emerald-700 border-b border-emerald-500 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                {{-- LOGO --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center group transition-all duration-300 p-2 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/10 hover:bg-white/20">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                {{-- MENU NAVIGASI UTAMA (URUTAN DISESUAIKAN) --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-12 sm:flex items-center">
                    
                    {{-- 1. Dashboard --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="font-black text-[11px] uppercase tracking-[0.2em] text-white hover:text-emerald-200 transition-all {{ request()->routeIs('dashboard') ? 'border-b-2 border-white' : 'border-none' }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- 2. Data Jaksa (Sekarang di Urutan Kedua) --}}
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('jaksa.index')" :active="request()->routeIs('jaksa.*')" 
                            class="font-black text-[11px] uppercase tracking-[0.2em] text-white hover:text-emerald-200 transition-all {{ request()->routeIs('jaksa.*') ? 'border-b-2 border-white' : 'border-none' }}">
                            {{ __('Data Jaksa') }}
                        </x-nav-link>
                    @endif

                    {{-- 3. Pantauan Perkara --}}
                    <x-nav-link :href="route('perkara.index')" :active="request()->routeIs('perkara.index') || (request()->routeIs('perkara.*') && !request()->routeIs('perkara.arsip.*'))" 
                        class="font-black text-[11px] uppercase tracking-[0.2em] text-white hover:text-emerald-200 transition-all {{ (request()->routeIs('perkara.index') || (request()->routeIs('perkara.*') && !request()->routeIs('perkara.arsip.*'))) ? 'border-b-2 border-white' : 'border-none' }}">
                        {{ __('Pantauan Perkara') }}
                    </x-nav-link>

                    {{-- 4. Pusat & Arsip --}}
                    <x-nav-link :href="route('perkara.arsip.index')" :active="request()->routeIs('perkara.arsip.*')" 
                        class="font-black text-[11px] uppercase tracking-[0.2em] text-white hover:text-emerald-200 transition-all {{ request()->routeIs('perkara.arsip.*') ? 'border-b-2 border-white' : 'border-none' }}">
                        {{ __('Pusat & Arsip') }}
                    </x-nav-link>
                </div>
            </div>

            {{-- USER PROFILE DROPDOWN --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-5 py-2.5 bg-white/10 backdrop-blur-md border border-white/20 text-[10px] font-black rounded-2xl text-white hover:bg-white/20 transition-all duration-300 uppercase tracking-widest italic group">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 bg-emerald-300 rounded-full animate-pulse shadow-[0_0_8px_rgba(110,231,183,0.8)]"></div>
                                {{ Auth::user()->name }}
                            </div>
                            <div class="ms-3 opacity-50 group-hover:opacity-100 transition-opacity text-white">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 text-[9px] font-black text-emerald-900/40 uppercase tracking-[0.2em] border-b border-emerald-50">
                            Otoritas: {{ Auth::user()->role }}
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

            {{-- Hamburger (Mobile) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-emerald-200 hover:text-white hover:bg-emerald-500 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Responsive Navigation Menu (Mobile - URUTAN DISESUAIKAN) --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-emerald-700">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('jaksa.index')" :active="request()->routeIs('jaksa.index')">
                    {{ __('Data Jaksa') }}
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('perkara.index')" :active="request()->routeIs('perkara.index')">
                {{ __('Pantauan Perkara') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('perkara.arsip.index')" :active="request()->routeIs('perkara.arsip.*')">
                {{ __('Pusat & Arsip') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>