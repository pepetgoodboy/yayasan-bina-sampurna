<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPembayaran;

class JenisPembayaranController extends Controller
{
    public function index()
    {
        $jenis = JenisPembayaran::withCount('pembayaran')->get();
        $jenisPembayaran = JenisPembayaran::orderBy('id')->paginate(10);
        return view('jenis-pembayaran.index', compact('jenisPembayaran'));
    }

    public function create()
    {
        return view('jenis-pembayaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenjang' => 'nullable|in:TK,SD',
            'gender' => 'nullable|in:L,P,ALL',
            'kelas_min' => 'nullable|integer|min:1|max:6',
            'kelas_max' => 'nullable|integer|min:1|max:6|gte:kelas_min',
            'gelombang' => 'nullable|integer|min:1|max:4',
            'tipe' => 'required|in:bulanan,tahunan,sekali',
            'total_tagihan' => 'required|numeric|min:0',
            'bisa_cicil' => 'boolean'
        ]);
        
        JenisPembayaran::create($request->all());
        
        return redirect()->route('jenis-pembayaran.index')
            ->with('success', 'Jenis pembayaran berhasil ditambahkan.');
    }

    public function show(JenisPembayaran $jenisPembayaran)
    {
        $jenisPembayaran->load('pembayaran.siswa');
        return view('jenis-pembayaran.show', compact('jenisPembayaran'));
    }

    public function edit(JenisPembayaran $jenisPembayaran)
    {
        return view('jenis-pembayaran.edit', compact('jenisPembayaran'));
    }

    public function update(Request $request, JenisPembayaran $jenisPembayaran)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenjang' => 'nullable|in:TK,SD',
            'gender' => 'nullable|in:L,P,ALL',
            'kelas_min' => 'nullable|integer|min:1|max:6',
            'kelas_max' => 'nullable|integer|min:1|max:6|gte:kelas_min',
            'gelombang' => 'nullable|integer|min:1|max:4',
            'tipe' => 'required|in:bulanan,tahunan,sekali',
            'total_tagihan' => 'required|numeric|min:0',
            'bisa_cicil' => 'boolean'
        ]);
        
        $jenisPembayaran->update($request->all());
        
        return redirect()->route('jenis-pembayaran.index')
            ->with('success', 'Jenis pembayaran berhasil diperbarui.');
    }

    public function destroy(JenisPembayaran $jenisPembayaran)
    {
        if ($jenisPembayaran->pembayaran()->count() > 0) {
            return redirect()->route('jenis-pembayaran.index')
                ->with('error', 'Jenis pembayaran tidak dapat dihapus karena sudah digunakan.');
        }
        
        $jenisPembayaran->delete();
        
        return redirect()->route('jenis-pembayaran.index')
            ->with('success', 'Jenis pembayaran berhasil dihapus.');
    }
}
