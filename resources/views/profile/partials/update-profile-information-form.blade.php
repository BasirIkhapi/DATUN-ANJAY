<section>
    <header>
        <h2 class="text-lg font-black text-emerald-900 uppercase tracking-tighter italic">
            {{ __('Informasi Profil Personil') }}
        </h2>
        <p class="mt-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
            {{ __("Perbarui data nama dan Nomor Induk Pegawai (NIP) Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-black text-emerald-900 uppercase text-[10px] tracking-widest" />
            <x-text-input id="name" name="name" type="text" class="block mt-1 w-full bg-slate-50 border-slate-200 rounded-2xl focus:ring-emerald-500 font-bold uppercase" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="nip" :value="__('Nomor Induk Pegawai (NIP)')" class="font-black text-emerald-900 uppercase text-[10px] tracking-widest" />
            <x-text-input id="nip" name="nip" type="text" class="block mt-1 w-full bg-slate-50 border-slate-200 rounded-2xl focus:ring-emerald-500 font-bold" :value="old('nip', $user->nip)" required />
            <x-input-error class="mt-2" :messages="$errors->get('nip')" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black py-3 px-8 rounded-2xl transition-all shadow-lg shadow-emerald-100 text-[10px] tracking-widest uppercase active:scale-95">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-[10px] font-black text-emerald-600 uppercase italic">
                    {{ __('Data Berhasil Disimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>