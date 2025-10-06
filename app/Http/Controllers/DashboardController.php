<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Models\JenisPembayaran;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->hasRole('admin') || $user->hasRole('bendahara')) {
            return $this->adminBendaharaDashboard();
        } elseif ($user->hasRole('ortu')) {
            return $this->ortuDashboard();
        }
        
        return redirect()->route('login');
    }
    
    private function adminBendaharaDashboard()
    {
        // Statistik Utama
        $totalPemasukan = Pembayaran::sum('jumlah_bayar');
        $totalSiswa = Siswa::count();
        $totalKelas = \App\Models\Kelas::count();
        $totalOrtu = \App\Models\User::role('ortu')->count();
        
        // Pemasukan Periode
        $pemasukanHariIni = Pembayaran::whereDate('tanggal_bayar', today())->sum('jumlah_bayar');
        $pemasukanBulanIni = Pembayaran::whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)->sum('jumlah_bayar');
        $pemasukanTahunIni = Pembayaran::whereYear('tanggal_bayar', now()->year)->sum('jumlah_bayar');
        
        // Pembayaran per Jenis (Bulan Ini)
        $pembayaranPerJenis = Pembayaran::with('jenisPembayaran')
            ->whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->selectRaw('id_jenis, SUM(jumlah_bayar) as total')
            ->groupBy('id_jenis')
            ->get();
        
        // Siswa per Kelas
        $siswaPerKelas = Siswa::with('kelas')
            ->selectRaw('id_kelas, COUNT(*) as total')
            ->groupBy('id_kelas')
            ->get();
        
        // Pembayaran Terbaru (5 terakhir)
        $pembayaranTerbaru = Pembayaran::with(['siswa.kelas', 'jenisPembayaran'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Tunggakan (siswa yang belum bayar SPP bulan ini)
        $sppIds = JenisPembayaran::where('tipe', 'bulanan')->pluck('id');
        $tunggakan = [];
        if ($sppIds->isNotEmpty()) {
            $siswaYangSudahBayar = Pembayaran::whereIn('id_jenis', $sppIds)
                ->whereMonth('tanggal_bayar', now()->month)
                ->whereYear('tanggal_bayar', now()->year)
                ->pluck('id_siswa')
                ->unique();
                
            $tunggakan = Siswa::with(['kelas', 'ortu'])
                ->whereNotIn('id', $siswaYangSudahBayar)
                ->limit(5)
                ->get();
        }
        
        return view('dashboard.admin', compact(
            'totalPemasukan', 'totalSiswa', 'totalKelas', 'totalOrtu',
            'pemasukanHariIni', 'pemasukanBulanIni', 'pemasukanTahunIni',
            'pembayaranPerJenis', 'siswaPerKelas', 'pembayaranTerbaru', 'tunggakan'
        ));
    }
    
    private function ortuDashboard()
    {
        $bulan = request('bulan', now()->month);
        $tahun = request('tahun', now()->year);
        
        $siswa = auth()->user()->siswa;
        
        return view('dashboard.ortu', compact('siswa', 'bulan', 'tahun'));
    }
    
    public function downloadPDF()
    {
        $bulan = request('bulan', now()->month);
        $tahun = request('tahun', now()->year);
        $user = auth()->user();
        $siswa = $user->siswa;
        
        $data = [
            'user' => $user,
            'siswa' => $siswa,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'periode' => \DateTime::createFromFormat('!m', $bulan)->format('F') . ' ' . $tahun
        ];
        
        $pdf = Pdf::loadView('dashboard.laporan-pdf', $data);
        
        return $pdf->download('Laporan-Pembayaran-' . $data['periode'] . '.pdf');
    }
}
