<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg shadow-blue-200">
                    <svg width="24" height="24" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-xl text-gray-800 leading-tight tracking-tight uppercase">
                        Daftar <span class="text-blue-600">Jaksa Pengacara Negara</span>
                    </h2>
                    <p class="text-[10px] font-bold text-gray-400 tracking-[0.2em] uppercase mt-1 italic">Personel JPN Aktif Kejari</p>
                </div>
            </div>
            
            {{-- TOMBOL CETAK DAFTAR JAKSA --}}
            <a href="{{ route('jaksa.cetak') }}" target="_blank" class="px-6 py-2.5 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest rounded-xl shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-all flex items-center gap-2">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Daftar Jaksa
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-blue-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- FORM REGISTRASI JAKSA BARU --}}
            @if(Auth::user()->role === 'admin')
            <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl shadow-blue-900/5 border border-white">
                <h4 class="font-black text-gray-400 uppercase text-[10px] tracking-[0.3em] mb-8 flex items-center gap-3">
                    <span class="w-10 h-[2px] bg-blue-500"></span> Registrasi Jaksa Baru
                </h4>
                <form action="{{ route('jaksa.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    @csrf
                    <div class="md:col-span-7">
                        <input type="text" name="nama_jaksa" required placeholder="NAMA LENGKAP JAKSA (BESERTA GELAR)" 
                            class="w-full px-8 py-5 bg-gray-50 border-gray-100 border-2 rounded-[2rem] focus:ring-4 focus:ring-blue-500/10 focus:bg-white font-bold text-gray-700 transition-all outline-none uppercase text-sm tracking-tight">
                    </div>
                    <div class="md:col-span-3">
                        <input type="text" name="nip" required placeholder="NIP" 
                            class="w-full px-8 py-5 bg-gray-50 border-gray-100 border-2 rounded-[2rem] focus:ring-4 focus:ring-blue-500/10 focus:bg-white font-bold text-gray-700 transition-all outline-none text-sm tracking-widest">
                    </div>
                    <div class="md:col-span-2">
                        <button type="submit" class="w-full h-full py-5 bg-blue-600 text-white font-black text-[10px] uppercase tracking-[0.2em] rounded-[2rem] shadow-xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1 transition-all active:scale-95">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
            @endif

            {{-- LIST PERSONEL JPN AKTIF --}}
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-blue-900/5 border border-white overflow-hidden">
                <div class="p-10 border-b border-gray-50 bg-gradient-to-r from-white to-blue-50/20">
                    <h4 class="font-black text-gray-800 uppercase text-xs tracking-[0.2em] italic flex items-center gap-3">
                        <div class="w-2 h-6 bg-blue-500 rounded-full"></div> Personel JPN Aktif
                    </h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Profil</th>
                                <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">NIP</th>
                                <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Total Perkara</th>
                                <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($jaksas as $jaksa)
                            <tr class="group hover:bg-blue-50/30 transition-all duration-300">
                                <td class="px-10 py-6">
                                    <div class="flex items-center gap-5">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center text-white font-black shadow-lg shadow-blue-100 group-hover:rotate-6 transition-transform">
                                            {{ substr($jaksa->nama_jaksa, 0, 1) }}
                                        </div>
                                        <span class="font-black text-sm text-gray-800 uppercase tracking-tighter italic">{{ $jaksa->nama_jaksa }}</span>
                                    </div>
                                </td>
                                <td class="px-10 py-6 text-center text-xs font-bold text-gray-400 tracking-widest">{{ $jaksa->nip }}</td>
                                <td class="px-10 py-6 text-center">
                                    <span class="px-4 py-1.5 bg-white text-blue-600 border border-blue-100 rounded-xl font-black text-[10px] shadow-sm uppercase">
                                        {{-- PERBAIKAN: Menggunakan relasi 'perkaras' (jamak) sesuai Model --}}
                                        {{ $jaksa->perkaras ? $jaksa->perkaras->count() : 0 }} Perkara
                                    </span>
                                </td>
                                <td class="px-10 py-6 text-center">
                                    @if(Auth::user()->role === 'admin')
                                    <form action="{{ route('jaksa.destroy', $jaksa->id) }}" method="POST" onsubmit="return confirm('Hapus Jaksa ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-3.5 bg-red-50 text-red-500 rounded-2xl hover:bg-red-600 hover:text-white transition-all shadow-sm border border-red-100 active:scale-90">
                                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-20 text-center opacity-30 italic">
                                    <p class="font-black text-xs uppercase tracking-[0.4em]">Belum Ada Personel Terdaftar</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>