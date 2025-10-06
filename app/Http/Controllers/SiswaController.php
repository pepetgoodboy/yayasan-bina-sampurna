<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use App\Exports\SiswaExport;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index()
    {
        $search = request('search');
        $kelas = request('kelas');
        
        $query = Siswa::with(['kelas', 'ortu']);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%')
                  ->orWhereHas('ortu', function($subQ) use ($search) {
                      $subQ->where('name', 'like', '%' . $search . '%');
                  });
            });
        }
        
        if ($kelas) {
            $query->where('id_kelas', $kelas);
        }
        
        $siswa = $query->orderBy('nama')->paginate(10);
        $kelasList = \App\Models\Kelas::all();
        
        return view('siswa.index', compact('siswa', 'kelasList'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $ortu = User::role('ortu')->get();
        return view('siswa.create', compact('kelas', 'ortu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswa',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'id_kelas' => 'required|exists:kelas,id',
            'id_ortu' => 'nullable|exists:users,id'
        ]);
        
        Siswa::create($request->all());
        
        return redirect()->route('siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['kelas', 'ortu', 'pembayaran.jenisPembayaran']);
        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        $ortu = User::role('ortu')->get();
        return view('siswa.edit', compact('siswa', 'kelas', 'ortu'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswa,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'id_kelas' => 'required|exists:kelas,id',
            'id_ortu' => 'required|exists:users,id'
        ]);
        
        $siswa->update($request->all());
        
        return redirect()->route('siswa.index')
            ->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->pembayaran()->count() > 0) {
            return redirect()->route('siswa.index')
                ->with('error', 'Siswa tidak dapat dihapus karena memiliki riwayat pembayaran.');
        }
        
        $siswa->delete();
        
        return redirect()->route('siswa.index')
            ->with('success', 'Siswa berhasil dihapus.');
    }
    
    public function exportExcel()
    {
        $search = request('search');
        $kelas = request('kelas');
        
        return Excel::download(
            new SiswaExport($search, $kelas),
            'Data-Siswa-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
