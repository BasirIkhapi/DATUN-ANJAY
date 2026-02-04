<x-app-layout>
    {{-- HEADER: MANAJEMEN PERSONEL JPN --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="relative group">
                    <div class="absolute -inset-1.5 bg-gradient-to-r from-emerald-500 to-teal-400 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-1000"></div>
                    <div class="relative p-4 bg-white rounded-2xl shadow-sm border border-emerald-50 flex items-center">
                        <svg width="28" height="28" class="text-emerald-600 transform group-hover:rotate-12 transition-all duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <h2 class="text-2xl font-black text-slate-800 tracking-tighter uppercase leading-none">
                        PERSONEL <span class="text-emerald-600 italic">JPN</span>
                    </h2>
                    <div class="flex items-center gap-3">
                        <div class="h-[2px] w-8 bg-emerald-500"></div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.4em]">Jaksa Pengacara Negara Terdaftar</p>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('jaksa.cetak') }}" target="_blank" class="group flex items-center gap-3 bg-white border-2 border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white font-black py-3 px-8 rounded-2xl transition-all duration-300 shadow-lg shadow-emerald-100 uppercase text-[10px] tracking-widest active:scale-95">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="group-hover:animate-bounce"><path stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Daftar Jaksa</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fcfdfe] min-h-screen relative overflow-hidden">
        {{-- Background Decoration --}}
        <div class="absolute top-0 right-0 w-[50%] h-[50%] bg-emerald-50/50 rounded-full blur-[120px] -z-10 translate-x-1/2 -translate-y-1/2"></div>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 relative z-10">
            
            {{-- FORM REGISTRASI JAKSA BARU --}}
            @if(Auth::user()->role === 'admin')
            <div class="bg-white p-10 rounded-[3.5rem] shadow-2xl shadow-slate-200/50 border border-white">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-1.5 h-6 bg-emerald-500 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.3)]"></div>
                    <h4 class="font-black text-slate-800 uppercase text-xs tracking-[0.3em] italic">Registrasi Personel Baru</h4>
                </div>
                
                <form action="{{ route('jaksa.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    @csrf
                    <div class="md:col-span-6">
                        <input type="text" name="nama_jaksa" required 
                            placeholder="Nama Lengkap Personel (Beserta Gelar)" 
                            class="w-full h-16 px-8 bg-slate-50 border-slate-100 border-2 rounded-[1.5rem] focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-slate-700 transition-all outline-none shadow-inner"
                            style="font-size: 13px; letter-spacing: 0px;">
                    </div>
                    <div class="md:col-span-4">
                        {{-- PERBAIKAN: Gaya tulisan dipaksa identik agar serasi --}}
                        <input type="text" name="nip" required 
                            placeholder="Nomor Induk Pegawai (NIP)" 
                            class="w-full h-16 px-8 bg-slate-50 border-slate-100 border-2 rounded-[1.5rem] focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-slate-700 transition-all outline-none shadow-inner"
                            style="font-size: 13px; letter-spacing: 0px; text-transform: none;">
                    </div>
                    <div class="md:col-span-2">
                        <button type="submit" class="w-full h-16 bg-slate-900 text-white font-black rounded-[1.5rem] shadow-xl shadow-slate-200 hover:bg-emerald-600 hover:-translate-y-1 transition-all active:scale-95 uppercase tracking-widest"
                            style="font-size: 11px;">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
            @endif

            {{-- TABEL PERSONEL JPN --}}
            <div class="bg-white rounded-[4rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.08)] border border-slate-100 overflow-hidden">
                <div class="p-10 border-b border-slate-50 bg-gradient-to-r from-white via-white to-emerald-50/20 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-3.5 h-12 bg-emerald-600 rounded-full shadow-lg shadow-emerald-200"></div>
                        <h4 class="font-black text-slate-800 uppercase text-2xl tracking-tighter italic leading-none">
                            Personel JPN <span class="text-emerald-600 font-black">Aktif</span>
                        </h4>
                    </div>
                    <div class="px-6 py-2.5 bg-white rounded-2xl border border-emerald-100 shadow-sm flex items-center gap-3">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-[10px] font-black text-emerald-800 uppercase tracking-widest leading-none">Otoritas Valid</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100 uppercase tracking-[0.4em]">
                                <th class="px-10 py-7 text-[11px] font-black text-slate-400">Profil Jaksa</th>
                                <th class="px-10 py-7 text-[11px] font-black text-slate-400 text-center">Identitas NIP</th>
                                <th class="px-10 py-7 text-[11px] font-black text-slate-400 text-center">Beban Perkara</th>
                                <th class="px-10 py-7 text-[11px] font-black text-slate-400 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($jaksas as $jaksa)
                            <tr class="group hover:bg-emerald-50/30 transition-all duration-500">
                                <td class="px-10 py-8">
                                    <div class="flex items-center gap-5">
                                        <div class="w-14 h-14 bg-emerald-600 rounded-2xl flex items-center justify-center text-white font-black shadow-lg shadow-emerald-100 group-hover:rotate-6 group-hover:scale-110 transition-all duration-500 border border-white/20">
                                            {{ substr($jaksa->nama_jaksa, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-black text-base text-slate-800 tracking-tight italic leading-tight group-hover:text-emerald-700 transition-colors">
                                                {{ $jaksa->nama_jaksa }}
                                            </span>
                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Jaksa Pengacara Negara</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-8 text-center">
                                    <span class="text-xs font-black text-slate-400 tracking-widest group-hover:text-slate-800 transition-colors">
                                        {{ $jaksa->nip }}
                                    </span>
                                </td>
                                <td class="px-10 py-8 text-center">
                                    <div class="inline-flex items-center gap-3 px-6 py-2 bg-slate-50 text-emerald-700 rounded-[1.2rem] font-black text-[11px] uppercase tracking-wider border border-slate-100 shadow-sm group-hover:bg-white group-hover:shadow-emerald-100 transition-all">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                        {{ $jaksa->perkaras ? $jaksa->perkaras->count() : 0 }} Perkara
                                    </div>
                                </td>
                                <td class="px-10 py-8 text-center">
                                    @if(Auth::user()->role === 'admin')
                                    <button type="button" 
                                        onclick="confirmDelete('{{ $jaksa->id }}')" 
                                        class="p-4 bg-rose-50 text-rose-600 rounded-2xl hover:bg-rose-600 hover:text-white transition-all shadow-lg shadow-rose-100/50 border border-rose-100 active:scale-90" title="Hapus Data">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>

                                    <form id="delete-form-{{ $jaksa->id }}" action="{{ route('jaksa.destroy', $jaksa->id) }}" method="POST" class="hidden">
                                        @csrf @method('DELETE')
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-40 text-center opacity-30 italic">
                                    <p class="font-black text-[10px] uppercase tracking-[0.5em]">No Personnel Records Detected</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- FOOTER IDENTITAS --}}
            <div class="pt-10 flex flex-col items-center gap-6 opacity-30">
                <div class="flex items-center gap-10">
                    <div class="h-[1px] w-48 bg-gradient-to-r from-transparent to-slate-400"></div>
                    <img src="{{ asset('img/logo jaksa.png') }}" class="w-12 h-auto grayscale">
                    <div class="h-[1px] w-48 bg-gradient-to-l from-transparent to-slate-400"></div>
                </div>
                <p class="text-[11px] font-black text-slate-800 uppercase tracking-[1.5em] italic leading-none text-center">Integritas • Profesionalisme • Kejari Banjarmasin</p>
            </div>
        </div>
    </div>

    {{-- SCRIPT SWEETALERT2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '<span class="text-2xl font-black uppercase italic tracking-tighter text-slate-800">BERHASIL</span>',
                    html: '<p class="text-sm font-bold text-slate-500 uppercase tracking-widest">{{ session('success') }}</p>',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    background: '#ffffff',
                    iconColor: '#10b981',
                    customClass: {
                        popup: 'rounded-[3rem] border-4 border-emerald-50 shadow-2xl',
                    }
                });
            @endif
        });

        function confirmDelete(id) {
            Swal.fire({
                title: '<span class="text-xl font-black uppercase italic text-slate-800">Hapus Personel?</span>',
                text: "Data JPN yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'YA, HAPUS',
                cancelButtonText: 'BATAL',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-[2.5rem] border-4 border-slate-50 shadow-2xl',
                    confirmButton: 'rounded-xl font-black tracking-widest text-xs py-3 px-6',
                    cancelButton: 'rounded-xl font-black tracking-widest text-xs py-3 px-6'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>