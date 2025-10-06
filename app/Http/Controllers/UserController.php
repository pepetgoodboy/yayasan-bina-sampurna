<?php

namespace App\Http\Controllers;

use App\Models\PertanyaanKeamanan;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles', 'pertanyaanKeamanan')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $pertanyaans = PertanyaanKeamanan::all();
        return view('users.create', compact('roles', 'pertanyaans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'id_pertanyaan' => 'required', 'integer', 'exists:pertanyaan_keamanans,id',
            'jawaban' => 'required', 'string', 'max:255',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_pertanyaan' => $request->id_pertanyaan,
            'jawaban' => $request->jawaban,
        ]);
        
        $user->assignRole($request->role);
        
        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $user->load(['roles', 'siswa.kelas']);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name'
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);
        
        $user->syncRoles([$request->role]);
        
        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->siswa()->count() > 0) {
            return redirect()->route('users.index')
                ->with('error', 'User tidak dapat dihapus karena memiliki siswa.');
        }
        
        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
