<x-app-layout>
    {{-- HEADER: PANEL TAMBAH PERSONEL --}}
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl shadow-lg shadow-emerald-200">
                <svg width="24" height="24" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-black text-xl text-gray-800 leading-tight uppercase tracking-tight">
                    Tambah <span class="text-emerald-600">Personel JPN</span>
                </h2>
                <p class="text-[10px] font-bold text-gray-400 tracking-[0.2em] uppercase mt-1 italic">Registrasi Jaksa Pengacara Negara</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-emerald-50/30 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ALERT ERROR --}}
            @if ($errors->any())
                <div class="mb-8 p-6 bg-red-50 border-l-8 border-red-500 rounded-3xl shadow-xl shadow-red-100">
                    <div class="flex items-center gap-4 mb-3">
                        <svg width="24" height="24" class="text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h4 class="text-sm font-black text-red-700 uppercase tracking-widest">Validasi Gagal!</h4>
                    </div>
                    <ul class="list-disc list-inside text-[11px] font-bold text-red-600 uppercase tracking-wider space-y-1 ml-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl shadow-emerald-900/5 border border-white relative overflow-hidden">
                {{-- Dekorasi Background --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-bl-full -mr-10 -mt-10"></div>

                <h3 class="text-[10px] font-black text-emerald-900 mb-8 uppercase tracking-[0.3em] flex items-center gap-3 italic">
                    <span class="w-12 h-[2px] bg-emerald-500"></span> Identitas Jaksa Baru
                </h3>

                {{-- FORM START - PENTING: Harus ada enctype untuk upload file --}}
                <form action="{{ route('jaksa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    {{-- UPLOAD FOTO DENGAN PREVIEW --}}
                    <div class="flex flex-col items-center justify-center space-y-4 mb-10">
                        <div class="relative group">
                            <div class="w-32 h-32 bg-gray-100 rounded-[2.5rem] overflow-hidden border-4 border-white shadow-xl ring-2 ring-emerald-500/20 flex items-center justify-center">
                                <img id="preview-foto" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                                <svg id="placeholder-icon" class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <label for="foto-input" class="absolute -bottom-2 -right-2 bg-emerald-600 p-3 rounded-2xl text-white shadow-lg cursor-pointer hover:bg-emerald-700 transition-all active:scale-90 border-4 border-white">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </label>
                            <input type="file" name="foto" id="foto-input" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic">Klik tombol hijau untuk upload foto profil</p>
                    </div>

                    {{-- INPUT NAMA --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap & Gelar Jaksa</label>
                        <input type="text" name="nama_jaksa" value="{{ old('nama_jaksa') }}" required placeholder="Contoh: Basir Ikhapi, S.H., M.H." 
                            class="w-full px-6 py-5 bg-gray-50 border-gray-100 border-2 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white font-bold text-gray-700 transition-all outline-none text-sm uppercase">
                    </div>

                    {{-- TOMBOL SIMPAN --}}
                    <div class="pt-6">
                        <button type="submit" class="w-full py-5 bg-gradient-to-r from-emerald-600 to-teal-700 text-white font-black text-[10px] uppercase tracking-[0.3em] rounded-3xl shadow-xl shadow-emerald-100 hover:shadow-emerald-200 hover:-translate-y-1 transition-all active:scale-95 flex items-center justify-center gap-3">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            DAFTARKAN PERSONEL JAKSA
                        </button>
                    </div>
                </form>
            </div>
            
            <p class="text-center mt-8 text-[10px] font-black text-gray-400 uppercase tracking-widest opacity-50 italic">
                Sistem Informasi Monitoring - Bidang DATUN Kejaksaan
            </p>
        </div>
    </div>

    {{-- SCRIPT PREVIEW FOTO --}}
    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview-foto');
            const icon = document.getElementById('placeholder-icon');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    icon.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>