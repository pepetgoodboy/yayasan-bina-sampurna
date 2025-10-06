<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::withCount('siswa')->get();
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas'
        ]);
        
        Kelas::create($request->all());
        
        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(Kelas $kela)
    {
        $kela->load('siswa.ortu');
        return view('kelas.show', ['kelas' => $kela]);
    }

    public function edit(Kelas $kela)
    {
        return view('kelas.edit', ['kelas' => $kela]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,' . $kela->id
        ]);
        
        $kela->update($request->all());
        
        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        if ($kela->siswa()->count() > 0) {
            return redirect()->route('kelas.index')
                ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa.');
        }
        
        $kela->delete();
        
        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
