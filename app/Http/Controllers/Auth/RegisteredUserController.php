<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman registrasi personil.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Tangani permintaan registrasi personil baru.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi data berdasarkan NIP dan Role
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:20', 'unique:'.User::class], // NIP sebagai identitas unik
            'role' => ['required', 'string', 'in:admin,pimpinan'], // Validasi pilihan role
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Simpan data user ke database
        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip, // Menyimpan NIP
            'role' => $request->role, // Menyimpan Role
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Setelah daftar, personil otomatis login
        Auth::login($user);

        // Arahkan ke dashboard utama
        return redirect(route('dashboard', absolute: false));
    }
}