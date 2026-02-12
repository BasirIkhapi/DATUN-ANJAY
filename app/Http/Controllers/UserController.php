<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Hanya Admin yang bisa buka menu ini
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak.');
        }

        $users = User::where('id', '!=', Auth::id())->get(); // Tampilkan user lain
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'nip'      => 'required|string|unique:users,nip', // NIP Unik
            'role'     => 'required|in:admin,staff',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name'     => $request->name,
            'nip'      => $request->nip,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'User berhasil didaftarkan!');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
