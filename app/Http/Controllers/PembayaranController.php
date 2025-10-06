<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\JenisPembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $search = request('search');
        $kelas = request('kelas');
        $jenis = request('jenis');
        
        $query = Pembayaran::with(['siswa.kelas', 'jenisPembayaran']);
        
        if ($search) {
            $query->whereHas('siswa', function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%');
            });
        }
        
        if ($kelas) {
            $query->whereHas('siswa', function($q) use ($kelas) {
                $q->where('id_kelas', $kelas);
            });
        }
        
        if ($jenis) {
            $query->where('id_jenis', $jenis);
        }
        
        $pembayaran = $query->orderBy('tanggal_bayar', 'desc')->paginate(10);
        $kelasList = \App\Models\Kelas::all();
        $jenisList = \App\Models\JenisPembayaran::all();
        
        return view('pembayaran.index', compact('pembayaran', 'kelasList', 'jenisList'));
    }

    public function create()
    {
        $siswa = Siswa::with('kelas')->select('id', 'nis', 'nama', 'id_kelas', 'jenis_kelamin', 'gelombang')->get();
        $jenisPembayaran = JenisPembayaran::all();
        return view('pembayaran.create', compact('siswa', 'jenisPembayaran'));
    }
    
    public function getJenisPembayaranBySiswa(Request $request)
    {
        $siswaId = $request->siswa_id;
        if (!$siswaId) {
            return response()->json([]);
        }
        
        $siswa = Siswa::with('kelas')->find($siswaId);
        if (!$siswa) {
            return response()->json([]);
        }
        
        $jenisPembayaran = JenisPembayaran::all()->filter(function($jenis) use ($siswa) {
            return $jenis->isApplicableForSiswa($siswa);
        })->values();
        
        return response()->json($jenisPembayaran);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id',
            'id_jenis' => 'required|exists:jenis_pembayaran,id',
            'tanggal_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);
        
        $jenisPembayaran = JenisPembayaran::find($request->id_jenis);
        $totalBayar = Pembayaran::where('id_siswa', $request->id_siswa)
            ->where('id_jenis', $request->id_jenis)
            ->sum('jumlah_bayar');
        
        // Validasi pembayaran bulanan (harus full)
        if ($jenisPembayaran->tipe == 'bulanan' && $request->jumlah_bayar != $jenisPembayaran->total_tagihan) {
            return back()->withErrors(['jumlah_bayar' => 'Pembayaran bulanan harus dibayar penuh.']);
        }
        
        // Validasi tidak melebihi total tagihan
        if (($totalBayar + $request->jumlah_bayar) > $jenisPembayaran->total_tagihan) {
            $sisa = $jenisPembayaran->total_tagihan - $totalBayar;
            return back()->withErrors(['jumlah_bayar' => 'Jumlah pembayaran melebihi sisa tagihan. Sisa: Rp ' . number_format($sisa, 0, ',', '.')]);
        }
        
        Pembayaran::create($request->all());
        
        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['siswa.kelas', 'jenisPembayaran']);
        return view('pembayaran.show', compact('pembayaran'));
    }

    public function edit(Pembayaran $pembayaran)
    {
        $siswa = Siswa::with('kelas')->get();
        $jenisPembayaran = JenisPembayaran::all();
        return view('pembayaran.edit', compact('pembayaran', 'siswa', 'jenisPembayaran'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id',
            'id_jenis' => 'required|exists:jenis_pembayaran,id',
            'tanggal_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);
        
        $pembayaran->update($request->all());
        
        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        
        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus.');
    }
    
    public function getSisaTagihan(Request $request)
    {
        $siswa = $request->id_siswa;
        $jenis = $request->id_jenis;
        
        if (!$siswa || !$jenis) {
            return response()->json(['sisa' => 0]);
        }
        
        $jenisPembayaran = JenisPembayaran::find($jenis);
        $totalBayar = Pembayaran::where('id_siswa', $siswa)
            ->where('id_jenis', $jenis)
            ->sum('jumlah_bayar');
        
        $sisa = $jenisPembayaran->total_tagihan - $totalBayar;
        
        return response()->json([
            'sisa' => max($sisa, 0),
            'total_tagihan' => $jenisPembayaran->total_tagihan,
            'tipe' => $jenisPembayaran->tipe,
            'bisa_cicil' => $jenisPembayaran->bisa_cicil
        ]);
    }
}
