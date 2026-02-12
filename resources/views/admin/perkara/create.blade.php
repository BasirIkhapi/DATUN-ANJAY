<x-app-layout>
    {{-- CSS Khusus untuk pembersihan ikon dropdown dan efek upload --}}
    <style>
        .clean-select {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            background-image: none !important;
        }
        .clean-select::-ms-expand { display: none !important; }
        
        .upload-area:hover { border-color: #10b981; background-color: #f0fdf4; }
        .upload-area.dragging { border-color: #059669; background-color: #ecfdf5; scale: 1.02; }
    </style>

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4 text-left">
                <div class="p-3 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl shadow-lg shadow-emerald-200 transition-transform hover:scale-105 duration-300">
                    <svg width="22" height="22" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-xl text-slate-800 leading-tight uppercase tracking-tight">
                        Registrasi <span class="text-emerald-600">Perkara Baru</span>
                    </h2>
                    <p class="text-[9px] font-bold text-slate-400 tracking-[0.2em] uppercase mt-0.5 leading-none">Otoritas Administrasi Kejaksaan Negeri Banjarmasin</p>
                </div>
            </div>
            
            <a href="{{ route('perkara.index') }}" class="group flex items-center gap-2 px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-[10px] font-black uppercase text-slate-500 hover:border-emerald-500 hover:text-emerald-600 transition-all tracking-widest shadow-sm">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="group-hover:-translate-x-1 transition-transform"><path stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Pantauan
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-[#f8fafc] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi Error Validasi --}}
            @if ($errors->any())
                <div class="mb-8 p-6 bg-white border-l-8 border-rose-500 rounded-3xl shadow-xl shadow-rose-100/50 animate-pulse">
                    <div class="flex items-center gap-4 mb-3 text-left">
                        <div class="p-2 bg-rose-100 rounded-lg text-rose-600">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="text-sm font-black text-rose-700 uppercase tracking-widest">Kesalahan Registrasi:</h4>
                    </div>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-1 text-[10px] font-bold text-rose-500 uppercase tracking-wider ml-2 text-left">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center gap-2"><span class="w-1 h-1 bg-rose-400 rounded-full"></span> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM CARD UTAMA --}}
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-200/60 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600"></div>
                
                <div class="p-10 md:p-12">
                    <form action="{{ route('perkara.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10 text-left">
                        @csrf
                        
                        {{-- SECTION 1: IDENTITAS PERKARA --}}
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 text-left">
                                <div class="w-8 h-[2px] bg-emerald-500"></div>
                                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] italic">1. Identitas Primer Perkara</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">
                                <div class="space-y-2.5">
                                    <label for="nomor_perkara" class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nomor Registrasi Perkara</label>
                                    <div class="relative group">
                                        <input type="text" id="nomor_perkara" name="nomor_perkara" value="{{ old('nomor_perkara') }}" required 
                                            placeholder="Contoh: 01/Pdt.G/2026/PN Bjm" 
                                            class="w-full h-14 px-6 bg-slate-50 border-slate-200 border-2 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-slate-700 transition-all outline-none text-sm shadow-sm">
                                    </div>
                                </div>
                                
                                <div class="space-y-2.5">
                                    <label for="jaksa_id" class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jaksa Pengacara Negara (JPN)</label>
                                    <div class="relative group">
                                        <select id="jaksa_id" name="jaksa_id" required 
                                            class="clean-select w-full h-14 pl-6 pr-12 bg-slate-50 border-slate-200 border-2 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-slate-700 transition-all outline-none text-sm cursor-pointer shadow-sm">
                                            <option value="" disabled selected>Pilih Penanggung Jawab...</option>
                                            @foreach($jaksas as $jaksa)
                                                <option value="{{ $jaksa->id }}" {{ old('jaksa_id') == $jaksa->id ? 'selected' : '' }}>
                                                    {{ strtoupper($jaksa->nama_jaksa) }} (NIP. {{ $jaksa->nip }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-5 top-1/2 -translate-y-1/2 text-emerald-600 pointer-events-none transition-colors">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="stroke-[3]"><path d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 2: PARA PIHAK --}}
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 text-left">
                                <div class="w-8 h-[2px] bg-blue-500"></div>
                                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] italic">2. Klasifikasi & Subjek Hukum</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">
                                <div class="space-y-2.5">
                                    <label for="penggugat" class="text-[10px] font-black text-blue-600 uppercase tracking-widest ml-1 flex items-center gap-2">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span> Pihak Penggugat
                                    </label>
                                    <input type="text" id="penggugat" name="penggugat" value="{{ old('penggugat') }}" required 
                                        placeholder="Nama Instansi / Perorangan"
                                        class="w-full h-14 px-6 bg-slate-50 border-slate-200 border-2 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white font-bold text-slate-700 transition-all outline-none text-sm">
                                </div>

                                <div class="space-y-2.5">
                                    <label for="tergugat" class="text-[10px] font-black text-rose-600 uppercase tracking-widest ml-1 flex items-center gap-2">
                                        <span class="w-2 h-2 bg-rose-500 rounded-full animate-pulse"></span> Pihak Tergugat
                                    </label>
                                    <input type="text" id="tergugat" name="tergugat" value="{{ old('tergugat') }}" required 
                                        placeholder="Nama Instansi / Perorangan"
                                        class="w-full h-14 px-6 bg-slate-50 border-slate-200 border-2 rounded-2xl focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 focus:bg-white font-bold text-slate-700 transition-all outline-none text-sm">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6 pt-4">
                                <div class="space-y-2.5">
                                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 leading-none">Klasifikasi Jenis Perkara</label>
                                    <div class="flex p-1 bg-slate-100 rounded-2xl border border-slate-200/60 shadow-inner">
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="jenis_perkara" value="Perdata" class="hidden peer" {{ old('jenis_perkara', 'Perdata') == 'Perdata' ? 'checked' : '' }}>
                                            <div class="py-3 text-center rounded-xl font-black text-[9px] uppercase tracking-widest transition-all peer-checked:bg-white peer-checked:text-emerald-600 peer-checked:shadow-sm text-slate-400">Perdata</div>
                                        </label>
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="jenis_perkara" value="Tata Usaha Negara" class="hidden peer" {{ old('jenis_perkara') == 'Tata Usaha Negara' ? 'checked' : '' }}>
                                            <div class="py-3 text-center rounded-xl font-black text-[9px] uppercase tracking-widest transition-all peer-checked:bg-white peer-checked:text-emerald-600 peer-checked:shadow-sm text-slate-400">T.U.N</div>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="space-y-2.5">
                                    <label for="tanggal_masuk" class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 leading-none">Tanggal Masuk Berkas</label>
                                    <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required 
                                        class="w-full h-14 px-6 bg-slate-50 border-slate-200 border-2 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-slate-700 transition-all outline-none text-sm cursor-pointer">
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 3: DOKUMEN SKK (REVISI DOSPEM) --}}
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 text-left">
                                <div class="w-8 h-[2px] bg-amber-500"></div>
                                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] italic">3. Lampiran Berkas Kuasa</h3>
                            </div>

                            <div class="space-y-2.5">
                                <label for="file_skk" class="text-[10px] font-black text-amber-600 uppercase tracking-widest ml-1 flex items-center gap-2">
                                    Surat Kuasa Khusus (SKK) - Format PDF
                                </label>
                                <div class="upload-area relative group p-10 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2.5rem] transition-all duration-300 flex flex-col items-center justify-center gap-4 cursor-pointer">
                                    <input type="file" id="file_skk" name="file_skk" required 
                                        class="absolute inset-0 opacity-0 cursor-pointer z-10"
                                        accept="application/pdf">
                                    
                                    <div class="p-4 bg-white rounded-2xl shadow-sm text-amber-500 group-hover:scale-110 transition-transform duration-300">
                                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    </div>
                                    
                                    <div class="text-center">
                                        <p class="text-[10px] font-black text-slate-700 uppercase tracking-widest mb-1">Klik atau Drag File ke Sini</p>
                                        <p class="text-[8px] text-slate-400 font-bold italic uppercase">Maksimal Ukuran Berkas: 5MB</p>
                                    </div>

                                    {{-- Preview file name using Alpine logic --}}
                                    <div id="file-name-preview" class="hidden px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-[9px] font-black uppercase border border-emerald-100">
                                        <span id="name-text"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ACTION BUTTON --}}
                        <div class="pt-6">
                            <button type="submit" class="group relative w-full h-20 bg-slate-900 rounded-3xl overflow-hidden transition-all hover:shadow-2xl hover:shadow-emerald-200 active:scale-[0.98]">
                                <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative flex items-center justify-center gap-4 text-white">
                                    <svg width="22" height="22" class="transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span class="font-black text-[11px] uppercase tracking-[0.4em]">Registrasi & Unggah Berkas</span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <p class="mt-8 text-center text-[9px] font-bold text-slate-400 uppercase tracking-widest italic">
                Aplikasi Monitoring Perkara - Kejaksaan Negeri Banjarmasin
            </p>
        </div>
    </div>

    <script>
        // Preview Nama File sederhana
        document.getElementById('file_skk').addEventListener('change', function(e) {
            const fileName = e.target.files[0].name;
            const preview = document.getElementById('file-name-preview');
            const text = document.getElementById('name-text');
            if (fileName) {
                preview.classList.remove('hidden');
                text.innerText = '📁 ' + fileName;
            }
        });

        // Efek Drag & Drop Visual
        const area = document.querySelector('.upload-area');
        ['dragenter', 'dragover'].forEach(name => {
            area.addEventListener(name, () => area.classList.add('dragging'), false);
        });
        ['dragleave', 'drop'].forEach(name => {
            area.addEventListener(name, () => area.classList.remove('dragging'), false);
        });
    </script>
</x-app-layout>