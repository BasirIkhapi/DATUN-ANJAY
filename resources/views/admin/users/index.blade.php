<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 uppercase tracking-tight">
            Manajemen <span class="text-emerald-600">User & Personel</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-[#fcfdfe] min-h-screen text-left font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            {{-- SEKSI 1: FORM REGISTRASI (DIBUAT LEBIH KONTRAS) --}}
            <div class="bg-white p-12 rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-40 h-40 bg-emerald-50 rounded-bl-full -mr-16 -mt-16 opacity-50"></div>
                
                <div class="mb-10">
                    <h4 class="text-[11px] font-black text-emerald-600 uppercase tracking-[0.3em] mb-1 italic">Registrasi Akun Baru</h4>
                    <p class="text-xs text-slate-400 font-medium uppercase">Input kredensial akses untuk personel Kejaksaan</p>
                </div>

                <form action="{{ route('users.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-8 items-end relative z-10">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-700 uppercase ml-1 tracking-wider">Nama Lengkap</label>
                        <input type="text" name="name" placeholder="Contoh: Basir Ikhapi" required 
                            class="w-full h-14 px-6 rounded-2xl border-slate-200 bg-slate-50/50 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder:text-slate-300">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-700 uppercase ml-1 tracking-wider">NIP (Username)</label>
                        <input type="text" name="nip" placeholder="199XXXXXXXXX" required 
                            class="w-full h-14 px-6 rounded-2xl border-slate-200 bg-slate-50/50 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder:text-slate-300 uppercase">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-700 uppercase ml-1 tracking-wider">Role Akses</label>
                        <select name="role" required class="w-full h-14 px-6 rounded-2xl border-slate-200 bg-slate-50/50 text-[11px] font-black uppercase text-slate-600 focus:ring-2 focus:ring-emerald-500">
                            <option value="staff">STAFF (OPERASIONAL)</option>
                            <option value="admin">ADMIN (OTORITAS)</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-700 uppercase ml-1 tracking-wider">Password Akses</label>
                        <input type="password" name="password" placeholder="••••••••" required 
                            class="w-full h-14 px-6 rounded-2xl border-slate-200 bg-slate-50/50 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder:text-slate-300">
                    </div>
                    <div class="md:col-span-4 mt-4">
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.3em] hover:bg-emerald-600 shadow-xl shadow-slate-200 transition-all active:scale-[0.98]">
                            Daftarkan Akun Personel &rarr;
                        </button>
                    </div>
                </form>
            </div>

            {{-- SEKSI 2: DAFTAR PERSONEL (DIBUAT LEBIH TEGAS) --}}
            <div class="bg-white rounded-[3.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="px-12 py-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 uppercase tracking-tighter text-lg italic">Daftar Personel <span class="text-emerald-600 font-black">Aktif</span></h3>
                    <span class="px-4 py-2 bg-white border border-slate-100 rounded-full text-[9px] font-black text-slate-400 uppercase tracking-widest">Total: {{ $users->count() }} User</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 bg-white">
                                <th class="px-12 py-6">Nama Personel</th>
                                <th class="px-8 py-6">NIP / ID</th>
                                <th class="px-8 py-6 text-center">Role Akses</th>
                                <th class="px-12 py-6 text-right">Kontrol</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($users as $user)
                            <tr class="hover:bg-emerald-50/30 transition-all group">
                                <td class="px-12 py-8">
                                    <div class="font-bold text-slate-800 text-sm italic">{{ $user->name }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">Anggota Kejaksaan Negeri</div>
                                </td>
                                <td class="px-8 py-8 text-slate-500 text-xs font-mono tracking-tighter">{{ $user->nip }}</td>
                                <td class="px-8 py-8 text-center">
                                    <span class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $user->role == 'admin' ? 'bg-rose-100 text-rose-700 border border-rose-200' : 'bg-emerald-100 text-emerald-700 border border-emerald-200' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-12 py-8 text-right">
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus akses akun ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-rose-500 hover:text-rose-700 font-black text-[10px] uppercase tracking-tighter transition-all hover:scale-110">
                                            Hapus Akses
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-24 text-center opacity-30 italic font-bold text-[11px] uppercase tracking-[0.5em]">Belum ada user terdaftar selain Anda</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>