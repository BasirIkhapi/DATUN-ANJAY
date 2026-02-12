<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 uppercase tracking-tight">
            Riwayat <span class="text-emerald-600">Aktivitas Sistem</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-[#fcfdfe] min-h-screen text-left">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Panel Informasi Audit --}}
            <div class="bg-emerald-900 rounded-[2.5rem] p-8 mb-8 text-white shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] opacity-60 mb-2">Audit Trail</p>
                    <h3 class="text-2xl font-bold italic tracking-tighter">Transparansi Operasional Digital</h3>
                    <p class="mt-2 text-xs text-emerald-100/60 leading-relaxed italic uppercase">Setiap perubahan data perkara terekam otomatis demi akuntabilitas Kejaksaan.</p>
                </div>
                <svg class="absolute -right-8 -bottom-8 w-40 h-40 text-white/5 -rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            </div>

            {{-- Tabel Log --}}
            <div class="bg-white rounded-[3rem] shadow-xl border border-slate-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b">
                            <th class="px-8 py-6">Stempel Waktu</th>
                            <th class="px-8 py-6">Nama Personel</th>
                            <th class="px-8 py-6">Tindakan / Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($logs as $log)
                        <tr class="hover:bg-emerald-50/20 transition-all group">
                            <td class="px-8 py-6 text-[11px] font-medium text-slate-400">
                                {{ $log->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-slate-100 rounded-lg text-[10px] font-bold text-slate-700 uppercase tracking-wider">
                                    {{ $log->user->name ?? 'User Terhapus' }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-sm text-slate-600 italic font-medium">
                                {{ $log->deskripsi }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-24 text-center opacity-30 italic font-bold text-[11px] uppercase tracking-[0.4em]">
                                Belum ada jejak aktivitas terekam
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination Rapi --}}
                @if($logs->hasPages())
                <div class="p-8 bg-slate-50/50 border-t">
                    {{ $logs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>