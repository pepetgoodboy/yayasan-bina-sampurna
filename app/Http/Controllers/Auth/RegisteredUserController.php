<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PertanyaanKeamanan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $pertanyaans = PertanyaanKeamanan::all();
        // dd($pertanyaan);
        return view('auth.register', compact('pertanyaans'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
        'id_pertanyaan' => ['required', 'integer', 'exists:pertanyaan_keamanans,id'],
        'jawaban' => ['required', 'string', 'max:255'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'id_pertanyaan' => $request->id_pertanyaan,
        'jawaban' => $request->jawaban,
    ]);

    $user->assignRole('ortu');

    return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Silakan Masuk.');
    }
}
