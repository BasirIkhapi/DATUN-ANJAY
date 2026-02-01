<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl shadow-lg shadow-emerald-200">
                <svg width="24" height="24" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-black text-xl text-gray-800 leading-tight uppercase tracking-tight">
                    Tambah <span class="text-emerald-600">Perkara Baru</span>
                </h2>
                <p class="text-[10px] font-bold text-gray-400 tracking-[0.2em] uppercase mt-1 italic">Input Data Registrasi SIM-DATUN</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-emerald-50/30 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-8 p-6 bg-red-50 border-l-8 border-red-500 rounded-3xl shadow-xl shadow-red-100">
                    <div class="flex items-center gap-4 mb-3">
                        <svg width="24" height="24" class="text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h4 class="text-sm font-black text-red-700 uppercase tracking-widest">Mohon Perbaiki Kesalahan Berikut:</h4>
                    </div>
                    <ul class="list-disc list-inside text-[11px] font-bold text-red-600 uppercase tracking-wider space-y-1 ml-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl shadow-emerald-900/5 border border-white">
                <h3 class="text-[10px] font-black text-emerald-900 mb-8 uppercase tracking-[0.3em] flex items-center gap-3 italic">
                    <span class="w-12 h-[2px] bg-emerald-500"></span> Formulir Pendaftaran Perkara
                </h3>

                <form action="{{ route('perkara.store') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nomor Registrasi Perkara</label>
                            <input type="text" name="nomor_perkara" value="{{ old('nomor_perkara') }}" required 
                                placeholder="Contoh: 01/Pdt.G/2026/PN Bjm" 
                                class="w-full px-6 py-4 bg-gray-50 border-gray-100 border-2 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-gray-700 transition-all outline-none text-sm uppercase placeholder:text-gray-300">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Jaksa Pengacara Negara (JPN)</label>
                            <select name="jaksa_id" required class="w-full px-6 py-4 bg-gray-50 border-gray-100 border-2 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-gray-700 transition-all outline-none text-sm">
                                <option value="">Pilih Jaksa Pendamping...</option>
                                @foreach($jaksas as $jaksa)
                                    <option value="{{ $jaksa->id }}" {{ old('jaksa_id') == $jaksa->id ? 'selected' : '' }}>
                                        {{ $jaksa->nama_jaksa }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span> Pihak Penggugat
                            </label>
                            <input type="text" name="penggugat" value="{{ old('penggugat') }}" required 
                                placeholder="Nama Instansi/Perorangan"
                                class="w-full px-6 py-4 bg-gray-50 border-gray-100 border-2 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-gray-700 transition-all outline-none text-sm uppercase placeholder:text-gray-300">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Pihak Tergugat
                            </label>
                            <input type="text" name="tergugat" value="{{ old('tergugat') }}" required 
                                placeholder="Nama Instansi/Perorangan"
                                class="w-full px-6 py-4 bg-gray-50 border-gray-100 border-2 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-gray-700 transition-all outline-none text-sm uppercase placeholder:text-gray-300">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Klasifikasi Jenis Perkara</label>
                            <select name="jenis_perkara" required class="w-full px-6 py-4 bg-gray-50 border-gray-100 border-2 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-gray-700 transition-all outline-none text-sm">
                                <option value="PERDATA" {{ old('jenis_perkara') == 'PERDATA' ? 'selected' : '' }}>PERDATA</option>
                                <option value="TATA USAHA NEGARA" {{ old('jenis_perkara') == 'TATA USAHA NEGARA' ? 'selected' : '' }}>TATA USAHA NEGARA</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Tanggal Masuk Berkas</label>
                            <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required 
                                class="w-full px-6 py-4 bg-gray-50 border-gray-100 border-2 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-gray-700 transition-all outline-none text-sm">
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full py-5 bg-gradient-to-r from-emerald-600 to-teal-700 text-white font-black text-[10px] uppercase tracking-[0.3em] rounded-2xl shadow-xl shadow-emerald-100 hover:shadow-emerald-200 hover:-translate-y-1 transition-all active:scale-95 flex items-center justify-center gap-3">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            SIMPAN PERKARA
                        </button>
                    </div>
                </form>
            </div>
            
            <p class="text-center mt-8 text-[10px] font-black text-gray-400 uppercase tracking-widest opacity-50 italic">
                Sistem Informasi Monitoring - Bidang DATUN Kejaksaan
            </p>
        </div>
    </div>
</x-app-layout>