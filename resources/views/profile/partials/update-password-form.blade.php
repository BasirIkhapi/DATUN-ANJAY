<section>
    <header>
        <h2 class="text-lg font-black text-emerald-900 uppercase tracking-tighter italic">
            {{ __('Keamanan Otentikasi') }}
        </h2>
        <p class="mt-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" class="font-black text-emerald-900 uppercase text-[10px] tracking-widest" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="block mt-1 w-full bg-slate-50 border-slate-200 rounded-2xl focus:ring-emerald-500 font-bold" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="font-black text-emerald-900 uppercase text-[10px] tracking-widest" />
            <x-text-input id="update_password_password" name="password" type="password" class="block mt-1 w-full bg-slate-50 border-slate-200 rounded-2xl focus:ring-emerald-500 font-bold" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="font-black text-emerald-900 uppercase text-[10px] tracking-widest" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block mt-1 w-full bg-slate-50 border-slate-200 rounded-2xl focus:ring-emerald-500 font-bold" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-slate-900 hover:bg-emerald-600 text-white font-black py-3 px-8 rounded-2xl transition-all shadow-lg text-[10px] tracking-widest uppercase active:scale-95">
                {{ __('Perbarui Sandi') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-[10px] font-black text-emerald-600 uppercase italic">
                    {{ __('Sandi Berhasil Diperbarui.') }}
                </p>
            @endif
        </div>
    </form>
</section>