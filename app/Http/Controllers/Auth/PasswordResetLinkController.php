<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PertanyaanKeamanan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        $pertanyaans = PertanyaanKeamanan::all();
        return view('auth.forgot-password', compact('pertanyaans'));
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {   
        $request->validate([
                'email' => ['required', 'email', 'lowercase', 'email', 'max:255', 'exists:users,email'],
                'id_pertanyaan' => ['required', 'integer', 'exists:pertanyaan_keamanans,id'],
                'jawaban' => ['required', 'string', 'max:255'],
                'password' => ['required', 'min:8'],
            ]);

            $user = User::where('email', $request->email)
                        ->where('id_pertanyaan', $request->id_pertanyaan)
                        ->where('jawaban', $request->jawaban)
                        ->first();
            
            if (!$user) {
                return redirect()->back()->with('error', 'Pertanyaan atau jawaban keamanan salah. Silakan coba lagi.');
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);
            return redirect()->route('login')->with('success', 'Kata sandi berhasil diubah. Silakan masuk dengan kata sandi baru Anda.');            
    }
}
