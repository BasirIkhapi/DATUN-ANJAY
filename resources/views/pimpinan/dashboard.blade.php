<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-bold text-xl text-emerald-800 leading-tight flex items-center gap-3">
                <div class="p-2 bg-emerald-100 rounded-lg shadow-sm">
                    <svg width="24" height="24" class="text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <span class="block text-[10px] text-emerald-600 font-bold uppercase tracking-widest leading-none mb-1">Laporan Eksekutif</span>
                    {{ __('Monitoring Perkara DATUN') }}
                </div>
            </h2>
            <div class="text-sm font-bold text-emerald-700 bg-white px-4 py-2 rounded-full border border-emerald-100 shadow-sm">
                Pimpinan: {{ Auth::user()->name }}
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-emerald-100 p-8 text-center relative">
                <div class="relative z-10">
                    <div class="inline-flex items-center justify-center p-4 bg-emerald-50 rounded-full mb-4 border-2 border-white shadow-sm text-emerald-500">
                        <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Selamat Datang, Bapak Pimpinan</h3>
                    <p class="text-emerald-600/70 font-medium italic">Silakan pantau perkembangan perkara DATUN melalui tabel di bawah ini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-8 border-emerald-500 hover:scale-[1.02] transition-transform">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Perkara</p>
                    <h4 class="text-4xl font-black text-emerald-900 leading-none mt-2">{{ $total_perkara }}</h4>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-8 border-blue-500 hover:scale-[1.02] transition-transform">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Perdata</p>
                    <h4 class="text-4xl font-black text-blue-900 leading-none mt-2">{{ $perdata }}</h4>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-8 border-teal-500 hover:scale-[1.02] transition-transform">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">T.U.N</p>
                    <h4 class="text-4xl font-black text-teal-900 leading-none mt-2">{{ $tun }}</h4>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-8 border-orange-500 hover:scale-[1.02] transition-transform">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Proses</p>
                    <h4 class="text-4xl font-black text-orange-900 leading-none mt-2">{{ $proses }}</h4>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-white text-emerald-800">
                    <h3 class="font-bold flex items-center gap-2 italic">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Daftar Pantauan Perkara Real-Time
                    </h3>
                    <a href="{{ route('admin.perkara.rekap') }}" target="_blank" class="text-[10px] font-bold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 px-4 py-2 rounded-lg transition uppercase tracking-widest border border-emerald-100 shadow-sm">
                        Cetak Laporan PDF
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-400 font-bold uppercase text-[10px] tracking-widest border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-black">No. Perkara</th>
                                <th class="px-6 py-4 font-black">Pihak/Instansi</th>
                                <th class="px-6 py-4 text-center font-black">Jenis</th>
                                <th class="px-6 py-4 text-center font-black">Status</th>
                                <th class="px-6 py-4 text-center font-black">Jaksa (JPN)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 uppercase">
                            @forelse($perkaras as $perkara)
                                <tr class="hover:bg-emerald-50/50 transition">
                                    <td class="px-6 py-4 font-extrabold text-blue-700">{{ $perkara->nomor_perkara }}</td>
                                    <td class="px-6 py-4 text-gray-600 font-medium">{{ $perkara->penggugat }} vs {{ $perkara->tergugat }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-[10px] font-bold border border-emerald-100">
                                            {{ $perkara->jenis_perkara }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 {{ $perkara->status_akhir == 'Selesai' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700 animate-pulse' }} rounded-full text-[10px] font-black border uppercase">
                                            {{ $perkara->status_akhir }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center italic text-gray-500 font-bold">
                                        {{ $perkara->jaksa->nama_jaksa ?? 'TIDAK ADA JPN' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="text-gray-200 mb-4">
                                                <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                </svg>
                                            </div>
                                            <p class="font-medium italic text-lg text-gray-400 font-sans uppercase tracking-widest">Belum ada data perkara yang masuk ke sistem.</p>
                                        </div>
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