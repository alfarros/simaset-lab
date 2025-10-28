<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user.
     */
    public function index()
    {
        // Ambil semua user kecuali user yang sedang login, urutkan nama
        // $users = User::where('id', '!=', auth()->id())->orderBy('name')->paginate(15); 
        // Atau tampilkan semua termasuk diri sendiri:
         $users = User::orderBy('name')->paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan form tambah user baru.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Menyimpan user baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Pastikan email unik
            'password' => ['required', 'confirmed', Password::defaults()], // Validasi password kuat & konfirmasi
            'role' => ['required', Rule::in(['admin', 'staf'])], // Validasi role
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Hash password!
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')->with('success', 'User baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit user.
     */
    public function edit(User $user) // Gunakan Route Model Binding
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Mengupdate data user di database.
     */
    public function update(Request $request, User $user) // Gunakan Route Model Binding
    {
         $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Email unik, tapi abaikan user saat ini
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)], 
            'role' => ['required', Rule::in(['admin', 'staf'])],
             // Password opsional saat update
            'password' => ['nullable', 'confirmed', Password::defaults()], 
        ]);

        // Siapkan data update
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        // Hanya update password jika diisi
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus user dari database.
     */
    public function destroy(User $user) // Gunakan Route Model Binding
    {
        // Pencegahan: Jangan biarkan admin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Opsional: Tambahkan pencegahan agar tidak bisa menghapus admin terakhir (jika perlu)
        // if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
        //     return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus admin terakhir.');
        // }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    // Method show() tidak kita pakai karena detail bisa dilihat/diedit di halaman edit
    public function show(User $user)
    {
       return redirect()->route('users.edit', $user);
    }
}